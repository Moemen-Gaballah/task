@extends('layouts.app')
@section('style')
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css" />

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><span style="font-size: 18px; margin: auto; line-height: 2">all transactions</span> <span style="float: right"><a class="btn btn-primary" href="{{route('transactions.create')}}">new transfer</a> </span> </div>

                <div class="card-body">
                    <table class="table table-bordered data-table">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>type</th>
                            <th>from</th>
                            <th>to</th>
                            <th>amount</th>
                            <th>created_at</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>



        $(function () {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('transactions.list') }}",
                columns: [
                    {"data": 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'type', name: 'type'},
                    {data: 'from', name: 'fromUser.name'},
                    {data: 'to', name: 'toUser.name'},
                    {data: 'amount', name: 'amount'},
                    {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                ]
            });

        });




        @if (Session::has('success'))
            new Notify ({
                status: 'success',
                title: 'Success',
                text: '{{ Session::get('success') }}',
                effect: 'fade',
                speed: 300,
                customClass: '',
                customIcon: '',
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 3000,
                gap: 20,
                distance: 20,
                type: 3,
                position: 'right top'
            })
        @endif
    </script>
@endsection
