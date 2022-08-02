<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $accounts = Account::all();
            return DataTables::of($accounts)
                    ->addIndexColumn()
                    ->addColumn('checkbox', function ($row) {
                        return '<input type="checkbox" name="checkbox" id="check" class="checkbox" data-id="' . $row->id . '">';
                    })
                    ->addColumn('action', function($row){
                        $btn =
                        '<div class="d-flex justify-content-center">

                            <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-primary btn-sm mr-2" id="editItem"><i class="fas fa-pencil-alt"></i></a>

                            <form action=" ' . route('accounts.destroy', $row->id) . '" method="POST">
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
        return view('accounts.index',[
            'title' => 'Data Akun'
        ]);
    }

    public function store()
    {
        Account::updateOrCreate(
            ['id' => request('account_id')],
            [
                'code' => request('code'),
                'name' => request('name'),
                'description' => request('description'),
            ]);
    }

    public function edit(Account $account)
    {
        return response()->json($account);
    }

    public function destroy(Account $account)
    {
        $account->delete();
        toast('Data kategori berhasil dihapus!', 'success');
        return redirect()->back();
    }

    public function deleteSelected()
    {
        $id = request('id');
        Account::whereIn('id', $id)->delete();
        return response()->json(['code'=> 1, 'msg' => 'Data akun berhasil dihapus']);
    }
}
