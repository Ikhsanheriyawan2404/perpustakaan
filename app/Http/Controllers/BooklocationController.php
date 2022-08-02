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
                        '<div class="d-flex justify-content-center">

                            <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-primary btn-sm mr-2" id="editItem"><i class="fas fa-pencil-alt"></i></a>

                            <form action=" ' . route('booklocations.destroy', $row->id) . '" method="POST">
                               <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah yakin ingin menghapus ini?\')"><i class="fas fa-trash"></i></button>
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                           </form>
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
