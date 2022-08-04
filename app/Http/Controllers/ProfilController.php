<?php

namespace App\Http\Controllers;

use App\Models\Profil;

class ProfilController extends Controller
{
    public function index()
    {
        return view('profils.index',[
            'title' => 'Data Profil Perpustakaan',
            'profil' => Profil::first(),
        ]);
    }

    public function store()
    {
        request()->validate(['name' => 'required|max:255']);
        Profil::updateOrCreate(['id' => request('profil_id')],[
            'name' => request('name'),
            'image' => request('image'),
        ]);
    }

    public function edit(Profil $profil)
    {
        return response()->json($profil);
    }
}
