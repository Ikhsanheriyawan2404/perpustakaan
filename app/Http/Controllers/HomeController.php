<?php

namespace App\Http\Controllers;

use App\Models\{Book, Booklocation, Member};

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard', [
            'title' => 'Dashboard',
            'books' => Book::all(),
            'members' => Member::all(),
        ]);
    }

    public function listbook()
    {
        $search_query = request('search_query');
        return view('home', [
            'title' => 'Daftar Buku',
            'books' => Book::with(['booklocation', 'bookloan'])->where("title", "like", "%$search_query%")->orWhere("booklocation_id", "like", "%$search_query%")->latest()->paginate(24),
            'booklocations' => Booklocation::get(),
        ]);
    }
}
