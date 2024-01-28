<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Book;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Carbon;  
use Illuminate\Support\Facades\Log;

class FeatureController extends Controller
{
    public function pinjam(Request $request, $id){
        $peminjaman = Peminjaman::where('user_id',auth()->user()->id)->where('book_id',$id);
        if ($peminjaman->exists()) {
            $request->session()->flash('alert', ['message' => 'Anda sudah meminjam buku ini', 'status' => 'warning']);
            return redirect('/peminjaman');
        }
        if(Peminjaman::where('user_id',auth()->user()->id)->count() >= 5){
            $request->session()->flash('alert', ['message' => 'Anda hanya bisa meminjam buku sejumlah maksimal 5', 'status' => 'warning']);
            return redirect('/peminjaman');
        }
        
        $pinjam = Peminjaman::create([
            'user_id' => auth()->user()->id,
            'book_id' => $id,
        ]);

        if($pinjam){
            $request->session()->flash('alert', ['message' => 'Peminjaman Berhasil', 'status' => 'success']);
        }
        return redirect('/peminjaman');
    }

    public function cancel(Request $request, $id){
        $peminjaman = Peminjaman::find($id);
        Gate::authorize('cancel', $peminjaman);
        $cancel = $peminjaman->delete();
        if($cancel > 0){
            $request->session()->flash('alert', ['message' => 'Peminjaman dihapus', 'status' => 'success']);
        }
        return redirect('/peminjaman');
    }

    public function confirm(Request $request, $id){
        //->update(['is_confirmed' => true, 'confirmed_at' => date("Y-m-d H:i:s")])
        $peminjaman = Peminjaman::find($id);
        $peminjaman->is_confirmed = true;
        $peminjaman->confirmed_at = Carbon::now();
        $peminjaman->expired_at = Carbon::now()->addWeeks(2)->endOfDay();
        $peminjaman->save();

        $peminjaman->book->decrement('stock');

        if($peminjaman){
            $request->session()->flash('alert', ['message' => 'Peminjaman dikonfirmasi', 'status' => 'success']);
        }
        return redirect('/peminjaman');
    }

    public function tambah(Request $request){
        $validated = $request->validate([
            'title' => ['required'],
            'author' => ['required'],
            'description' => ['required'],
            'content' => ['required','unique:books'],
            'stock' => ['required', 'min:1'],
            'cover' => ['required', 'image', 'file', 'max:5000']
        ]);
        $validated['cover'] = $validated['cover']->storePublicly('image','public');

        $request->session()->flash('alert', ['message' => 'Buku berhasil ditambahkan', 'status' => 'success']);
        Book::create($validated);
        return redirect('/');
    }

    public function update(Request $request,$id){
        $book = Book::where('id',$id)->update(['stock' => $request->stock]);
        if ($book) {
            $request->session()->flash('alert', ['message' => 'Jumlah buku diperbarui', 'status' => 'success']);
        }
       
        return redirect()->back();
    }

    public function delete(Request $request, $id){
        if(Peminjaman::where('book_id',$id)->exists()){
            $request->session()->flash('alert', ['message' => 'Buku tidak bisa dihapus, karena ada user yang sedang meminjam buku ini', 'status' => 'warning']);
            return redirect()->back();
        }
        Book::destroy($id);
        $request->session()->flash('alert', ['message' => 'Buku dihapus', 'status' => 'success']);
        return redirect('/');
    }

    public function read($id){
        $peminjaman = Peminjaman::find($id);
        Gate::authorize('read', $peminjaman);
        $book = $peminjaman->book;

        return view('read', ['book' => $book]);
    }

    public function perpanjang_peminjaman(Request $request,$id){
        $peminjaman = Peminjaman::find($id);
        $peminjaman->is_confirmed = false;
        $peminjaman->confirmed_at = null;
        $peminjaman->expired_at = null;

        $peminjaman->save();
        $request->session()->flash('alert', ['message' => 'Perpanjangan peminjaman sudah dilakukan, Tunggu persetujuan dari admin', 'status' => 'success']);
        return redirect('/peminjaman');
    }

    public function kembali(Request $request,$id){
        $peminjaman = Peminjaman::find($id);
        $peminjaman->book->increment('stock');

        $peminjaman->delete();
        $request->session()->flash('alert', ['message' => 'Buku sudah dikembalikan', 'status' => 'success']);
        return redirect('/peminjaman');

    }
}
