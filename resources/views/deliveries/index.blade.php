@extends('layout.master')

<style>
    th {
        color: #6c757d !important;
        font-weight: 500 !important;
        padding-left: 28px !important;
    }
    td {
        background-color: #FAFAFA !important;
        color: #868e96 !important;
        font-weight: 500 !important;
        padding: 16px 0px 16px 30px !important;
        text-align: start !important;
    }
    td a {
        background-color: white;
        padding: 8px 12px;
        border-radius: 25px;
        color: #868e96 !important;
        font-weight: 500 !important;
    }
    table {
        width: 96% !important;
    }
    .table-responsive {
        max-height: 425px;
        overflow-y: auto;
        margin-right: 0.5rem;
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
        margin-bottom: 12px !important;
        margin-right: 12px !important;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #999;
    }
    .span {
        color: white;
        font-size: 12px;
    }
    .statistics {
        font-weight: 500;
        transition: all 0.5s ease-in-out;
    }
   .statistics .statistics-icon {
        transition: all 0.5s ease-in-out;
    }
    .statistics:hover {
        padding: 8px 20px 8px 60px !important;
    }
    .statistics:hover .statistics-icon {
        color: white !important;
        background-color: #344264 !important;
        padding: 12px 18px !important;
    }
</style>

@section('content')
    <main class="content py-4">
        <div class="container-fluid">
            <div class="card position-relative border-0 rounded-0 rounded-bottom-4 shadow-sm bg-white" style="width:90%">
                <a href="{{ route('deliveries.create', ['paid' => $isPaid ? 'yes' : 'no']) }}" class="plus-times" style="right: 7%;"><i class="fas fa-plus"></i></a>
                <a href="{{ route('deliveries.statistics') }}" class="position-relative rounded-end-2 text-center statistics" style="text-decoration: none;background-color: #FAFAFA; color: #344264; padding: 8px 0; width: 170px;">
                    Statistiques
                    <span class="rounded-end-5 statistics-icon" style="position: absolute; top:0; left:0; color: #FAFAFA; background-color: #FAFAFA; padding: 0;">
                        <i class="fas fa-calculator" style="font-size: 16px;"></i>
                    </span>
                </a>

                <div class="card-body">
                    <div class="table-responsive pe-3">
                        <table class="table table-borderless mt-4">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Livré à</th>
                                    <th>Quantité livré</th>
                                    <th>
                                        Paiement effectué
                                        <a href="{{ route('deliveries.index', ['paid' => $isPaid ? 'no' : 'yes']) }}" class="text-secondary ms-3">
                                            <i class="fas {{ $isPaid ? 'fa-sort-amount-up' : 'fa-sort-amount-down' }}"></i>
                                        </a>
                                    </th>
                                    <th style="padding-left: 40px !important;"><i class="fas fa-gear"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="height: 22px;"></tr>
                                @php $i = 1; @endphp
                                @foreach ($deliveries as $delivery)
                                    <tr>
                                        <td style="text-align: center;">{{ $i++ }}</td>
                                        <td>{{ $delivery->client->full_name }}</td>
                                        <td>{{ $delivery->glacons_kg }}</td>
                                        <td>
                                            <span class="position-relative" style="background-color: white; padding: 5px 30px 5px 40px;">
                                                {{ $delivery->is_paid ? 'Oui' : 'Non' }}
                                                <span class="rounded-bottom-4" style="position: absolute; top:0; left:0; background-color: #344264; padding: 6px;">
                                                    <i class="fas {{ $isPaid ? 'fa-check' : 'fa-times' }} span"></i>
                                                </span>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('deliveries.edit', ['id' => $delivery->id, 'paid' => $isPaid ? 'yes' : 'no']) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
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
