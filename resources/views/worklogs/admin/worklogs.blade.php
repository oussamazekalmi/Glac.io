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
        max-height: 310px;
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
        margin-bottom: 12px !important;
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
    .custom-checkbox {
        position: relative;
        display: inline-block;
        width: 24px;
        height: 24px;
        cursor: pointer;
    }
    .custom-checkbox input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }
    .custom-checkbox span {
        position: absolute;
        top: 0;
        left: 0;
        height: 18px;
        width: 18px;
        background-color: white;
        border: 2px solid #344264;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    .custom-checkbox input:checked + span {
        background-color: #344264;
        border-color: #344264;
    }
    .custom-checkbox span::after {
        content: '';
        position: absolute;
        display: none;
        left: 4px;
        top: 1px;
        width: 6px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    .custom-checkbox input:checked + span::after {
        display: block;
    }
    .btn {
        outline: none !important;
        border: none !important;
        box-shadow: none !important;
    }
    .modal-footer {
        border: none !important;
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
    }
    .modal-header{
        border: none !important;
        border-bottom: #344264 1px solid !important;
        padding-bottom: 1rem !important;
    }
</style>

@section('content')
    <main class="content py-2">
        <div class="container-fluid position-relative">
            <form action="{{ route('worklogs.update-status', $user->id) }}" method="post">
                <div class="card position-relative border-0 rounded-2 shadow-sm bg-white" style="width:90%">
                    <h5>Feuilles de présence</h5>
                    <a href="{{ url()->previous() }}" class="plus-times"><i class="fas fa-times"></i></a>

                    <div class="card-body mt-5 pb-2">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="user_id" value="{{ $user->id }}">

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
                                                ->translatedFormat('l j F Y');
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
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" name="worklog_ids[]" value="{{ $worklog->id }}">
                                                    <span class="mt-1"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr style="height: 22px !important;"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if (count($worklogs) >= 1)
                    <div style="position: absolute; bottom: -16%; right: 9.2%;">
                        <button type="button" class="btn py-2 px-4 rounded-3 me-3 mt-5" style="background-color: #344264; color: white; font-weight: 500;" data-bs-toggle="modal" data-bs-target="#confirmModal">
                            Confirmer
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </main>
@endsection

<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin-left: 36%;">
        <div class="modal-content" style="border-radius: 0;">
            <div class="modal-header mb-1">
                <h5 class="modal-title text-secondary ms-2 mt-0" id="confirmModalLabel">Confirmation</h5>
                <button type="button" class="btn btn-close" style="font-size: 12px;" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body ms-3 my-1" style="color: #344264;">
                Confirmer le paiement des heures sélectionnées
            </div>
            <div class="modal-footer mt-1">
                <button type="button" class="btn rounded-1 py-2 px-4" style="background-color: #344264; color: white;" onclick="document.querySelector('form').submit();">Confirmer</button>
            </div>
        </div>
    </div>
</div>
