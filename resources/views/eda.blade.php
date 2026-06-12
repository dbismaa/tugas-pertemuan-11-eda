<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard EDA Kelulusan Mahasiswa</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * { box-sizing: border-box; font-family: "Segoe UI", Arial, sans-serif; }
        body { margin: 0; background: #eef3f8; color: #1f2937; }
        .container { width: 94%; max-width: 1200px; margin: 22px auto; }

        .header {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            padding: 22px 26px;
            border-radius: 18px;
            margin-bottom: 18px;
        }

        .header h1 { margin: 0 0 6px; font-size: 26px; }
        .header p { margin: 0; opacity: .9; font-size: 14px; }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 18px;
        }

        .card, .section {
            background: white;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 8px 22px rgba(0,0,0,.06);
        }

        .card span { color: #6b7280; font-size: 13px; }
        .card h2 { margin: 6px 0 0; font-size: 28px; }

        .success { color: #16a34a; }
        .danger { color: #dc2626; }
        .primary { color: #2563eb; }

        .grid-main {
            display: grid;
            grid-template-columns: 1.25fr .75fr;
            gap: 14px;
            margin-bottom: 18px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: .8fr 1fr 1fr;
            gap: 14px;
            margin-bottom: 18px;
            align-items: start;
        }

        h3 { margin: 0 0 12px; font-size: 17px; }

        .chart-scatter {
            height: 410px;
        }

        .chart-scatter canvas {
            height: 315px !important;
            max-height: 315px !important;
        }

        .small-chart {
            height: 260px;
        }

        .small-chart canvas {
            height: 180px !important;
            max-height: 180px !important;
        }

        canvas { width: 100% !important; }

        .correlation-item { margin-bottom: 14px; }

        .label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .bar {
            height: 9px;
            background: #e5e7eb;
            border-radius: 999px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #2563eb, #60a5fa);
            border-radius: 999px;
        }

        .insight {
            background: #eff6ff;
            border-left: 5px solid #2563eb;
            padding: 13px;
            border-radius: 12px;
            line-height: 1.55;
            font-size: 13px;
        }

        .anomaly {
            background: #fff7ed;
            border-left: 5px solid #f97316;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 8px;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border-radius: 12px;
            overflow: hidden;
        }

        th {
            background: #1e40af;
            color: white;
            padding: 11px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 10px 11px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        tr:hover { background: #f9fafb; }

        .badge {
            padding: 4px 9px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-success { background: #dcfce7; color: #166534; }
        .badge-danger { background: #fee2e2; color: #991b1b; }

        @media (max-width: 900px) {
            .cards, .grid-main, .grid-3 { grid-template-columns: 1fr; }
            .container { width: 96%; }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <h1>Dashboard EDA Kelulusan Mahasiswa</h1>
        <p>Analisis pola titik, tren, korelasi, distribusi, dan anomali terhadap kelulusan tepat waktu.</p>
    </div>

    <div class="cards">
        <div class="card">
            <span>Total Mahasiswa</span>
            <h2 class="primary">{{ $total }}</h2>
        </div>

        <div class="card">
            <span>Lulus Tepat Waktu</span>
            <h2 class="success">{{ $tepatWaktu }}</h2>
        </div>

        <div class="card">
            <span>Tidak Tepat Waktu</span>
            <h2 class="danger">{{ $tidakTepatWaktu }}</h2>
        </div>
    </div>

    <div class="grid-main">
        <div class="section chart-scatter">
            <h3>Pola Titik Kelulusan Mahasiswa</h3>
            <canvas id="scatterChart"></canvas>
        </div>

        <div class="section">
            <h3>Korelasi Terhadap Kelulusan</h3>

            @php
                $ipkWidth = min(abs($rIpk) * 100, 100);
                $hadirWidth = min(abs($rKehadiran) * 100, 100);
                $sksWidth = min(abs($rSks) * 100, 100);
            @endphp

            <div class="correlation-item">
                <div class="label"><span>IPK</span><b>{{ $rIpk }}</b></div>
                <div class="bar"><div class="bar-fill" style="width: {{ $ipkWidth }}%"></div></div>
            </div>

            <div class="correlation-item">
                <div class="label"><span>Kehadiran</span><b>{{ $rKehadiran }}</b></div>
                <div class="bar"><div class="bar-fill" style="width: {{ $hadirWidth }}%"></div></div>
            </div>

            <div class="correlation-item">
                <div class="label"><span>SKS Lulus</span><b>{{ $rSks }}</b></div>
                <div class="bar"><div class="bar-fill" style="width: {{ $sksWidth }}%"></div></div>
            </div>

            <div class="insight">
                <b>Insight:</b><br>
                Pola titik menunjukkan bahwa mahasiswa dengan kehadiran tinggi, IPK baik,
                dan SKS lulus yang cukup cenderung lebih banyak lulus tepat waktu.
            </div>
        </div>
    </div>

    <div class="grid-3">
        <div class="section small-chart">
            <h3>Distribusi Kelulusan</h3>
            <canvas id="pieChart"></canvas>
        </div>

        <div class="section small-chart">
            <h3>Rata-rata IPK</h3>
            <canvas id="ipkChart"></canvas>
        </div>

        <div class="section small-chart">
            <h3>Rata-rata Kehadiran</h3>
            <canvas id="kehadiranChart"></canvas>
        </div>
    </div>

    <div class="section">
        <h3>Anomali Data</h3>

        @if($outliers->count() > 0)
            @foreach($outliers as $data)
                <div class="anomaly">
                    <b>ID {{ $data->id }}</b> memiliki IPK {{ $data->ipk }},
                    kehadiran {{ $data->kehadiran }}%,
                    SKS {{ $data->sks_lulus }},
                    tetapi tidak lulus tepat waktu.
                </div>
            @endforeach
        @else
            <p>Tidak ditemukan anomali data.</p>
        @endif
    </div>

    <div class="section" style="margin-top: 18px;">
        <h3>Data Mahasiswa</h3>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IPK</th>
                    <th>Kehadiran</th>
                    <th>SKS Lulus</th>
                    <th>Status Kerja</th>
                    <th>Tepat Waktu</th>
                </tr>
            </thead>

            <tbody>
                @foreach($dataset as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->ipk }}</td>
                    <td>{{ $data->kehadiran }}%</td>
                    <td>{{ $data->sks_lulus }}</td>
                    <td>{{ $data->status_kerja }}</td>
                    <td>
                        @if($data->tepat_waktu == 'Ya')
                            <span class="badge badge-success">Ya</span>
                        @else
                            <span class="badge badge-danger">Tidak</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
    const tepatWaktuData = [
        @foreach($dataset->where('tepat_waktu', 'Ya') as $data)
            {
                x: {{ $data->kehadiran }} + (Math.random() - 0.5) * 0.7,
                y: {{ $data->ipk }} + (Math.random() - 0.5) * 0.08,
                asliX: {{ $data->kehadiran }},
                asliY: {{ $data->ipk }}
            },
        @endforeach
    ];

    const tidakTepatWaktuData = [
        @foreach($dataset->where('tepat_waktu', 'Tidak') as $data)
            {
                x: {{ $data->kehadiran }} + (Math.random() - 0.5) * 0.7,
                y: {{ $data->ipk }} + (Math.random() - 0.5) * 0.08,
                asliX: {{ $data->kehadiran }},
                asliY: {{ $data->ipk }}
            },
        @endforeach
    ];

    new Chart(document.getElementById('scatterChart'), {
        type: 'scatter',
        data: {
            datasets: [
                {
                    label: 'Tepat Waktu',
                    data: tepatWaktuData,
                    backgroundColor: 'rgba(22, 163, 74, 0.62)',
                    borderColor: '#16a34a',
                    pointRadius: 3,
                    pointHoverRadius: 6
                },
                {
                    label: 'Tidak Tepat Waktu',
                    data: tidakTepatWaktuData,
                    backgroundColor: 'rgba(220, 38, 38, 0.68)',
                    borderColor: '#dc2626',
                    pointRadius: 3,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, font: { size: 12 } }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label +
                                ' | Kehadiran: ' + context.raw.asliX +
                                '% | IPK: ' + context.raw.asliY;
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: { display: true, text: 'Kehadiran (%)' },
                    min: 59,
                    max: 101,
                    grid: { color: 'rgba(0,0,0,0.08)' }
                },
                y: {
                    title: { display: true, text: 'IPK' },
                    min: 1.8,
                    max: 4.1,
                    grid: { color: 'rgba(0,0,0,0.08)' }
                }
            }
        }
    });

    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Tepat Waktu', 'Tidak Tepat Waktu'],
            datasets: [{
                data: [{{ $tepatWaktu }}, {{ $tidakTepatWaktu }}],
                backgroundColor: ['#16a34a', '#dc2626']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '58%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 10, font: { size: 10 } }
                }
            }
        }
    });

    new Chart(document.getElementById('ipkChart'), {
        type: 'bar',
        data: {
            labels: ['Tepat Waktu', 'Tidak Tepat Waktu'],
            datasets: [{
                label: 'Rata-rata IPK',
                data: [{{ $rataIpkTepat }}, {{ $rataIpkTidak }}],
                backgroundColor: ['#16a34a', '#dc2626']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, max: 4 }
            }
        }
    });

    new Chart(document.getElementById('kehadiranChart'), {
        type: 'bar',
        data: {
            labels: ['Tepat Waktu', 'Tidak Tepat Waktu'],
            datasets: [{
                label: 'Rata-rata Kehadiran (%)',
                data: [{{ $rataKehadiranTepat }}, {{ $rataKehadiranTidak }}],
                backgroundColor: ['#16a34a', '#dc2626']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, max: 100 }
            }
        }
    });
</script>

</body>
</html>