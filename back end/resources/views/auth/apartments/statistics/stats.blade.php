@extends('layouts.app')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <section>

        @if ($views->isEmpty())
            <div class="col-12 text-center">
                <h3 class="text-white">Non hai nessuna statistica da visualizzare</h3>
                <div class="d-flex justify-content-center align-items-center gap-3 flex-column flex-md-row mt-2">
                    <button class="btn my_btn"><a class="text-decoration-none my_link" href="{{ route('admin.apartments.create') }}">Aggiungi un appartamento</a></button>
                    <button class="btn my_btn"><a class="text-decoration-none my_link" href="{{ route('admin.sponsorships.index') }}">Sponsorizza i tuoi appartamenti</a></button>
                </div>
                <div class="col-12 mx-auto">
                    <div class="d-flex justify-center">
                        <img src="http://localhost:8000/images/logo/Bool_Bnb_Black.png" alt="logo" class="img-fluid mx-auto">
                    </div>
                </div>
            </div>

        @else
            
            <div class="col-12">

                <div class="col-12 col-lg-8 col-xxl-5 mx-auto text-center my-5">
                    <div class="card p-2 my-3 shadow my_bg_chart">
                        <div class="d-flex justify-content-center pb-2">
                            <h2 class="text-gradient">Statistiche Singolo Appartamento</h2>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center gap-3">
                            <input type="hidden" id="userApartment" value="{{ $userApartment->id }}">    
                       
                            <select id="yearFilter" class="my_select">
                                <option value="all">Tutti gli anni</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- stats singolo appartamento e tutti gli anni dello user --}}
                        <canvas id="myYearlyApartmentChart"></canvas>
                    </div>
                </div>
            </div>
        @endif

    </section>

    <script>

        // Chart per tutti gli appartamenti e tutti gli anni dello user
        var dataYearly = @json($yearlyViews);
        var apartmentViews = @json($apartmentViews);

        // Chart per singolo appartamento e tutti gli anni dello user
        var ctxYearlyApartment = document.getElementById('myYearlyApartmentChart').getContext('2d');

        var myYearlyApartmentChart = new Chart(ctxYearlyApartment, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Visualizzazioni',
                    data: dataYearly,
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

      

        // Event listeners per cambiare anno
        document.getElementById('yearFilter').addEventListener('change', function () {
            updateYearlyApartmentChart();
        });

        // Funzione per aggiornare il grafico dei singoli appartamenti
        function updateYearlyApartmentChart() {
            var selectedApartmentId = document.getElementById('userApartment').value;
            var selectedYear = document.getElementById('yearFilter').value;
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
                var months = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"];

                myYearlyApartmentChart.data.labels = months;
                myYearlyApartmentChart.data.datasets[0].data = Object.values(filteredDataForYear);
            } else {
                // Reset dell'asse x per mostrare gli anni
                myYearlyApartmentChart.data.labels = Object.keys(filteredDataYearly);
                myYearlyApartmentChart.data.datasets[0].data = Object.values(filteredDataYearly);
            }

            myYearlyApartmentChart.update(); // Update del grafico
        }

        // Chiamata alla funzione per aggiornare il grafico dei singoli appartamenti
        updateYearlyApartmentChart();
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