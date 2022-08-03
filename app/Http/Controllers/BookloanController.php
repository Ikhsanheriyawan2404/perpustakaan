<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Bookloan;
use App\Http\Requests\BookloanRequest;
use Yajra\DataTables\Facades\DataTables;

class BookloanController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $bookloans = Bookloan::latest()->get();
            return DataTables::of($bookloans)
                    ->addIndexColumn()
                    ->editColumn('member_id', function (Bookloan $bookloan) {
                        return $bookloan->member->name;
                    })
                    ->editColumn('book_id', function (Bookloan $bookloan) {
                        return $bookloan->book->title;
                    })
                    ->addColumn('status', function ($row) {
                        return date('Y-m-d') > $row->date_of_return ? '<a class="badge badge-sm badge-danger">Telat</a>' : '<a class="badge badge-sm badge-success">Dipinjam</a>';
                    })
                    ->addColumn('action', function($row){
                        $btn =
                        '<div class="btn-group">
                            <a class="badge badge-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" data-id="'.$row->id.'" id="showMember" class="btn btn-sm btn-primary">Print</a>
                                <a class="dropdown-item" href="javascript:void(0)" data-id="'.$row->id.'" id="showMember" class="btn btn-sm btn-primary">View</a>
                            </div>
                        </div>';
                        return $btn;
                    })
                    ->rawColumns(['status', 'checkbox', 'image', 'action'])
                    ->make(true);
        }
        return view('bookloans.index',[
            'title' => 'Data Peminjaman',
            'books' => Book::all(),
            'members' => Member::all(),
        ]);
    }

    public function store(BookloanRequest $request)
    {
        $request->validated();

        Bookloan::updateOrCreate(
            ['id' => request('bookloan_id')],
            [
                'book_id' => request('book_id'),
                'member_id' => request('member_id'),
                'borrow_date' => request('borrow_date'),
                'date_of_return' => request('date_of_return'),
            ]);
    }

    public function edit(Bookloan $bookloan)
    {
        return response()->json($bookloan);
    }

    public function destroy(Bookloan $bookloan)
    {
        $bookloan->delete();
        toast('Data peminjaman buku berhasil dihapus!','success');
        return back();
    }
}
