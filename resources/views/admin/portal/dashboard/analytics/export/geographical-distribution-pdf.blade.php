<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <title>Geographical Distribution Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }


        h1 {
            text-align: center;
            margin-bottom: 10px;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }


        th,
        td {
            border: 1px solid #aaa;
            padding: 6px;
            text-align: center;
            font-size: 13px;
        }


        th {
            background: #f3f3f3;
        }


        .center {
            text-align: center;
        }


        .chart {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 40px;
        }


        h3 {
            margin-top: 20px;
        }
    </style>
</head>


<body>
    <h1>Geographical Distribution Report</h1>
    <p class="center">
        College: <strong>{{ $college ?: 'All Colleges' }}</strong> |
        Program: <strong>{{ $program ?: 'All Programs' }}</strong> |
        Batch: <strong>{{ $batch ?: 'All Batches' }}</strong>
    </p>


    <div class="chart">
        @if ($chartImage)
            <img src="{{ $chartImage }}" alt="Geographical Chart" width="450" style="margin: 15px 0;">
        @else
            <p><em>No chart available</em></p>
        @endif
    </div>


    <h3>Regional Distribution Summary</h3>
    <table>
        <thead>
            <tr>
                <th>Region</th>
                <th>Total Alumni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($regions as $index => $region)
                <tr>
                    <td>{{ $region }}</td>
                    <td>{{ $chartData[$index] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>


</html>
