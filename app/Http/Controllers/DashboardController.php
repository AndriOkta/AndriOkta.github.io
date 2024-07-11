<?php

namespace App\Http\Controllers;


use App\Charts\GenderChart;
use App\Models\Anggota;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $maleCount = Anggota::where('jenis_kelamin', 'Laki-laki')->count();
        $femaleCount = Anggota::where('jenis_kelamin', 'Perempuan')->count();

        $genderChart = LarapexChart::barChart()
            ->setTitle('Jenis Kelamin')
            ->addData('Laki-laki', [$maleCount])
            ->addData('Perempuan', [$femaleCount])
            ->setXAxis(['Jenis Kelamin'])
            ->setOptions([
                'legend' => [
                    'display' => false,
                ],
            ]);

            // Membuat chart usia
            $ageData = Anggota::selectRaw("
            CASE
                WHEN FLOOR(DATEDIFF(CURDATE(), STR_TO_DATE(SUBSTR(ttl, LOCATE(',', ttl) + 2), '%d-%m-%Y')) / 365.25) < 6 THEN 'Balita'
                WHEN FLOOR(DATEDIFF(CURDATE(), STR_TO_DATE(SUBSTR(ttl, LOCATE(',', ttl) + 2), '%d-%m-%Y')) / 365.25) BETWEEN 6 AND 12 THEN 'Anak-anak'
                WHEN FLOOR(DATEDIFF(CURDATE(), STR_TO_DATE(SUBSTR(ttl, LOCATE(',', ttl) + 2), '%d-%m-%Y')) / 365.25) BETWEEN 13 AND 25 THEN 'Remaja/Pemuda'
                WHEN FLOOR(DATEDIFF(CURDATE(), STR_TO_DATE(SUBSTR(ttl, LOCATE(',', ttl) + 2), '%d-%m-%Y')) / 365.25) BETWEEN 26 AND 59 THEN 'Dewasa'
                ELSE 'Lansia'
            END AS age_group,
            COUNT(*) AS count
            ")
            ->groupBy('age_group')
            ->pluck('count', 'age_group')
            ->toArray();
        
        $totalCount = array_sum($ageData);
        
        $ageDataPercentage = array_map(function($count) use ($totalCount) {
            return round(($count / $totalCount) * 100);
        }, $ageData);
        
        // Menambahkan tanda "%" di label untuk menampilkan di chart
        $ageLabels = array_map(function($ageGroup, $percentage) {
            return $ageGroup . ' (' . $percentage . '%)';
        }, array_keys($ageData), $ageDataPercentage);
        
        $ageChart = LarapexChart::pieChart()
            ->setTitle('Persentase Anggota Berdasarkan Kelompok Usia')
            ->addData(array_values($ageDataPercentage))  // Menggunakan data persentase tanpa tanda "%"
            ->setLabels($ageLabels)  // Menambahkan label dengan tanda "%"
            ->setOptions([
                'legend' => [
                    'position' => 'right',
                ],
            ]);
            
       // Menghitung jumlah anggota yang sudah dan belum baptis
        $baptisCount = Anggota::where('baptis', 'Sudah Baptis')->count();
        $notBaptisCount = Anggota::where('baptis', 'Belum Baptis')->count();

        // Chart baptis
        $baptisChart = LarapexChart::pieChart()
            ->setTitle('Status Baptis Anggota')
            ->addData([$baptisCount, $notBaptisCount])
            ->setLabels(['Baptis', 'Belum Baptis'])
            ->setOptions([
                'legend' => [
                    'position' => 'bottom',
                ],
            ]);

        // Menyiapkan data untuk dikirim ke view
        $data = [
            'gender_chart' => $genderChart,
            'age_chart' => $ageChart,
            'baptis_chart' => $baptisChart,
        ];

        return view('dashboard', $data);
    }
}
