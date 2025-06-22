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
        background-color: white !important;
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
        background-color: white !important;
        border: 1px solid #f9f9f9 !important;
        padding: 12px !important;
    }
    .radio-status {
        border: none !important;
        background-color: white !important;
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
    .custom-dropdown-wrapper {
        width: 100%;
    }
    .custom-dropdown-toggle {
        background-color: #FAFAFA;
        color: #344264;
        border: none;
        outline: none;
        padding: 12px;
        cursor: pointer;
        font-weight: 500;
    }
    .custom-dropdown-menu {
        display: none;
        position: absolute;
        z-index: 10;
        width: 100%;
        background-color: #FAFAFA;
        list-style: none;
        padding: 0;
        margin: 0;
        max-height: 220px;
        overflow-y: auto;
    }
    .dropdown-option {
        cursor: pointer;
        background-color: #FAFAFA;
        font-weight: 500;
        padding: 12px;
        transition: all 0.2s ease-in-out;
    }
    .dropdown-option:hover {
        background-color: #FAFAFA;
    }
</style>

@section('content')
<main class="content-fluid pt-4">
    <div class="container py-5">
        <form action="{{ route('deliveries.update', $delivery->id) }}" method="post" class="d-flex gap-2">
            @csrf
            @method('PUT')

            <div class="card left-card position-relative border-0 rounded-3 shadow-sm pt-5 px-2" style="width:34%">
                <div class="card-body">

                    <div class="mt-4 mb-5 position-relative custom-dropdown-wrapper">
                        <label class="mb-2 ms-2 text-secondary">Client</label>
                        <input type="hidden" name="client_id" id="selected-client-id" value="{{ old('client_id', $delivery->client_id) }}">

                        <div class="custom-dropdown-toggle rounded-2 text-start" onclick="toggleDropdown()">
                            <span id="selected-client-label" class="text-secondary">
                                {{ old('client_id')
                                    ? strtolower(optional($clients->firstWhere('id', old('client_id')))->full_name)
                                    : strtolower(optional($delivery->client)->full_name) ?? 'cliquez pour choisir' }}
                            </span>
                            <i class="fas fa-chevron-down float-end mt-1"></i>
                        </div>

                        <ul class="custom-dropdown-menu rounded-1 mt-2" id="dropdown-menu">
                            @foreach ($clients as $client)
                                <li onclick="selectClient({{ $client->id }}, '{{ strtolower($client->full_name) }}')"
                                    class="dropdown-option rounded-0 px-3 py-2 text-secondary">
                                    {{ strtolower($client->full_name) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card right-card position-relative border-0 rounded-3 shadow-sm pt-4 px-2" style="width:36%">
                <a href="{{ route('deliveries.index', ['paid' => request('paid', 'no')]) }}" class="plus-times">
                    <i class="fas fa-times"></i>
                </a>

                <div class="card-body mb-3 mt-5">

                    <div class="position-relative">
                        <label class="mb-2 ms-2 text-secondary">Quantité en kg</label>
                        <input type="number" name="glacons_kg"
                            class="form-control kg-input ps-3 pe-5 text-secondary border-0 rounded-2"
                            value="{{ old('glacons_kg', $delivery->glacons_kg) }}"
                            min="1" max="1000"
                            autocomplete="off" required
                            oninput="limitToFourDigits(this)" />
                    </div>

                    <div class="mt-5">
                        <label class="ms-2 mt-4 text-secondary">Le paiement a-t-il été effectué ?</label>
                        <div class="mt-4 ms-2">
                            <label style="cursor:pointer; color: #344264; font-size: 16px;">
                                <input class="form-check-input radio-status me-3" type="radio" name="is_paid" value="1"
                                    style="border: 1px solid #F5F5F5;"
                                    {{ old('is_paid', $delivery->is_paid) == '1' ? 'checked' : '' }} />
                                <span class="text-secondary fw-500">oui, c'est payé</span>
                            </label>
                            <label class="ms-4" style="cursor:pointer; color: #344264; font-size: 16px;">
                                <input class="form-check-input radio-status me-3" type="radio" name="is_paid" value="0"
                                    style="border: 1px solid #F5F5F5;"
                                    {{ old('is_paid', $delivery->is_paid) == '0' ? 'checked' : '' }} />
                                <span class="text-secondary">pas encore</span>
                            </label>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn text-white py-2 px-4 rounded-5 mt-5" style="background-color: #344264;">Mettre à jour</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection

<script>
    function toggleDropdown() {
        const menu = document.getElementById('dropdown-menu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }

    function selectClient(id, name) {
        document.getElementById('selected-client-id').value = id;
        document.getElementById('selected-client-label').innerText = name;
        document.getElementById('dropdown-menu').style.display = 'none';
    }

    document.addEventListener('click', function (e) {
        const wrapper = document.querySelector('.custom-dropdown-wrapper');
        if (!wrapper.contains(e.target)) {
            document.getElementById('dropdown-menu').style.display = 'none';
        }
    });
</script>

<script>
function limitToFourDigits(input) {
    if (input.value.length > 4) {
        input.value = input.value.slice(0, 4);
    }
    if (parseInt(input.value) > 1000) {
        input.value = 1000;
    }
}
</script>

