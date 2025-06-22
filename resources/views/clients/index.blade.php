@extends('layout.master')

<style>
    th {
        background-color: #FCFCFC !important;
        color: #6c757d !important;
        font-weight: 500 !important;
    }
    td {
        color: #868e96 !important;
        font-weight: 500 !important;
        padding: 16px 30px !important;
        text-align: start !important;
    }
    td a {
        background-color: #FCFCFC;
        padding: 8px 12px;
        border-radius: 25px;
        color: #868e96 !important;
        font-weight: 500 !important;
    }
    table {
        border-color: #FAFAFA !important;
    }
    .table-responsive {
        max-height: 385px;
        overflow-y: auto;
        margin-right: 0.5rem;
        padding-right: 20px;
    }
    .table thead th {
        position: sticky;
        top: 0;
        z-index: 1;
        background-color: #FCFCFC !important;
    }
    .table-responsive::-webkit-scrollbar {
        width: 6px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
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
            <div class="card position-relative border-0 rounded-4 shadow-sm bg-white" style="width:90%">
                <a href="{{ route('clients.create') }}" class="plus-times"><i class="fas fa-plus"></i></a>
                <div class="card-body mt-5">
                    <div class="table-responsive">
                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr>
                                    <th style="padding-left: 28px !important;">ID</th>
                                    <th>Nom</th>
                                    <th>Adresse</th>
                                    <th>Téléphone</th>
                                    <th style="padding-left: 40px !important;"><i class="fas fa-gear"></i></th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $client->full_name }}</td>
                                        <td>{{ $client->address }}</td>
                                        <td>{{ $client->phone }}</td>
                                        <td>
                                            <a href="{{ route('clients.edit', $client->id) }}"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
