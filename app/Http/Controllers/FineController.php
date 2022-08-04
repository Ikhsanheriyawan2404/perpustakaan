<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;

class FineController extends Controller
{
    public function index()
    {
        return view('fine.index', [
            'title' => 'Data Denda',
            'fine' => Fine::first(),
        ]);
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $fine = Fine::find(request('pk'));
            $fine->update([
                'nominal' => request('value'),
            ]);

            return response()->json(['code'=> 1, 'msg' => 'Data buku berhasil dihapus']);
        }
    }
}
