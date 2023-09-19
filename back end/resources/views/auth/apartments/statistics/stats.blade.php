@extends('layouts.app')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <section>

        @if ($views->isEmpty() && $messages->isEmpty())
            <div class="col-12 text-center">
                <h3 class="text-white">Non hai nessuna statistica da visualizzare</h3>
                <div class="d-flex justify-content-center align-items-center gap-3 flex-column flex-md-row mt-2">
                    <button class="btn my_btn"><a class="text-decoration-none my_link"
                            href="{{ route('admin.apartments.create') }}">Aggiungi un appartamento</a></button>
                    <button class="btn my_btn"><a class="text-decoration-none my_link"
                            href="{{ route('admin.sponsorships.index') }}">Sponsorizza i tuoi appartamenti</a></button>
                </div>
                <div class="col-12 mx-auto">
                    <div class="d-flex justify-center">
                        <img src="http://localhost:8000/images/logo/Bool_Bnb_Black.png" alt="logo"
                            class="img-fluid mx-auto">
                    </div>
                </div>
            </div>
        @else
            <div class="col-12">
                <input type="hidden" id="userApartment" value="{{ $userApartment->id }}">
                <div class="col-12 col-lg-8 col-xxl-5 mx-auto text-center my-5">
                    <div class="card p-2 my-3 shadow my_bg_chart">
                        <div class="d-flex justify-content-center pb-2">
                            <h2 class="text-gradient">Visualizzazioni per: {{ $userApartment->title }}</h2>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center gap-3">
                            <select id="yearViewsFilter" class="my_select">
                                <option value="all">Tutti gli anni</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- stats singolo appartamento e tutti gli anni dello user --}}
                        <canvas id="myYearlyApartmentViewsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12">

                <div class="col-12 col-lg-8 col-xxl-5 mx-auto text-center my-5">
                    <div class="card p-2 my-3 shadow my_bg_chart">
                        <div class="d-flex justify-content-center pb-2">
                            <h2 class="text-gradient">Messaggi per: {{ $userApartment->title }}</h2>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center gap-3">

                            <select id="yearMessageFilter" class="my_select">
                                <option value="all">Tutti gli anni</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- stats singolo appartamento e tutti gli anni dello user --}}
                        <canvas id="myYearlyApartmentMessageChart"></canvas>
                    </div>
                </div>
            </div>
        @endif

    </section>

    <script>
        // Chart per tutti gli appartamenti e tutti gli anni dello user
        var dataYearly = @json($yearlyViews);
        var apartmentViews = @json($apartmentViews);
        var apartmentMessages = @json($apartmentMessages)

        // Chart per le visualizzazioni dell'appartamento
        var ctxYearlyApartment = document.getElementById('myYearlyApartmentViewsChart').getContext('2d');

        var myYearlyApartmentViewsChart = new Chart(ctxYearlyApartment, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Visualizzazioni',
                    data: [],
                    backgroundColor: '#ff7210',
                    borderColor: '#424172',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // forces step size to be 50 units
                            stepSize: 1
                        }
                    }
                },
            }
        });

        // Chart per i messaggi dell'appartamento
        var MessageYearlyApartment = document.getElementById('myYearlyApartmentMessageChart').getContext('2d');

        var myYearlyApartmentMessageChart = new Chart(MessageYearlyApartment, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Visualizzazioni',
                    data: [],
                    backgroundColor: '#ff7210',
                    borderColor: '#424172',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // forces step size to be 50 units
                            stepSize: 1
                        }
                    }
                },
            }
        });



        // Event listeners per cambiare anno alle visualizzazioni
        document.getElementById('yearViewsFilter').addEventListener('change', function() {
            updateYearlyApartmentViewsChart();

        });


        // Event listeners per cambiare anno ai messaggi
        document.getElementById('yearMessageFilter').addEventListener('change', function() {
            updateYearlyApartmentMessagesChart();

        });

        // Funzione per aggiornare il grafico delle visualizzazioni
        function updateYearlyApartmentViewsChart() {
            var selectedApartmentId = document.getElementById('userApartment').value;
            var selectedYear = document.getElementById('yearViewsFilter').value;
            var yearlyMonthlyViews = @json($viewsByApartmentAndYear);

            // var isAllApartments = selectedApartmentId === 'all';
            var isAllYears = selectedYear === 'all';

            var filteredDataYearly = apartmentViews[selectedApartmentId].yearly_views;

            if (!isAllYears) {

                var filteredDataForYear = {};

                if (yearlyMonthlyViews[selectedApartmentId] && yearlyMonthlyViews[selectedApartmentId][selectedYear]) {
                    filteredDataForYear = yearlyMonthlyViews[selectedApartmentId][selectedYear];
                }

                // update dell'asse x per mostrare i mesi
                var months = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre",
                    "Ottobre", "Novembre", "Dicembre"
                ];

                myYearlyApartmentViewsChart.data.labels = months;
                myYearlyApartmentViewsChart.data.datasets[0].data = Object.values(filteredDataForYear);
            } else {
                // Reset dell'asse x per mostrare gli anni
                myYearlyApartmentViewsChart.data.labels = Object.keys(filteredDataYearly);
                myYearlyApartmentViewsChart.data.datasets[0].data = Object.values(filteredDataYearly);
            }

            myYearlyApartmentViewsChart.update(); // Update del grafico
        }

        // Funzione per aggiornare il grafico dei messaggi
        function updateYearlyApartmentMessagesChart() {
            var selectedApartmentId = document.getElementById('userApartment').value;
            var selectedYear = document.getElementById('yearMessageFilter').value;
            var yearlyMonthlyMessages = @json($MessagesByApartmentAndYear);

            // var isAllApartments = selectedApartmentId === 'all';
            var isAllYears = selectedYear === 'all';

            var filteredDataYearly = apartmentMessages[selectedApartmentId].yearly_Messages;

            if (!isAllYears) {

                var filteredDataForYear = {};

                if (yearlyMonthlyMessages[selectedApartmentId] && yearlyMonthlyMessages[selectedApartmentId][
                        selectedYear
                    ]) {
                    filteredDataForYear = yearlyMonthlyMessages[selectedApartmentId][selectedYear];
                }

                // update dell'asse x per mostrare i mesi
                var months = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre",
                    "Ottobre", "Novembre", "Dicembre"
                ];

                myYearlyApartmentMessageChart.data.labels = months;
                myYearlyApartmentMessageChart.data.datasets[0].data = Object.values(filteredDataForYear);
            } else {
                // Reset dell'asse x per mostrare gli anni
                myYearlyApartmentMessageChart.data.labels = Object.keys(filteredDataYearly);
                myYearlyApartmentMessageChart.data.datasets[0].data = Object.values(filteredDataYearly);
            }

            myYearlyApartmentMessageChart.update(); // Update del grafico
        }

        // Chiamata alla funzione per aggiornare il grafico dei singoli appartamenti
        updateYearlyApartmentViewsChart();
        updateYearlyApartmentMessagesChart();
    </script>
@endsection

<style>
    .container-top {
        display: flex;
        flex-direction: column;
        align-items: center
    }

    .container-canvas {
        display: flex;
        justify-content: center;
        padding-top: 3rem;
    }
</style>
