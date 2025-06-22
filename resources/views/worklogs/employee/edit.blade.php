@extends('layout.master')

<style>
    .card {
        margin: 0 auto;
        background-color: #FAFAFA !important;
    }
    label, .btn {
        font-weight: 500 !important;
    }
    .form-control {
        font-weight: 500 !important;
        border: 1px solid #f9f9f9 !important;
        padding: 12px !important;
    }
</style>

@section('content')
<main class="content-fluid py-5">
    <div class="container">
        <div class="card position-relative border-0 rounded-3 shadow-sm pt-5" style="width:36%">
            <a href="{{ route('worklogs.show-employee', auth()->id()) }}" class="plus-times"><i class="fas fa-times"></i></a>
            <div class="card-body mt-5">
                <form action="{{ route('worklogs.update', $worklog->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="user_id" value="{{ $user }}">

                    <div>
                        <label class="mb-2 ms-2 text-secondary">Heure de début</label>
                        <input
                            type="time"
                            name="start_time"
                            class="form-control ps-3 text-secondary border-0 rounded-5"
                        />
                    </div>

                    <div class="mt-5">
                        <label class="mb-2 ms-2 text-secondary">Heure de fin</label>
                        <input
                            type="time"
                            name="end_time"
                            class="form-control ps-3 text-secondary border-0 rounded-5"
                        />
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn text-white py-2 px-4 rounded-5 mt-5" style="background-color: #344264;">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
