<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gráfico de ofertas por ciclo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div style="width: 800px; margin: 0 auto;">
                        <canvas id="myChart"></canvas>
                    </div>

                    <script>
                        var cycles = {!! json_encode($cycles->pluck('cliteral')) !!};
                        var offerCounts = {!! json_encode($cycles->map(function($cycle) {
                            return $cycle->jobOffer->count();
                        })) !!};

                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: cycles,
                                datasets: [{
                                    label: 'Ofertas por ciclo',
                                    data: offerCounts,
                                    backgroundColor: 'rgba(255, 0, 0, 0.5)',
                                    borderColor: 'rgba(255, 0, 0, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
