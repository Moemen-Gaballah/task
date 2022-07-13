<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('dashboard.reports.transactions.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function getTransactions(Transaction $transaction)
    {
        $data = Transaction::with(['fromUser', 'toUser'])->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('from', function($row){
                return $row->fromUser->name;
            })
            ->addColumn('to', function($row){
                return $row->toUser->name;
            })
            ->addColumn('created_at', function($row){
                return date('d-m-Y g:i A', strtotime($row->created_at));
            })
            ->rawColumns(['from', 'to'])
            ->make(true);
    }

}
