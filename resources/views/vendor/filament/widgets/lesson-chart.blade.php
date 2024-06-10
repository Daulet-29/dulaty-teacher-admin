<x-filament::widget>
    <x-filament::card>
        <h2>{{ $this->heading }}</h2>
        <canvas id="lessonChart"></canvas>
        <p>{{ $this->getDescription() }}</p>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('lessonChart').getContext('2d');
                const data = @json($this->getData());

                const chart = new Chart(ctx, {
                    type: '{{ $this->getType() }}',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    </x-filament::card>
</x-filament::widget>
