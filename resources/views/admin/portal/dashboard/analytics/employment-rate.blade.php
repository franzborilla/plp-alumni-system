<x-app-layout :title="'Analytics'" :navType="'admin'">
    <x-slot name="header">
        <div class="flex flex-row gap-4">
            <a href="{{ route('admin.dashboard') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mt-2" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
                    {{ __('Employment Rate') }}
                </h2>
                <p class="text-gray-600 text-base mt-1">Percentage of alumni currently employed</p>
            </div>
        </div>
    </x-slot>


    <div class="grid grid-cols-2 gap-5 mb-6">
        <div class="flex flex-col">
            <input-label class="mb-1">Select Program</input-label>
            <form method="GET" action="{{ route('employment-rate') }}">
                <input type="hidden" name="college" value="{{ request('college') }}">
                <x-select-input name="program" :options="['' => 'All Program'] + $programs->pluck('course_name', 'course_id')->toArray()" :selected="$selectedProgram" onchange="this.form.submit()" />
            </form>
        </div>
        <div class="flex flex-col">
            <input-label class="mb-1">Select Batch</input-label>
            <form method="GET" action="{{ route('employment-rate') }}">
                <input type="hidden" name="college" value="{{ request('college') }}">
                <input type="hidden" name="program" value="{{ request('program') }}">
                <x-select-input name="batch" :options="['' => 'All Batch'] + $batches->mapWithKeys(fn($b) => [$b => $b])->toArray()" :selected="$selectedBatch" onchange="this.form.submit()" />
            </form>
        </div>
    </div>


    <x-white-card class="p-6 mb-7">
        <h3 class="font-bold text-2xl mb-1 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 me-2" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 15V3" />
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <path d="m7 10 5 5 5-5" />
            </svg>
            Export
        </h3>
        <p>Export employment rates analytics</p>
        <div class="flex space-x-4 mt-4">
            <x-export-button class="export-btn"
                href="{{ route('employment.rate.export.csv', [
                    'college' => request('college'),
                    'program' => request('program'),
                    'batch' => request('batch'),
                ]) }}">
                Export CSV
            </x-export-button>


            <x-export-button class="export-btn" href="javascript:void(0)" onclick="exportPdfWithChart()">
                Export PDF
            </x-export-button>
        </div>
    </x-white-card>


    <x-white-card class="p-6 mb-5">
        <div class="w-full max-w-md mx-auto">
            <canvas id="employmentChart" class="w-full h-64"></canvas>
            <form id="exportPdfForm" action="{{ route('employment.rate.export.pdf') }}" method="GET">
                <input type="hidden" name="college" value="{{ request('college') }}">
                <input type="hidden" name="program" value="{{ request('program') }}">
                <input type="hidden" name="batch" value="{{ request('batch') }}">
                <input type="hidden" name="chart_image" id="chartImage">
            </form>
        </div>
    </x-white-card>
</x-app-layout>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
    const chartData = @json($employmentChartData);
    const total = chartData.reduce((a, b) => a + b, 0);
    const canvas = document.getElementById('employmentChart');
    let jobChart = null;


    if (total === 0) {
        const wrapper = canvas.parentElement;
        wrapper.innerHTML = `
            <div class="flex items-center justify-center h-48 text-md">
                No data available
            </div>
        `;
    } else {
        jobChart = new Chart(canvas, {
            type: 'pie',
            data: {
                labels: ['Full-time', 'Part-time', 'Self-employed', 'Freelance', 'Unemployed'],
                datasets: [{
                    data: chartData,
                    backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#8B5CF6', '#EF4444']
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 14,
                            font: {
                                size: 14
                            },
                            padding: 40
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: value => value > 0 ? value : ''
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }


    function exportPdfWithChart() {
        if (!jobChart) {
            alert("No chart data available.");
            return;
        }
        const base64Image = jobChart.toBase64Image('image/png', 1.0);
        document.getElementById('chartImage').value = base64Image;
        document.getElementById('exportPdfForm').submit();
    }


    if (total === 0) {
        document.querySelectorAll('.export-btn').forEach(btn => {
            btn.style.pointerEvents = 'none';
            btn.style.cursor = 'not-allowed';
            btn.style.opacity = '0.6';
            btn.title = 'No data to export 🚫';
        });
    }
</script>
