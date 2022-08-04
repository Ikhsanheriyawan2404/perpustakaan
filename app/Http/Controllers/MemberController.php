<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Member;
use App\Exports\MembersExport;
use App\Imports\MembersImport;
use App\Http\Requests\MemberRequest;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $members = Member::latest()->get();
            return DataTables::of($members)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" name="checkbox" id="check" class="checkbox" data-id="' . $row->id . '">';
                })
                ->editColumn('status', function ($row) {
                    return $row->status != 1 ? '<a class="badge badge-sm badge-danger">Danger <i class="fa fa-times-circle"></i></a>' : '<a class="badge badge-sm badge-success">Good <i class="fa fa-check-circle"></i></a>';
                })
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="btn-group">
                            <a class="badge badge-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" data-id="' . $row->id . '" id="showMember" class="btn btn-sm btn-primary">View</a>
                                <a class="dropdown-item" href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-sm" id="editMember">Edit</a>
                                <form action=" ' . route('members.destroy', $row->id) . '" method="POST">
                                    <button type="submit" class="dropdown-item" onclick="return confirm(\'Apakah yakin ingin menghapus ini?\')">Hapus</button>
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                </form>
                            </div>
                        </div>';
                    return $btn;
                })
                ->rawColumns(['status', 'checkbox', 'image', 'action'])
                ->make(true);
        }
        return view('members.index', [
            'title' => 'Data Anggota',
        ]);
    }

    public function show($id)
    {
        $member = Member::with('bookloan')->findOrFail($id);
        return response()->json($member);
    }
    public function store(MemberRequest $request)
    {
        $request->validated();

        $memberId = request('member_id');
        if ($memberId) {
            $member = Member::find($memberId);
            if (request('image')) {
                Storage::delete($member->image);
                $image = request()->file('image')->store('img/members');
            } else {
                $image = $member->image;
            }
        } else {
            $image = request('image') ? request()->file('image')->store('img/members') : null;
        }

        Member::updateOrCreate(
            ['id' => request('member_id')],
            [
                'name' => request('name'),
                'email' => request('email'),
                'phone_number' => request('phone_number'),
                'address' => request('address'),
                'gender' => request('gender'),
                'image' => $image,
            ]
        );
    }

    public function edit(Member $member)
    {
        return response()->json($member);
    }

    public function destroy(Member $member)
    {
        $member->delete();
        toast('Data anggota berhasil dihapus!', 'success');
        return back();
    }

    public function deleteSelected()
    {
        $id = request('id');
        Member::whereIn('id', $id)->delete();
        return response()->json(['code' => 1, 'msg' => 'Data anggota berhasil dihapus']);
    }

    public function import()
    {
        request()->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        Excel::import(new MembersImport, request()->file('file'));

        toast('Data anggota berhasil diimport!', 'success');
        return redirect()->route('members.index');
    }

    public function export()
    {
        return Excel::download(new MembersExport, time() . 'members.xlsx');
    }

    public function printPDF()
    {
        $members = Member::all();
        // $pdf = app('dompdf.wrapper');
        $pdf = PDF::loadView('members.pdf', compact('members'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
