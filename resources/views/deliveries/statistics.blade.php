@extends('layout.master')

<style>
    .card{
        background-color: #FAFAFA !important;
    }
    td {
        color: #868e96 !important;
        background-color: #FAFAFA !important;
        font-weight: 500 !important;
        padding: 16px !important;
    }
    .id {
        color: #344264 !important;
        background-color: white !important;
        padding: 10px 12px;
        border-radius: 25px;
        font-weight: 500 !important;
    }
    .table {
        width: 90% !important;
    }
    h4 {
        color: #344264 !important;
        font-weight: 400 !important;
        margin-top: 1.5rem !important;
        margin-left: 2rem !important;
    }
    #clientDeliveryChart {
        width: 220px !important;
        height: 220px !important;
    }
    .chart-container {
        max-width: 100%;
        padding-left: 2rem;
    }
    #chartjs-tooltip {
        z-index: 999;
        font-size: 14px;
        font-weight: 500;
        line-height: 1.8;
    }
</style>

@section('content')
<main class="content pt-4">
    <div class="container-fluid">
        <div class="card position-relative border-0 rounded-0 shadow-sm bg-white" style="width:100%">
            <a href="{{ url()->previous() }}" class="plus-times"><i class="fas fa-times"></i></a>

            @php
                \Carbon\Carbon::setLocale('fr');
                $date = \Carbon\Carbon::now()->isoFormat('MMMM YYYY');
            @endphp
            <span class="plus-times" style="right: 14%; top: 4%; background-color: transparent;">{{ ucfirst($date) }}</span>

            <h4>Feuilles d'achats</h4>

            <div class="my-4" style="display: flex; align-items: flex-start; gap: 2.5rem;">

                <div class="chart-container mt-5">
                    <canvas id="clientDeliveryChart"></canvas>
                </div>

                <div class="top-clients mt-5 pt-5" style="flex: 0 0 650px; padding-left: 1rem;">

                    @if($showClientOfMonth)
                        <div class="mb-3 ms-5 ps-4" style="color: #344264; font-weight: 500;">
                            Client du mois
                        </div>

                        <table class="table table-borderless">
                            <tbody>
                                @php $i = 2; @endphp
                                @foreach ($displayClients as $index => $client)
                                    <tr>
                                        <td class="id">
                                            @if ($index === 0)
                                                <i class="fas fa-trophy text-warning" style="font-size: 20px;"></i>
                                            @else
                                                {{ $i++ }}
                                            @endif
                                        </td>
                                        <td>{{ $client->full_name }}</td>
                                        <td>
                                            Total glacons livrés : &nbsp; <span class="text-warning">{{ round($client->total_kg, 1) }} kg</span>
                                        </td>
                                    </tr>
                                    <tr style="height: 20px !important;"></tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="mb-3 ms-5 ps-4" style="color: #344264; font-weight: 500;">
                            Top 3 clients avec le plus d'achats
                        </div>

                        <table class="table table-borderless">
                            <tbody>
                                @php $i = 2; @endphp
                                @foreach ($displayClients as $index => $client)
                                    <tr>
                                        <td class="id">
                                            <i class="fas fa-star text-warning" style="font-size: 20px;"></i>
                                        </td>
                                        <td>{{ $client->full_name }}</td>
                                        <td>
                                            Total glacons livrés : &nbsp; <span class="text-warning">{{ round($client->total_kg, 1) }} kg</span>
                                        </td>
                                    </tr>
                                    <tr style="height: 20px !important;"></tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            @if ($chartData->count())
                <script src="{{ asset('assets/js/chart.umd.min.js') }}"></script>
                <script>
                    const ctx = document.getElementById('clientDeliveryChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: {!! json_encode($chartData->pluck('name')) !!},
                            datasets: [{
                                data: {!! json_encode($chartData->pluck('kg')) !!},
                                backgroundColor: [
                                    '#FF8C00',
                                    '#FFB347',
                                    '#FFD580',
                                    '#FFE4B5',
                                    '#F4A460',
                                    '#DEB887',
                                    '#D2691E'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                tooltip: {
                                    enabled: false,
                                    external: function(context) {
                                        let tooltipEl = document.getElementById('chartjs-tooltip');

                                        if (!tooltipEl) {
                                            tooltipEl = document.createElement('div');
                                            tooltipEl.id = 'chartjs-tooltip';
                                            tooltipEl.style.background = '#FAFAFA';
                                            tooltipEl.style.color = '#868e96';
                                            tooltipEl.style.borderRadius = '8px';
                                            tooltipEl.style.padding = '4px 12px';
                                            tooltipEl.style.position = 'absolute';
                                            tooltipEl.style.transform = 'translate(-50%, 0)';
                                            tooltipEl.style.transition = 'all 1s ease';
                                            tooltipEl.style.pointerEvents = 'none';
                                            tooltipEl.style.width = '200px';
                                            document.body.appendChild(tooltipEl);
                                        }

                                        const tooltipModel = context.tooltip;

                                        if (tooltipModel.opacity === 0) {
                                            tooltipEl.style.opacity = 0;
                                            return;
                                        }

                                        const label = tooltipModel.dataPoints[0].label;
                                        const value = tooltipModel.dataPoints[0].formattedValue;

                                        tooltipEl.innerHTML = `
                                            <strong>${label}</strong><br>
                                            Total : ${value} kg
                                        `;

                                        const position = context.chart.canvas.getBoundingClientRect();
                                        tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX + 'px';
                                        tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                                        tooltipEl.style.opacity = 1;
                                    }
                                }
                            }
                        }
                    });
                </script>
            @endif
        </div>
    </div>
</main>

@endsection
