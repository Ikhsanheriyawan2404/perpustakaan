<?php

namespace App\Http\Controllers;

use PDF;
use DateTime;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BookloanRequest;
use App\Models\{Book, Member, Bookloan, Fine, Profil};
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class BookloanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:bookloan-module', ['only' => ['index', 'show', 'store', 'edit', 'update', 'destroy', 'printPDF', 'export', 'import', 'deleteSelected']]);
        $this->middleware('permission:bookloan-trash', ['only' => ['deleteAll', 'deletePermanent', 'restore', 'trash']]);
    }

    public function index()
    {
        if (request()->ajax()) {
            $bookloans = Bookloan::with(['member', 'book'])->latest()->get();
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
                        if ($row->status == 1 && \Carbon\Carbon::now() < $row->date_of_return) {
                            $status = '<a class="badge badge-sm badge-warning">
                            Dipinjam</a>';
                        } else if ($row->status == 1 && \Carbon\Carbon::now() > $row->date_of_return) {
                            $status = '<a class="badge badge-sm badge-danger">Telat</a>';
                        } else if($row->status == 2) {
                            $status = '<a class="badge badge-sm badge-success">Dikembalikan</a>';
                        }
                        return $status;
                    })
                    ->addColumn('fine', function ($row) {
                        if ($row->status == 1 && date('Y-m-d') > $row->date_of_return) {
                            $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
                            $dateOfReturn = \Carbon\Carbon::parse($row->date_of_return);
                            $interval = $dateOfReturn->diffInDays($currentDate);
                            $result = $interval * Fine::first()->nominal;
                        } else {
                            $result = 0;
                        }
                        return number_format($result);
                    })
                    ->addColumn('action', function($row){
                        $btn =
                        '<div class="btn-group">
                            <a class="badge badge-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" data-id="'.$row->id.'" id="showBookLoan" class="btn btn-sm btn-primary">View</a>
                                <form target="_blank" action="' . route('bookloans.printPdf', $row->id) . '" method="post">
                                    ' . csrf_field() . '
                                    <button type="submit" class="dropdown-item" class="btn btn-sm btn-primary">Print</button>
                                </form>
                                <form action="' . route('bookloans.processLoan', $row->id) . '" method="post">
                                    ' . csrf_field() . '
                                    <button type="submit" class="dropdown-item" class="btn btn-sm btn-primary">Proses Pengembalian</button>
                                </form>
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

    public function show($id)
    {
        $bookloan = Bookloan::with(['member', 'book'])->findOrFail($id);
        return response()->json($bookloan);
    }

    public function store(BookloanRequest $request)
    {
        $request->validated();

        $member = Member::findOrFail(request('member_id'));
        $lastCreditCode = Bookloan::where('member_id', request('member_id'))->latest()->first()->credit_code ?? '000';
        $lastCodeId = preg_replace("/[^0-9]/", "", $lastCreditCode);
        $lastIncrement = substr($lastCodeId, -3);
        $codeCredit = str_replace(' ', '',strtoupper($member->name)) . str_pad($lastIncrement + 1, 3, 0, STR_PAD_LEFT);

        DB::beginTransaction();

        try {
            Bookloan::create(
                [
                    'credit_code' => $codeCredit,
                    'book_id' => request('book_id'),
                    'member_id' => request('member_id'),
                    'borrow_date' => request('borrow_date'),
                    'date_of_return' => request('date_of_return'),
                    'admin' => auth()->user()->name,
                ]);
            $book = Book::find(request('book_id'));
            $book->decrement('quantity');
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            toast($e->getMessage(), 'danger');
        }
    }

    public function deleteSelected()
    {
        $id = request('id');
        Bookloan::whereIn('id', $id)->delete();
        return response()->json(['code'=> 1, 'msg' => 'Data pinjaman buku berhasil dihapus']);
    }

    public function processLoan(Bookloan $bookloan)
    {
        try {
            $bookloan->update([
                'status' => 2,
            ]);
            $book = Book::find($bookloan->book_id);
            $book->increment('quantity');
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            toast($e->getMessage(), 'danger');
        }

        toast('Pengembalian buku pinjaman berhasil diproses!', 'success');
        return redirect()->back();
    }

    public function printPdf(Bookloan $bookloan)
    {
        // $pdf = app('dompdf.wrapper');
        $customPaper = array(0,0,360,360);
        $fineNominal = Fine::first()->nominal;
        $profil = Profil::first();
        $pdf = PDF::loadView('bookloans.pdf', compact('bookloan', 'fineNominal', 'profil'))->setPaper('a5', 'landscape');
        return $pdf->stream();
    }

    public function trash()
    {
        $bookloans = Bookloan::onlyTrashed()->with(['member', 'book'])->get();
        return view('bookloans.trash', [
            'title' => 'Data Sampah Pinjaman Buku',
            'bookloans' => $bookloans,
        ]);
    }

    public function restore($id)
    {
        $bookloan = Bookloan::onlyTrashed()->where('id', $id);
        $bookloan->restore();
        toast('Data pinjaman buku berhasil dipulihkan!', 'success');
        return redirect()->back();
    }

    public function deletePermanent($id)
    {
        $bookloan = Bookloan::onlyTrashed()->where('id', $id);
        $bookloan->forceDelete();

        toast('Data pinjaman buku berhasil dihapus permanen!', 'success');
        return redirect()->back();
    }

    public function deleteAll()
    {
        $booklaons = Bookloan::onlyTrashed();
        $booklaons->forceDelete();

        toast('Semua data pinjaman buku berhasil dihapus permanen!', 'success');
        return redirect()->back();
    }
}
