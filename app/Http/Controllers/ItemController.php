<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Yajra\DataTables\Facades\DataTables;


class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:item-list|item-create|item-edit|item-delete', ['only' => ['index','show']]);
        $this->middleware('permission:item-create', ['only' => ['create','store']]);
        $this->middleware('permission:item-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:item-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        if (request()->ajax()) {
            $items = Item::latest()->get();
            return DataTables::of($items)
                    ->addIndexColumn()
                    ->editColumn('category', function (Item $item) {
                        return $item->category->name;
                    })
                    ->addColumn('checkbox', function ($row) {
                        return '<input type="checkbox" name="checkbox" id="check" class="checkbox" data-id="' . $row->id . '">';
                    })
                    ->addColumn('action', function($row){
                        $btn =
                        '<div class="d-flex justify-content-between">

                            <a href="javascript:void(0)" data-id="'.$row->id.'" id="showItem" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>


                            <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-primary btn-sm" id="editItem"><i class="fas fa-pencil-alt"></i></a>

                            <form action=" ' . route('items.destroy', $row->id) . '" method="POST">
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
        return view('items.index',[
            'title' => 'Data Barang',
            'categories' => Category::all()
        ]);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required|max:255',
            'price' => 'required|max:255',
            'quantity' => 'required|max:255',
            'description' => 'max:255',
            'category_id' => 'required',
        ]);

        Item::updateOrCreate(
            ['id' => request('item_id')],
            [
                'name' => request('name'),
                'price' => request('price'),
                'quantity' => request('quantity'),
                'description' => request('description'),
                'category_id' => request('category_id'),
            ]);
    }

    public function edit(Item $item)
    {
        return response()->json($item);
    }

    public function destroy(Item $item)
    {
        $item->delete();
        toast('Data barang berhasil dihapus!','success');
        return back();
    }

    public function deleteSelected()
    {
        $id = request('id');
        Item::whereIn('id', $id)->delete();
        return response()->json(['code'=> 1, 'msg' => 'Data item berhasil dihapus']);
    }
}
