<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('transactions.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function getTransactions(Transaction $transaction)
    {
        $data = Transaction::where('to', auth()->id())->orWhere('from', auth()->id())->with(['fromUser', 'toUser']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('type', function($row){
                return ($row->from == auth()->id()) ? 'Expense' : 'Income';
            })
            ->addColumn('from', function($row){
                return ($row->from == auth()->id()) ? 'Me' : $row->fromUser->name;
            })
            ->addColumn('to', function($row){
                return ($row->to == auth()->id()) ? 'Me' : $row->toUser->name;
            })
            ->addColumn('created_at', function($row){
                return date('d-m-Y g:i A', strtotime($row->created_at));
            })
            ->rawColumns(['type','from', 'to'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
        //
    }


}
