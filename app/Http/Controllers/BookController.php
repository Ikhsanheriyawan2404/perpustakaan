<?php

namespace App\Http\Controllers;

use App\Imports\BooksImport;
use App\Http\Requests\BookRequest;
use App\Models\{Book, Booklocation};
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;


class BookController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:book-list|book-create|book-edit|book-delete', ['only' => ['index','show']]);
    //     $this->middleware('permission:book-create', ['only' => ['create','store']]);
    //     $this->middleware('permission:book-edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:book-delete', ['only' => ['destroy']]);
    // }

    public function index()
    {
        if (request()->ajax()) {
            $books = Book::latest()->get();
            return DataTables::of($books)
                    ->addIndexColumn()
                    ->editColumn('booklocation', function (Book $book) {
                        return $book->booklocation->name;
                    })
                    ->addColumn('checkbox', function ($row) {
                        return '<input type="checkbox" name="checkbox" id="check" class="checkbox" data-id="' . $row->id . '">';
                    })
                    ->addColumn('action', function($row){
                        $btn =

                        '<div class="btn-group">
                            <a class="badge badge-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" data-id="'.$row->id.'" id="showbook" class="btn btn-sm btn-primary">View</a>
                                <a class="dropdown-item" href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-primary btn-sm" id="editBook">Edit</a>
                                <form action=" ' . route('books.destroy', $row->id) . '" method="POST">
                                    <button type="submit" class="dropdown-item" onclick="return confirm(\'Apakah yakin ingin menghapus ini?\')">Hapus</button>
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                </form>
                            </div>
                        </div>';
                        return $btn;
                    })
                    ->rawColumns(['checkbox', 'image', 'action'])
                    ->make(true);
        }
        return view('books.index',[
            'title' => 'Data Buku',
            'booklocation' => Booklocation::all()
        ]);
    }

    public function store(BookRequest $request)
    {
        $request->validated();

        $bookId = request('book_id');
        if ($bookId) {
            $book = Book::find($bookId);
            if (request('image')) {
                Storage::delete($book->image);
                $image = request()->file('image')->store('img/books');
            } else {
                $image = $book->image;
            }
        } else {
            $image = request('image') ? request()->file('image')->store('img/books') : null;
        }

        Book::updateOrCreate(
            ['id' => request('book_id')],
            [
                'title' => request('title'),
                'quantity' => request('quantity'),
                'description' => request('description'),
                'image' => $image,
                'booklocation_id' => request('booklocation_id'),
            ]);
    }

    public function edit(Book $book)
    {
        return response()->json($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        toast('Data barang berhasil dihapus!','success');
        return back();
    }

    public function deleteSelected()
    {
        $id = request('id');
        Book::whereIn('id', $id)->delete();
        return response()->json(['code'=> 1, 'msg' => 'Data book berhasil dihapus']);
    }

    public function import()
    {
        request()->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        Excel::import(new BooksImport, request()->file('file')->store('file'));

        toast('Data buku berhasil diimport!', 'success');
        return redirect()->route('books.index');
    }
}
