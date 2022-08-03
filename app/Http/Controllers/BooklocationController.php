<?php

namespace App\Http\Controllers;

use App\Models\Booklocation;
use Yajra\DataTables\Facades\DataTables;

class BooklocationController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $bookLocation = Booklocation::all();
            return DataTables::of($bookLocation)
                    ->addIndexColumn()
                    ->addColumn('checkbox', function ($row) {
                        return '<input type="checkbox" name="checkbox" id="check" class="checkbox" data-id="' . $row->id . '">';
                    })
                    ->addColumn('action', function($row){
                        $btn =
                        '<div class="btn-group">
                            <a class="badge badge-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-primary btn-sm" id="editBooklocation">Edit</a>
                                <form action=" ' . route('booklocations.destroy', $row->id) . '" method="POST">
                                    <button type="submit" class="dropdown-item" onclick="return confirm(\'Apakah yakin ingin menghapus ini?\')">Hapus</button>
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                </form>
                            </div>
                        </div>';

                        return $btn;
                    })
                    ->rawColumns(['checkbox', 'action'])
                    ->make(true);
        }
        return view('booklocation.index',[
            'title' => 'Data Lokasi Buku'
        ]);
    }

    public function store()
    {
        request()->validate(['name' => 'required']);
        Booklocation::updateOrCreate(['id' => request('booklocation_id')],
            ['name' => request('name')]);
    }

    public function edit(Booklocation $booklocation)
    {
        return response()->json($booklocation);
    }

    public function destroy(Booklocation $booklocation)
    {
        $booklocation->delete();
        toast('Data lokasi buku berhasil dihapus!', 'success');
        return redirect()->back();
    }

    public function deleteSelected()
    {
        $id = request('id');
        Booklocation::whereIn('id', $id)->delete();
        return response()->json(['code'=> 1, 'msg' => 'Data lokasi buku berhasil dihapus']);
    }
}
