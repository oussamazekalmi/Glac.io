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
    <main class="content-fluid pt-4">
        <div class="container">
            <div class="card position-relative border-0 rounded-3 shadow-sm pt-4 px-2" style="width:36%">
                <a href="{{ route('clients.index') }}" class="plus-times"><i class="fas fa-times"></i></a>
                <div class="card-body mt-5">
                    <form action="{{ route('clients.store') }}" method="post">
                        @csrf

                        <div>
                            <label class="mb-3 ms-2 text-secondary">nom du client</label>
                            <input type="text" name="full_name" class="form-control ps-3 text-secondary border-0 rounded-5" value="{{ old('full_name') }}" autocomplete="off" />
                        </div>
                        <div style="margin: 20px 0">
                            <label class="mb-3 ms-2 text-secondary">adresse du client</label>
                            <input type="text" name="address" class="form-control ps-3 text-secondary border-0 rounded-5" value="{{ old('address') }}" autocomplete="off" />
                        </div>
                        <div>
                            <label class="mb-3 ms-2 text-secondary">numéro de téléphone</label>
                            <input type="text" name="phone"
                                class="form-control ps-3 text-secondary border-0 rounded-5"
                                value="{{ old('phone') }}"
                                maxlength="10"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                autocomplete="off"
                            />
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn text-white py-2 px-4 rounded-5 mt-5" style="background-color: #344264;">Confirmer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
