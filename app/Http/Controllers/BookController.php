<?php

namespace App\Http\Controllers;

use PDF;
use App\Exports\BooksExport;
use App\Imports\BooksImport;
use App\Http\Requests\BookRequest;
use App\Models\{Book, Booklocation};
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:book-module', ['only' => ['index','show', 'store', 'edit', 'update', 'destroy', 'printPDF', 'export', 'import', 'deleteSelected']]);
        $this->middleware('permission:book-trash', ['only' => ['deleteAll', 'deletePermanent', 'restore', 'trash']]);
    }

    public function index()
    {
        if (request()->ajax()) {
            $books = Book::with('booklocation')->latest()->get();
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
                                <a class="dropdown-item" href="javascript:void(0)" data-id="'.$row->id.'" id="showBook" class="btn btn-sm btn-primary">View</a>
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

    public function show(Book $book)
    {
        return response()->json($book);
    }

    public function store(BookRequest $request)
    {
        $request->validated();

        $bookId = request('book_id');
        if ($bookId) {
            $book = Book::find($bookId);
            if (request('image')) {
                if ($book->image != 'img/books/default.jpg') {
                    Storage::delete($book->image);
                    $image = request()->file('image')->store('img/books');
                }
                $image = request()->file('image')->store('img/books');
            } else {
                $image = $book->image;
            }
        } else {
            $image = request('image') ? request()->file('image')->store('img/books') : 'img/books/default.jpg';
        }

        $book = Book::updateOrCreate(
            ['id' => request('book_id')],[
                'title' => request('title'),
                'isbn' => request('isbn'),
                'author' => request('author'),
                'publisher' => request('publisher'),
                'publish_year' => request('publish_year'),
                'quantity' => request('quantity'),
                'price' => request('price'),
                'description' => request('description'),
                'booklocation_id' => request('booklocation_id'),
                'image' => $image,
            ]);
    }

    public function edit(Book $book)
    {
        return response()->json($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        toast('Data buku berhasil dihapus!','success');
        return back();
    }

    public function deleteSelected()
    {
        $id = request('id');
        Book::whereIn('id', $id)->delete();
        return response()->json(['code'=> 1, 'msg' => 'Data buku berhasil dihapus']);
    }

    public function import()
    {
        request()->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        Excel::import(new BooksImport, request()->file('file'));

        toast('Data buku berhasil diimport!', 'success');
        return redirect()->route('books.index');
    }

    public function export()
    {
        return Excel::download(new BooksExport, time() . 'books.xlsx');
    }

    public function printPDF()
    {
        $books = Book::all();
        // $pdf = app('dompdf.wrapper');
        $pdf = PDF::loadView('books.pdf', compact('books'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function trash()
    {
        $books = Book::onlyTrashed()->with('booklocation')->get();
        return view('books.trash', [
            'title' => 'Data Sampah Buku',
            'books' => $books,
        ]);
    }

    public function restore($id)
    {
        $book = Book::onlyTrashed()->where('id', $id);
        $book->restore();
        toast('Data buku berhasil dipulihkan!', 'success');
        return redirect()->back();
    }

    public function deletePermanent($id)
    {
        $book = Book::onlyTrashed()->where('id', $id);
        $book->forceDelete();

        toast('Data buku berhasil dihapus permanen!', 'success');
        return redirect()->back();
    }

    public function deleteAll()
    {
        $books = Book::onlyTrashed();
        $books->forceDelete();

        toast('Semua data buku berhasil dihapus permanen!', 'success');
        return redirect()->back();
    }
}
