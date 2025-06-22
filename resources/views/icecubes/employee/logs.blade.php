@extends('layout.master')

<style>
    .card {
        margin: 0 auto;
        background-color: #FAFAFA !important;
    }
    label, .btn {
        font-weight: 500 !important;
    }
    .add {
        padding: 13px 18px !important;
        font-size: 14px !important;
        background-color: #344264 !important;
        border-radius: 0 8px 8px 0 !important;
    }
    .delete {
        color: #344264 !important;
        transition: all .3s ease-in !important;
    }
    .delete:hover {
        background-color: lightgray !important;
        color: white !important;
    }
    .form-control {
        background-color: #F8F8F8 !important;
        font-weight: 500 !important;
        border: 1px solid #f9f9f9 !important;
        border-radius: 8px 0 0 8px !important;
        padding: 10px !important;
    }
    h5 {
        font-size: 17px !important;
    }
</style>

@section('content')
    <main class="content py-5">
        <div class="container-fluid">
            <div class="card position-relative border-0 rounded-2 pt-5 pb-3 shadow-sm" style="width:90%">
                <a href="#" class="plus-times" style="right: 2%; top: 10%;" data-bs-toggle="modal" data-bs-target="#addIceModal">
                    <i class="fas fa-plus"></i>
                </a>

                <div class="card-body d-flex flex-wrap my-5">
                    @foreach ($iceCubes as $drop)
                        <div class="position-relative bg-white shadow-sm me-3 mb-3 px-3 py-2 rounded-2" style="min-width: 160px;">
                            <div style="font-weight: 500; font-size: 16px;" class="text-end mb-3">{{ $drop->created_at->format('H:i') }}</div>
                            <div style="font-weight: 500; font-size: 18px;">
                                {{ $drop->kg }} kg
                                <form action="{{ route('icecubes.destroy', $drop->id) }}" method="POST" style="display:inline; position:absolute; bottom: -16%; right: 2%;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm py-2 px-3 delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                    @if (count($iceCubes) > 0)
                        <form method="POST" action="{{ route('icecubes.consolidate') }}" style="position:absolute; bottom: -4%; right: .5%;">
                            @csrf
                            <button type="submit" class="btn text-white" style="background-color: #344264;">Fusionner</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection

<div class="modal fade" id="addIceModal" tabindex="-1" aria-labelledby="addIceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin-left: 40%; margin-top: -5%;">
        <div class="modal-content border-0 rounded-2 shadow" style="width: 80%;">
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-secondary mb-0">Saisie de quantité</h5>
                    <button type="button" class="btn-close" style="box-shadow: none; border: none; outline: none; font-size: 12px; font-weight: 600;" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <form action="{{ route('icecubes.store') }}" method="POST" class="pb-4">
                    @csrf
                    <label class="mb-2 mt-4 ms-1 text-secondary">kgs</label>
                    <div class="d-flex">
                        <input type="number" name="kg" class="form-control ps-3 text-secondary" step="1" min="0" autocomplete="off" />
                        <button type="submit" class="btn text-white add" style="background-color: #344264;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
