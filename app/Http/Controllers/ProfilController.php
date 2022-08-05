<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:profil-module', ['only' => ['index', 'edit', 'store']]);
    }

    public function index()
    {
        return view('profils.index',[
            'title' => 'Data Profil Perpustakaan',
            'profil' => Profil::first(),
        ]);
    }

    public function store()
    {
        $profilId = request('profil_id');
        if ($profilId) {
            $profil = Profil::find($profilId);
            if (request('image')) {
                Storage::delete($profil->image);
                $image = request()->file('image')->store('img/profils');
            } else {
                $image = $profil->image;
            }
        } else {
            $image = request('image') ? request()->file('image')->store('img/profils') : null;
        }

        request()->validate(['name' => 'required|max:255']);
        Profil::updateOrCreate(['id' => request('profil_id')],[
            'name' => request('name'),
            'image' => $image,
        ]);
    }

    public function edit(Profil $profil)
    {
        return response()->json($profil);
    }
}
