@extends('layout.master')

<style>
    .card {
        margin: 0 auto;
        background-color: white !important;
    }
    label, .btn {
        font-weight: 500 !important;
    }
    .form-control {
        font-weight: 500 !important;
        background-color: #FAFAFA !important;
        border: none !important;
        padding: 12px !important;
    }
</style>

@php
    function cleanMoney($value) {
        $float = (float) $value;
        return rtrim(rtrim(number_format($float, 2, '.', ''), '0'), '.');
    }
@endphp

@section('content')
    <main class="content-fluid pt-4">
        <div class="container">
            <div class="card position-relative border-0 rounded-3 shadow-sm pt-4 px-2" style="width:36%">
                <a href="{{ url()->previous() }}" class="plus-times"><i class="fas fa-times"></i></a>
                <div class="card-body mt-5">
                    <form method="POST" action="{{ route('fiscs.update', $fisc->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="type" class="mb-2 ms-1 text-secondary">Type de dépense</label>
                            <input  type="text" name="type" id="edit-fisc-type" class="form-control text-secondary rounded-0" readonly
                                    value="{{ $fisc->type === 'water' ? 'Eau' : ($fisc->type === 'electricity' ? 'Électricité' : 'Équipement') }}">
                        </div>

                        <div class="mb-4" id="edit-equipment-name-group" style="display: none;">
                            <label for="equipment_name" class="mb-2 ms-1 text-secondary">Nom de l'équipement</label>
                            <input type="text" name="equipment_name" id="equipment_name" class="form-control text-secondary rounded-0" value="{{ old('equipment_name', $fisc->equipment_name) }}">
                        </div>

                        <div>
                            <label for="amount" class="mb-2 ms-1 text-secondary">Coût</label>
                            <input type="number" name="amount" id="amount" class="form-control rounded-0 ps-3 text-secondary" value="{{ old('amount', cleanMoney($fisc->amount)) }}" step="0.5" min="0" autocomplete="off">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn text-white py-2 px-4 rounded-4 mt-5" style="background-color: #344264;">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('edit-fisc-type');
        const equipmentField = document.getElementById('edit-equipment-name-group');

        function toggleEditEquipmentField() {
            equipmentField.style.display = ( {{ $fisc->type === 'equipment' }} ) ? 'block' : 'none';
        }

        typeSelect.addEventListener('change', toggleEditEquipmentField);
        toggleEditEquipmentField();
    });
</script>
