@extends('layout.master')

<style>
    .card {
        margin: 0 auto;
        background-color: #FAFAFA !important;
    }
    .card.left-card {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        margin-right: 0 !important;
    }
    .card.right-card {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        margin-left: 0 !important;
    }
    label, .btn {
        font-weight: 500 !important;
    }
    .form-control {
        font-weight: 500 !important;
        border: 1px solid #f9f9f9 !important;
        padding: 12px !important;
    }
    .text-message {
        color: #344264;
        font-size: 12px;
    }
    .radio-status {
        border: none !important;
    }
    .radio-status:checked {
        background-color: #344264 !important;
        box-shadow: 0 0 0 1px #344264 !important;
        cursor: pointer !important;
    }
    .radio-status:hover {
        cursor: pointer;
    }
    .radio-status:focus {
        outline: none !important;
        box-shadow: none !important;
        border: none !important;
    }
</style>

@section('content')
    <main class="content-fluid pt-4">
        <div class="container py-5">
            <form action="{{ route('clients.update', $client->id) }}" method="post" class="d-flex gap-2">
                @csrf
                @method('PUT')
                <div class="card left-card position-relative border-0 rounded-3 shadow-sm pt-4 px-2" style="width:34%">
                    <div class="card-body mt-5">
                        <div>
                            <label class="mb-3 ms-2 text-secondary">nom du client</label>
                            <input type="text" name="full_name" class="form-control ps-3 text-secondary border-0 rounded-5" value="{{ old('full_name', $client->full_name) }}" autocomplete="off" />
                        </div>

                        <div class="my-5">
                            <label class="mb-3 ms-2 text-secondary">numéro de téléphone</label>
                            <input type="text" name="phone"
                                class="form-control ps-3 text-secondary border-0 rounded-5"
                                value="{{ old('phone', $client->phone) }}"
                                maxlength="10"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                autocomplete="off"
                            />
                        </div>
                    </div>
                </div>
                <div class="card right-card position-relative border-0 rounded-3 shadow-sm pt-2 px-2" style="width:34%">
                    <a href="{{ url()->previous() }}" class="plus-times"><i class="fas fa-times"></i></a>
                    <div class="card-body mt-5">
                        <div class="my-3">
                            <label class="mb-3 ms-2 text-secondary">adresse du client</label>
                            <input type="text" name="address" class="form-control ps-3 text-secondary border-0 rounded-5" value="{{ old('address', $client->address) }}" autocomplete="off" />
                        </div>
                        <div class="mt-5 mb-4">
                            <label class="mb-1 ms-2 text-secondary">Collaboration</label>
                            <div class="mt-4 ms-2">
                                <label style="cursor:pointer; color: #344264; font-size: 16px;">
                                    <input class="form-check-input radio-status me-3" type="radio" name="status" value="active"
                                        style="border: 1px solid #F5F5F5;"
                                        {{ old('status', $client->status) === 'active' ? 'checked' : '' }}
                                    />
                                    <span class="text-secondary fw-500">En cours</span>
                                </label>
                                <label class="ms-5" style="cursor:pointer; color: #344264; font-size: 16px;">
                                    <input class="form-check-input radio-status me-3" type="radio" name="status" value="inactive"
                                        style="border: 1px solid #F5F5F5;"
                                        {{ old('status', $client->status) === 'inactive' ? 'checked' : '' }}
                                    />
                                    <span class="text-secondary">Terminée</span>
                                </label>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn text-white py-2 px-4 rounded-5 mt-5" style="background-color: #344264;">Mettre à jour</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
