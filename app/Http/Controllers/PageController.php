<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class PageController extends Controller
{
    public function home(){
        $books = Book::all();
        return view('home',['books' => $books]);
    }

    public function detail($id){
        $book = Book::find($id);
        return view('detail',['book' => $book]);
    }

    public function peminjaman(){
        if(Gate::denies('admin')){
            $confirmed = Peminjaman::where('user_id', auth()->user()->id)->where('is_confirmed',true)->whereDate('confirmed_at', '>', Carbon::now()->subWeeks(2)->startOfDay())->get();
            $notConfirmed = Peminjaman::where('user_id', auth()->user()->id)->where('is_confirmed',false)->get();
            Log::info(auth()->user()->id);
            //Log::info(var_dump($peminjamanUser));
            Log::info($confirmed);
            Log::info($notConfirmed);
            return view('peminjaman',['confirmed' => $confirmed, 'notConfirmed' => $notConfirmed]);
        }

        if(Gate::allows('admin')){
            $confirmed = Peminjaman::where('is_confirmed',true)->whereDate('confirmed_at', '>=', Carbon::now()->subWeeks(2))->get();
            $notConfirmed = Peminjaman::where('is_confirmed',false)->get();
            Log::info($confirmed);
            Log::info($notConfirmed);
            return view('peminjaman',['confirmed' => $confirmed, 'notConfirmed' => $notConfirmed]);
        }

    }

    public function viewTambah(){
        return view('tambah');
    }
}
