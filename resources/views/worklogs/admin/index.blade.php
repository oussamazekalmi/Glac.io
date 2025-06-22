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
    .user-links {
        display: flex;
        justify-content: end;
        flex-wrap: wrap;
        gap: 2rem;
        margin-right: 1rem;
    }
    .user-links a {
        padding: 0 26px 0 0;
        background-color: white !important;
        color: #344264;
        font-weight: 500;
        border-radius: 5px;
        text-decoration: none;
    }
    .action-link {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 500;
        color: #6c757d;
        border-radius: 25px 25px 25px 25px !important;
        text-decoration: none;
        transition: all 0.6s ease;
    }
    .action-link i {
        font-size: 14px;
        background-color: #FCFCFC;
        padding: 12px 16px;
        color: #FCFCFC;
        border-radius: 5px 25px 25px 5px;
        transition: all 0.6s ease;
    }
    .action-link:hover{
        background-color: white;
    }
    .action-link:hover i {
        background-color: #344264;
        margin-right: 10px;
    }
    #workHoursChart {
        max-width: 250px;
        max-height: 400px;
    }
    .chart-container {
        max-width: 100%;
        overflow-x: auto;
        padding-left: 2rem;
    }
</style>

@section('content')
    @php
        function formatHours($decimalHours) {
            $hours = floor($decimalHours);
            $minutes = round(($decimalHours - $hours) * 60);
            if ($minutes === 0) {
                return $hours . 'h';
            }
            return $hours . 'h ' . $minutes . 'min';
        }
    @endphp

    <main class="content pt-2">
        <div class="container-fluid">
            <div class="card mb-3 position-relative border-0 rounded-0" style="width: 100%">
                <div class="card-body my-0">
                    <div class="user-links">
                        @foreach ($users as $user)
                            <a href="{{ route('worklogs.show-admin', $user->id) }}" class="action-link">
                                <i class="fas fa-file-alt" me-2></i> {{ $user->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card position-relative border-0 rounded-0 shadow-sm bg-white" style="width:100%">

                <a href="{{ route('users.index') }}" class="plus-times"><i class="fas fa-times"></i></a>

                @php
                    \Carbon\Carbon::setLocale('fr');
                    $date = \Carbon\Carbon::now()->isoFormat('MMMM YYYY');
                @endphp
                <span class="plus-times" style="right: 10%; top: 4%; background-color: transparent;">{{ ucfirst($date) }}</span>

                <div class="my-4" style="display: flex; align-items: flex-start; gap: 2.5rem;">

                    <div class="chart-container" style="flex: 1; max-width: 500px;">
                        <canvas id="workHoursChart"></canvas>
                    </div>

                    <div class="top-employees mt-5 pt-5" style="flex: 0 0 650px; padding-left: 1rem;">

                        @if($showEmployeeOfMonth)
                            <table class="table table-borderless">
                                <tbody>
                                    @php $i = 2; @endphp

                                    <div class="mb-3 ms-5 ps-4" style="color: #344264; font-weight: 500;">Employé du mois</div>

                                    @foreach ($displayEmployees as $index => $employee)
                                        <tr>
                                            <td class="id">
                                                @if ($index === 0)
                                                    <i class="fas fa-trophy text-warning" style="font-size: 20px;"></i>
                                                @else
                                                    {{ $i++ }}
                                                @endif
                                            </td>
                                            <td>{{ $employee['user']->name }}</td>
                                            <td>
                                                @php
                                                    $hours = floor($employee['total_hours']);
                                                    $minutes = ($employee['total_hours'] - $hours) * 60;
                                                @endphp
                                                Heures totales : {{ $hours }}h
                                                @if (round($minutes) > 0)
                                                    {{ ' ' . round($minutes) }}min
                                                @endif
                                            </td>
                                        </tr>

                                        <tr style="height: 20px !important;"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <table class="table table-borderless">
                                <tbody>
                                    @php $i = 2; @endphp

                                    <div class="mb-3 ms-5 ps-4" style="color: #344264; font-weight: 500;">Top 3 travailleurs les plus assidus</div>

                                    @foreach ($displayEmployees as $index => $employee)
                                        <tr>
                                            <td class="id">
                                                <i class="fas fa-star text-warning" style="font-size: 20px;"></i>
                                            </td>
                                            <td>{{ $employee['user']->name }}</td>
                                            <td>
                                                @php
                                                    $hours = floor($employee['total_hours']);
                                                    $minutes = ($employee['total_hours'] - $hours) * 60;
                                                @endphp
                                                Heures totales : {{ $hours }}h
                                                @if (round($minutes) > 0)
                                                    {{ ' ' . round($minutes) }}min
                                                @endif
                                            </td>
                                        </tr>

                                        <tr style="height: 20px !important;"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                </div>

                @if ($chartData)
                    <script src="{{ asset('assets/js/chart.umd.min.js') }}"></script>
                    <script>
                        const ctx = document.getElementById('workHoursChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: {!! json_encode($chartData->pluck('name')) !!},
                                datasets: [{
                                    data: {!! json_encode($chartData->pluck('hours')) !!},
                                    backgroundColor: [
                                        '#344264', '#567a9e',
                                        '#6296b3', '#6eb3c8', '#7acfe0', '#86ebf5',
                                        '#a2f4fb', '#c3f9fe'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        align: 'start',
                                        labels: {
                                            boxWidth: 20,
                                            boxHeight: 20,
                                            padding: 20,
                                            font: {
                                                size: 14,
                                                weight: 'bold'
                                            },
                                            color: '#6c757d'
                                        }
                                    },
                                    tooltip: {
                                        enabled: false,
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
