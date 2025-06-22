@extends('layout.master')

<style>
    td {
        color: #868e96 !important;
        background-color: #FAFAFA !important;
        font-weight: 500 !important;
        padding: 16px !important;
    }
    td a, .id {
        color: #344264 !important;
        background-color: white !important;
        padding: 10px 12px;
        border-radius: 25px;
        font-weight: 500 !important;
    }
    td a i {
        font-size: 18px !important;
    }
    .table {
        width: 90% !important;
        margin-left: 2rem !important;
    }
    .table-responsive {
        max-height: 375px;
        overflow-y: auto;
        margin-right: 0.5rem;
        padding-right: 0px;
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
        margin-top: 0px !important;
        margin-bottom: 20px !important;
        margin-left: 0px !important;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #999;
    }
    h5 {
        color: #344264 !important;
        font-weight: 400 !important;
        margin-left: 3rem !important;
        margin-top: 2rem !important;
    }
</style>

@section('content')
    <main class="content py-3">
        <div class="container-fluid">
            <div class="card position-relative border-0 rounded-2 shadow-sm bg-white" style="width:90%">
                <h5>Feuilles de présence</h5>
                <a href="{{ route('worklogs.overview', $user->id) }}" class="plus-times"><i class="fas fa-times"></i></a>
                <div class="card-body mt-5">
                    <div class="table-responsive">
                        <table class="table table-borderless text-center">
                            <tbody>
                                @php $i = 1; @endphp

                                @foreach ($worklogs as $worklog)
                                    @php
                                        $hours = floor($worklog->hours_worked);
                                        $minutes = ($worklog->hours_worked - $hours) * 60;
                                        $formattedDate = \Carbon\Carbon::parse($worklog->work_date)
                                            ->locale('fr')
                                            ->translatedFormat('l j F Y'); // e.g., lundi 31 mai 2025
                                    @endphp
                                    <tr>
                                        <td class="id">{{ $i++ }}</td>
                                        <td>
                                            {{ $hours }}h
                                            @if (round($minutes) > 0)
                                                {{ ' ' . round($minutes) }}min
                                            @endif
                                        </td>
                                        <td>Le {{ $formattedDate }}</td>
                                        <td>
                                            {{ $worklog->is_paid ? 'Déjà réglé' : 'En attente de paiement' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('worklogs.edit', $worklog->id) }}"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <tr style="height: 22px !important;"></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
