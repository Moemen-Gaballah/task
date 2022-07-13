<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\User;
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
        // TODO Select Ajax with pagination for performance
        $users = User::select('id', 'name')->get();

        return view('transactions.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
        // Validation
        $amountErrorMsg = $this->validateTransferBalance($request->all());
        if(!is_null($amountErrorMsg)){
            return back()->withErrors(['amount' => $amountErrorMsg]);
        }

        Transaction::create([
           'from' => auth()->id(),
           'to' => $request->user_id,
           'amount' => $request->amount,
        ]);

    }

    protected function validateTransferBalance($data){
        $amountMsg = null;
        $balance = auth()->user()->balance;
        $totalTransferLastHour = Transaction::where('from', auth()->id())->where('created_at', '>=', \Carbon\Carbon::now()->subHour())->sum('amount');
        $totalTransfer = $data['amount'] + $totalTransferLastHour;

        if($balance < $data['amount'])
            return $amountMsg = 'sorry, your balance less than amount';


        if($totalTransfer > User::MAX_Transfer)
            return $amountMsg = 'sorry, try again after one hour';

        return $amountMsg;
    }


}
