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
            $confirmed = Peminjaman::where('user_id', auth()->user()->id)->where('is_confirmed',true)->whereDate('expired_at', '>=', Carbon::now())->get();
            $notConfirmed = Peminjaman::where('user_id', auth()->user()->id)->where('is_confirmed',false)->get();
            $expired = Peminjaman::where('user_id', auth()->user()->id)->where('is_confirmed',true)->whereDate('expired_at', '<', Carbon::now())->get();

            return view('peminjaman',['confirmed' => $confirmed, 'notConfirmed' => $notConfirmed, 'expired' => $expired]);
        }

        if(Gate::allows('admin')){
            $confirmed = Peminjaman::where('is_confirmed',true)->whereDate('expired_at', '>=', Carbon::now())->get();
            $notConfirmed = Peminjaman::where('is_confirmed',false)->get();
            $expired = Peminjaman::where('is_confirmed',true)->whereDate('expired_at', '<', Carbon::now())->get();


            return view('peminjaman',['confirmed' => $confirmed, 'notConfirmed' => $notConfirmed, 'expired' => $expired]);
        }

    }

    public function viewTambah(){
        return view('tambah');
    }
}
