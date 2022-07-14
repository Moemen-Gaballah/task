<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactionAnalytics = \Cache::remember('transactionStatus', 60*60*24, function () {
            return Transaction::select('status', \DB::raw('count(*) as total'))
                ->groupBy('status')->get();
        });

        return view('dashboard.reports.transactions.index', compact('transactionAnalytics'));
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
