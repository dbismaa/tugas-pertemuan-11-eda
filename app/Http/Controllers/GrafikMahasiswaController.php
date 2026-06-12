<?php

namespace App\Http\Controllers;

use App\Models\PerformaMahasiswa;

class GrafikMahasiswaController extends Controller
{
    public function index()
    {
        $dataset = PerformaMahasiswa::all();

        if ($dataset->isEmpty()) {
            return "Data mahasiswa masih kosong.";
        }

        $total = $dataset->count();
        $tepatWaktu = $dataset->where('tepat_waktu', 'Ya')->count();
        $tidakTepatWaktu = $dataset->where('tepat_waktu', 'Tidak')->count();

        $rIpk = $this->calculateCorrelation($dataset, 'ipk');
        $rKehadiran = $this->calculateCorrelation($dataset, 'kehadiran');
        $rSks = $this->calculateCorrelation($dataset, 'sks_lulus');

        $rataIpkTepat = round($dataset->where('tepat_waktu', 'Ya')->avg('ipk'), 2);
        $rataIpkTidak = round($dataset->where('tepat_waktu', 'Tidak')->avg('ipk'), 2);

        $rataKehadiranTepat = round($dataset->where('tepat_waktu', 'Ya')->avg('kehadiran'), 2);
        $rataKehadiranTidak = round($dataset->where('tepat_waktu', 'Tidak')->avg('kehadiran'), 2);

        $outliers = $dataset->filter(function ($item) {
            return $item->ipk >= 3.5 && $item->tepat_waktu == 'Tidak';
        });

        return view('eda', compact(
            'dataset',
            'total',
            'tepatWaktu',
            'tidakTepatWaktu',
            'rIpk',
            'rKehadiran',
            'rSks',
            'outliers',
            'rataIpkTepat',
            'rataIpkTidak',
            'rataKehadiranTepat',
            'rataKehadiranTidak'
        ));
    }

    private function calculateCorrelation($collection, $xField)
    {
        $n = $collection->count();

        $sumX = $collection->sum($xField);
        $sumY = $collection->sum(function ($item) {
            return $item->tepat_waktu == 'Ya' ? 1 : 0;
        });

        $sumXY = $collection->sum(function ($item) use ($xField) {
            return $item->$xField * ($item->tepat_waktu == 'Ya' ? 1 : 0);
        });

        $sumX2 = $collection->sum(function ($item) use ($xField) {
            return pow($item->$xField, 2);
        });

        $sumY2 = $collection->sum(function ($item) {
            return pow($item->tepat_waktu == 'Ya' ? 1 : 0, 2);
        });

        $numerator = ($n * $sumXY) - ($sumX * $sumY);
        $denominator = sqrt((($n * $sumX2) - pow($sumX, 2)) * (($n * $sumY2) - pow($sumY, 2)));

        return $denominator == 0 ? 0 : round($numerator / $denominator, 4);
    }
}