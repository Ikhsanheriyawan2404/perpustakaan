<?php

namespace App\Http\Controllers;

use App\Models\{Book, Member, Bookloan};
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
                    ->addColumn('checkbox', function ($row) {
                        return '<input type="checkbox" name="checkbox" id="check" class="checkbox" data-id="' . $row->id . '">';
                    })
                    ->editColumn('member_id', function (Bookloan $bookloan) {
                        return $bookloan->member->name;
                    })
                    ->editColumn('book_id', function (Bookloan $bookloan) {
                        return $bookloan->book->title;
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->status == 1 && date('Y-m-d') < $row->date_of_return) {
                            $status = '<a class="badge badge-sm badge-warning">Dipinjam</a>';
                        } else if ($row->status == 1 && date('Y-m-d') > $row->date_of_return) {
                            $status = '<a class="badge badge-sm badge-danger">Telat</a>';
                        } else {
                            $status = '<a class="badge badge-sm badge-success">Dikembalikan</a>';
                        }
                        return $status;
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

        $member = Member::findOrFail(request('member_id'));
        $lastCreditCode = Bookloan::where('member_id', request('member_id'))->latest()->first()->credit_code ?? '000';
        $lastCodeId = preg_replace("/[^0-9]/", "", $lastCreditCode);
        $lastIncrement = substr($lastCodeId, -3);
        $codeCredit = str_replace(' ', '',strtoupper($member->name)) . str_pad($lastIncrement + 1, 3, 0, STR_PAD_LEFT);
        Bookloan::create(
            [
                'credit_code' => $codeCredit,
                'book_id' => request('book_id'),
                'member_id' => request('member_id'),
                'borrow_date' => request('borrow_date'),
                'date_of_return' => request('date_of_return'),
                'admin' => auth()->user()->name,
            ]);
    }

    public function deleteSelected()
    {
        $id = request('id');
        Bookloan::whereIn('id', $id)->delete();
        return response()->json(['code'=> 1, 'msg' => 'Data pinjaman buku berhasil dihapus']);
    }
}
