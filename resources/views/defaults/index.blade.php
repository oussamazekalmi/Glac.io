@extends('layout.master')

<style>
    .card {
        margin: 0 auto;
        background-color: #FAFAFA !important;
        color: #6B7280 !important;
    }
    label, .btn {
        font-weight: 500 !important;
    }
    .update {
        padding: 13px 18px !important;
        font-size: 14px !important;
        border: none !important;
        outline: none !important;
        background-color: #344264 !important;
    }
    .edit {
        color: #344264 !important;
        font-size: 16px !important;
        border: none !important;
        outline: none !important;
        transition: all .3s ease-in !important;
    }
    .edit:focus, .update:focus {
        border: none !important;
        outline: none !important;
    }
    .edit:hover {
        background-color: #F3F4F6 !important;
    }
    .form-control {
        background-color: #FAFAFA !important;
        font-weight: 500 !important;
        border: none !important;
        padding: 12px !important;
    }
    h5 {
        font-size: 16px !important;
    }
</style>

@section('content')
    <main class="content py-5 position-relative">
        <div class="container-fluid">
            <div class="card position-relative border-0 rounded-2 mt-2 pt-5 pb-3 shadow-sm" style="width:75%">
                <div class="card-body d-flex flex-wrap my-5" style="margin: 0 auto;">

                    <div class="position-relative bg-white shadow-sm me-5 mb-3 px-3 py-2 rounded-2" style="min-width: 200px;">
                        <div style="font-weight: 500; font-size: 16px;" class="mb-3">Prix par kg de glaçons</div>
                        <div style="font-weight: 500; font-size: 16px;">
                            {{ $default->kg_price }} DH
                            <a href="#" data-bs-toggle="modal" data-bs-target="#defaultValues" class="btn btn-sm py-2 px-3 edit" style="position:absolute; bottom: 5%; right: 2%;">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>

                    <div class="position-relative bg-white shadow-sm me-5 mb-3 px-3 py-2 rounded-2" style="min-width: 200px;">
                        <div style="font-weight: 500; font-size: 16px;" class="mb-3">Tarif horaire</div>
                        <div style="font-weight: 500; font-size: 16px;">
                            {{ $default->hourly_rate }} DH
                            <a href="#" data-bs-toggle="modal" data-bs-target="#defaultValues" class="btn btn-sm py-2 px-3 edit" style="position:absolute; bottom: 5%; right: 2%;">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>

                    <div class="position-relative bg-white shadow-sm mb-3 px-3 py-2 rounded-2" style="min-width: 200px;">
                        <div style="font-weight: 500; font-size: 16px;" class="mb-3">Loyer</div>
                        <div style="font-weight: 500; font-size: 16px;">
                            {{ $default->rent }} DH
                            <a href="#" data-bs-toggle="modal" data-bs-target="#defaultValues" class="btn btn-sm py-2 px-3 edit" style="position:absolute; bottom: 5%; right: 2%;">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('old-data.destroy') }}" method="POST" style="position: fixed; top: 3.5%; left: 22%;">
            @csrf
            @method('DELETE')
            <button type="submit" style="background-color: transparent !important;" class="delete-old-data">
                <i class="fas fa-trash me-2" style="font-size: 1.3em;"></i> <span>Nettoyage de l'historique</span>
            </button>
        </form>
    </main>
@endsection

<div class="modal fade" id="defaultValues" tabindex="-1" aria-labelledby="defaultValuesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin-left: 45.4%; margin-top: 0%;">
        <div class="modal-content border-0 rounded-2 shadow" style="width: 75%;">
            <div class="modal-body pt-4 pb-2">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-secondary my-3" >réglages des coûts</h5>
                    <button type="button" class="btn-close" style="box-shadow: none; border: none; outline: none; font-size: 12px; font-weight: 600;" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <form action="{{ route('defaults.update') }}" method="POST" class="ps-3 pe-4">
                    @csrf
                    @method('PUT')

                   <div class="my-3">
                        <label class="mb-2 ms-1 text-secondary">prix par kg de glaçons</label>
                        <input type="number" name="kg_price" class="form-control rounded-3 ps-3 text-secondary" value="{{ old('kg_price', $default->kg_price) }}" step="0.5" min="0" required autocomplete="off" />
                   </div>

                    <div class="my-3">
                        <label class="mb-2 ms-1 text-secondary">tarif horaire</label>
                        <input type="number" name="hourly_rate" class="form-control ps-3 text-secondary" value="{{ old('hourly_rate', $default->hourly_rate) }}" step="0.5" min="0" required autocomplete="off" />
                   </div>

                   <div class="my-3">
                        <label class="mb-2 ms-1 text-secondary">loyer</label>
                        <input type="number" name="rent" class="form-control ps-3 text-secondary" value="{{ old('rent', $default->rent) }}" step="0.5" min="0" required autocomplete="off" />
                   </div>

                    <div class="text-end">
                        <button type="submit" class="btn text-white rounded-3 update" style="background-color: #344264;">
                        <i class="fas fa-edit"></i>
                    </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

