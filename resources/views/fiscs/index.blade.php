@extends('layout.master')

<style>
    .card {
        margin: 0 auto;
        background-color: #FAFAFA !important;
        color: #6B7280 !important;
    }
    label, .btn {
        font-weight: 500 !important;
        font-size: 15px !important;
    }
    .store {
        padding: 13px 18px !important;
        font-size: 14px !important;
        border: none !important;
        outline: none !important;
        background-color: #344264 !important;
    }
    .edit {
        color: #344264 !important;
        font-size: 16px !important;
        padding: 10px 16px !important;
        border: none !important;
        outline: none !important;
        transition: all .3s ease-in !important;
    }
    .edit:focus, .store:focus {
        border: none !important;
        outline: none !important;
    }
    .edit:hover {
        background-color: #F3F4F6 !important;
    }
    .form-control {
        background-color: #FAFAFA !important;
        font-weight: 500 !important;
        font-size: 15px !important;
        border: none !important;
        padding: 12px !important;
    }
    h5 {
        font-size: 16px !important;
    }
    td {
        color: #6B7280;
        font-weight: 500;
    }
    .value {
        padding-left: 32px;
    }
</style>

@php
    function cleanMoney($value) {
        $float = (float) $value;
        return rtrim(rtrim(number_format($float, 2, '.', ''), '0'), '.');
    }
@endphp

@section('content')
<main class="content py-4">
    <div class="container-fluid">
        <div class="card position-relative border-0 rounded-0 rounded-top-4 px-5 pt-4 pb-0">
            <form method="GET" action="{{ route('fiscs.index') }}" class="d-flex align-items-center gap-2 mb-4">
                @php
                    $mois = [
                        1 => 'Janvier', 2 => 'Février', 3 => 'Mars',
                        4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
                        7 => 'Juillet', 8 => 'Août', 9 => 'Septembre',
                        10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                    ];
                @endphp

                <select name="month" class="form-select rounded-3" style="width: 160px; padding: 9px 24px; border: 1px solid lightgray;">
                    @foreach($mois as $num => $nom)
                        <option value="{{ $num }}" {{ $num == $month ? 'selected' : '' }}>
                            {{ $nom }}
                        </option>
                    @endforeach
                </select>

                <select name="year" class="form-select mx-3 rounded-3" style="width: 120px; padding: 9px 44px 9px 22px; border:  1px solid lightgray;">
                    @foreach(range(now()->year - 1, now()->year + 1) as $y)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-secondary" style="padding: 9px 22px;">Filtrer</button>
            </form>

            <a href="#" data-bs-toggle="modal" data-bs-target="#addFisc" class="plus-times">
                <i class="fas fa-plus"></i>
            </a>
            <div class="card-body">
                <div class="row my-4">
                    <div class="col-md-3 mx-5 bg-white px-3 py-2 rounded-3">
                        <div class="mb-4 fw-semibold fs-6">Loyer</div>
                        <div class="fw-semibold fs-6">{{ cleanMoney($rentExpense) }} dh</div>
                    </div>

                    <div class="col-md-3 bg-white px-3 py-2 rounded-3">
                        <div class="mb-4 fw-semibold fs-6">Électricité</div>
                        <div class="position-relative" style="font-weight: 500; font-size: 16px;">
                            {{ cleanMoney($electricityExpense) }} dh
                            @php
                                $electricityFisc = $fiscs->firstWhere('type', 'electricity');
                            @endphp
                            @if ($electricityFisc)
                            <a href="{{ route('fiscs.edit', $electricityFisc->id) }}" class="btn btn-sm edit" style="position:absolute; bottom: -20%; right: 2%;">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-3 mx-5 bg-white px-3 py-2 rounded-3">
                        <div class="mb-4 fw-semibold fs-6">Eau</div>
                        <div class="position-relative" style="font-weight: 500; font-size: 16px;">
                            {{ cleanMoney($waterExpense) }} dh
                            @php
                                $waterFisc = $fiscs->firstWhere('type', 'water');
                            @endphp
                            @if ($waterFisc)
                            <a href="{{ route('fiscs.edit', $waterFisc->id) }}" class="btn btn-sm edit" style="position:absolute; bottom: -20%; right: 2%;">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row my-5 pt-4">
                    @if (count($worklogsByUser) > 0)
                        <div class="col-md-4 bg-white mx-5 px-3 py-2 rounded-3">
                            <div class="mb-4 fw-semibold fs-6">Frais salariés</div>
                            @foreach ($worklogsByUser as $log)
                                <div class="position-relative mb-4" style="font-weight: 500; font-size: 16px;">
                                    {{ $log->user->name }}
                                    <span style="position:absolute; right: 10%;">{{ cleanMoney($log->total) }} dh</span>
                                </div>


                            @endforeach
                        </div>
                    @endif

                    @if (count($equipments) > 0)
                        <div class="col-md-5 bg-white mx-5 px-3 py-2 rounded-3">
                            <div class="mb-4 fw-semibold fs-6">Équipements</div>
                            @foreach ($equipments as $equip)
                                <div class="position-relative mb-4" style="font-weight: 500; font-size: 16px;">
                                    {{ $equip->equipment_name ?? 'Équipement' }}
                                    <span class="ms-5" style="position:absolute; bottom: 2%; right: 32%;">{{ cleanMoney($equip->amount) }} dh</span>
                                    <a href="{{ route('fiscs.edit', $equip->id) }}" class="btn btn-sm edit" style="position:absolute; bottom: -20%; right: 2%;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card bg-white border-0 rounded-0 rounded-bottom-4 px-4 py-4 mt-2 shadow-sm">

            <div class="card-body">
                <table>
                    <tr>
                        <td>Revenu</td>
                        <td class="value">:</td>
                        <td class="value">{{ cleanMoney($deliveryIncome) }} dh</td>
                    </tr>
                    <tr style="height: 16px;"></tr>
                    <tr>
                        <td>Dépenses totales</td>
                        <td class="value">:</td>
                        <td class="value">{{ cleanMoney($totalExpense) }} dh</td>
                    </tr>
                    <tr style="height: 16px;"></tr>
                    <tr>
                        <td>Bénéfice net</td>
                        <td class="value">:</td>
                        <td class="value">{{ cleanMoney($profit) }} dh</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

<div class="modal fade" id="addFisc" tabindex="-1" aria-labelledby="addFiscLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin-left: 42%; margin-top: 0%;">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-body position-relative pt-3 pb-5">
                <div class="d-flex justify-content-between align-items-center mb-4 px-4">
                    <h5 class="text-secondary my-3" id="addFiscLabel">Ajouter une dépense</h5>
                    <button type="button" class="btn-close" style="box-shadow: none; border: none; outline: none; font-size: 12px; font-weight: 600;" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <form action="{{ route('fiscs.store') }}" method="POST" class="ps-4 pb-5">
                    @csrf

                    <div class="row my-4">
                        <div class="col-md-6 me-3 position-relative custom-dropdown-wrapper">
                            <label for="fisc-type" class="mb-2 ms-1 text-secondary">Type de dépense</label>

                            <input type="hidden" name="type" id="selected-fisc-type" value="{{ old('type') }}">

                            @php
                                $expenseTypes = ['water' => 'Eau', 'electricity' => 'Électricité', 'equipment' => 'Équipement'];
                                $currentMonth = now()->month;
                                $currentYear = now()->year;
                                $paidTypes = $fiscs->where('month', $currentMonth)
                                                ->where('year', $currentYear)
                                                ->pluck('type')
                                                ->toArray();

                                $unpaidTypes = array_diff_key($expenseTypes, array_flip($paidTypes));

                                $selectedTypeLabel = 'Cliquez pour choisir';
                                if (old('type') && isset($expenseTypes[old('type')])) {
                                    $selectedTypeLabel = $expenseTypes[old('type')];
                                } elseif (!empty($unpaidTypes)) {
                                    $selectedTypeLabel = reset($unpaidTypes);
                                }
                            @endphp

                            <div class="custom-dropdown-toggle text-start border py-2 px-3 bg-white" style="font-size: 15px !important; background-color: #FAFAFA !important; color: #6B7280 !important; border: none !important; outline: none !important; padding: 12px !important; cursor: pointer !important; font-weight: 500 !important;" onclick="toggleDropdown()">
                                <span id="selected-type-label" class="text-secondary">
                                    {{ $selectedTypeLabel }}
                                </span>
                                <i class="fas fa-chevron-down float-end mt-2" style="font-size: 13px;"></i>
                            </div>

                            <ul class="custom-dropdown-menu rounded-2 mt-2 border bg-white" id="dropdown-menu" style="display: none; position: absolute; width: 90%; z-index: 10; background-color: #FAFAFA; list-style: none; padding: 0; margin: 0; overflow-y: auto; font-weight: 500; border: none !important;">
                                @foreach ($expenseTypes as $value => $label)
                                    @if ($value === 'equipment' || !in_array($value, $paidTypes))
                                        <li onclick="selectType('{{ $value }}', '{{ $label }}')"
                                            class="dropdown-option rounded-0 px-3 py-2 text-secondary"
                                            style="cursor: pointer; font-size: 15px !important; background-color: #FAFAFA !important; padding: 12px !important; transition: all 0.2s ease-in-out;">
                                            {{ $label }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-md-5">
                            <label for="amount" class="mb-2 ms-1 text-secondary">Coût</label>
                            <input type="number" name="amount" id="amount" class="form-control rounded-0 ps-3 text-secondary" step="0.5" min="0" autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 me-3">

                        </div>

                        <div class="col-md-5 pt-2" id="equipment-name-group" style="display: none;">
                            <label for="equipment_name" class="mb-2 ms-1 text-secondary">Nom de l'équipement</label>
                            <input type="text" name="equipment_name" id="equipment_name" class="form-control text-secondary rounded-0">
                        </div>
                    </div>

                    <input type="hidden" name="month" value="{{ now()->month }}">
                    <input type="hidden" name="year" value="{{ now()->year }}">

                    <div style="position: absolute; bottom: 3%; right: 8%;">
                        <button type="submit" class="btn text-white rounded-3 store" style="background-color: #344264;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('fisc-type');
        const equipmentField = document.getElementById('equipment-name-group');

        function toggleEquipmentField() {
            equipmentField.style.display = (typeSelect.value === 'equipment') ? 'block' : 'none';
        }

        typeSelect.addEventListener('change', toggleEquipmentField);
        toggleEquipmentField();
    });
</script>

<script>
    function toggleDropdown() {
        const menu = document.getElementById('dropdown-menu');
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }

    function selectType(value, label) {
        document.getElementById('selected-fisc-type').value = value;
        document.getElementById('selected-type-label').innerText = label;
        document.getElementById('dropdown-menu').style.display = 'none';

        const equipGroup = document.getElementById('equipment-name-group');
        if (equipGroup) {
            equipGroup.style.display = (value === 'equipment') ? 'block' : 'none';
        }
    }

    document.addEventListener('click', function (e) {
        const wrapper = document.querySelector('.custom-dropdown-wrapper');
        if (!wrapper.contains(e.target)) {
            document.getElementById('dropdown-menu').style.display = 'none';
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const selectedType = document.getElementById('selected-fisc-type').value;
        if (selectedType === 'equipment') {
            const equipGroup = document.getElementById('equipment-name-group');
            if (equipGroup) {
                equipGroup.style.display = 'block';
            }
        }
    });
</script>

