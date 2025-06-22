@extends('layout.master')

<style>
    th {
        color: #6c757d !important;
        font-weight: 500 !important;
    }
    td {
        background-color: #FCFCFC !important;
        color: #868e96 !important;
        font-weight: 500 !important;
        padding: 16px 0px 16px 40px !important;
        text-align: start !important;
    }
    table {
        width: 90% !important;
    }
    .card {
        margin: 0 auto;
        background-color: white !important;
        width: 90%;
    }
    label, .btn {
        font-weight: 500 !important;
    }
    .btn {
        padding: 13px !important;
        font-size: 14px !important;
        background-color: #344264 !important;
        border-radius: 0 8px 8px 0 !important;
    }
    .form-control {
        background-color: #FAFAFA !important;
        font-weight: 500 !important;
        border: 1px solid #f9f9f9 !important;
        border-radius: 8px 0 0 8px !important;
        padding: 10px !important;
    }
    h5 {
        font-size: 17px !important;
    }
    .table-responsive {
        max-height: 420px;
        overflow-y: auto;
        margin-right: 1rem;
        padding-right: 0px;
    }
    .table thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }
    .table-responsive::-webkit-scrollbar {
        width: 6px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
        margin-top: 84px !important;
        margin-bottom: 8px !important;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #999;
    }
</style>

@section('content')
    <main class="content py-5">
        <div class="container-fluid">
            <div class="card position-relative border-0 rounded-2 shadow-sm bg-white" style="width:90%">

                <div class="card-body ms-5">
                    <div class="table-responsive pe-3">
                        <table class="table table-borderless mt-4">
                            <thead>
                                <tr>
                                    <th>Employé</th>
                                    <th>Date</th>
                                    <th>Quantité en kg</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="height: 22px;"></tr>

                                @foreach ($iceCubes as $drop)
                                    <tr>
                                        <td>{{ $drop->user->name }}</td>
                                        <td>{{ $drop->date }}</td>
                                        <td>{{ $drop->kg }} kg</td>
                                    </tr>
                                    <tr style="height: 16px;"></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

