<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $categories = Category::get();
            return DataTables::of($categories)
                    ->addIndexColumn()
                    ->addColumn('checkbox', function ($row) {
                        return '<input type="checkbox" name="checkbox" id="check" class="checkbox" data-id="' . $row->id . '">';
                    })
                    ->addColumn('action', function($row){
                        $btn =
                        '<div class="d-flex justify-content-center">

                            <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-primary btn-sm mr-2" id="editItem"><i class="fas fa-pencil-alt"></i></a>

                            <form action=" ' . route('categories.destroy', $row->id) . '" method="POST">
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
        return view('categories.index',[
            'title' => 'Data Kategori'
        ]);
    }

    public function store()
    {
        Category::updateOrCreate(['id' => request('category_id')],
            ['name' => request('name')]);
    }

    public function edit(Category $category)
    {
        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        toast('Data kategori berhasil dihapus!', 'success');
        return redirect()->back();
    }

    public function deleteSelected()
    {
        $id = request('id');
        Category::whereIn('id', $id)->delete();
        return response()->json(['code'=> 1, 'msg' => 'Data kategori berhasil dihapus']);
    }
}
