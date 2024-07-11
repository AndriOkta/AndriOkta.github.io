<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Kk;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;

class EksporController extends Controller
{
    // Controller
    public function exportData(Request $request)
    {
        $format = $request->input('format', 'csv');
        $data = $this->getJemaatData();

        switch ($format) {
            case 'csv':
                return $this->exportToCSV($data);
            case 'excel':
                return $this->exportToExcel($data);
            case 'pdf':
                return $this->exportToPDF($data);
            default:
                return redirect()->back()->with('error', 'Format ekspor tidak valid.');
        }
    }

    private function getJemaatData()
    {
        $kks = Kk::with('anggotas')->get();
        $data = [];

        foreach ($kks as $kk) {
            $row = [
                'No. KK' => $kk->no_kk,
                'Nama Kepala Keluarga' => $kk->nama_kepala_keluarga,
                'Alamat' => $kk->alamat,
                'RT/RW' => $kk->rt_rw,
                'Kode Pos' => $kk->kode_pos,
                'Desa/Kelurahan' => $kk->desa_kelurahan,
                'Kecamatan' => $kk->kecamatan,
                'Kabupaten/Kota' => $kk->kabupaten_kota,
                'Provinsi' => $kk->provinsi,
            ];

            foreach ($kk->anggotas as $anggota) {
                $row['No. KTP'] = $anggota->no_ktp;
                $row['Nama'] = $anggota->nama;
                $row['Tempat, Tanggal Lahir'] = $anggota->ttl;
                $row['Jenis Kelamin'] = $anggota->jenis_kelamin;
                $row['Status'] = $anggota->status;
                $row['Pekerjaan'] = $anggota->pekerjaan;
                $row['Baptis'] = $anggota->baptis;
                $data[] = $row;
            }
        }

        return $data;
    }

    private function exportToCSV($data)
    {
        $filename = 'jemaat_data.csv';
        $headers = array_keys($data[0]);

        $callback = function () use ($data, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function exportToExcel($data)
    {
        $filename = 'jemaat_data.xlsx';
        $spreadsheet = new Spreadsheet  ();
        $sheet = $spreadsheet->getActiveSheet();

        // Tulis header
        $sheet->fromArray(array_keys($data[0]), null, 'A1');

        // Tulis data
        $row = 2;
        foreach ($data as $rowData) {
            $sheet->fromArray($rowData, null, 'A' . $row++);
        }

        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    // public function exportToPDF()
    // {
    //     $data = Anggota::with('keluarga')->get()->map(function ($anggota) {
    //         $rt_rw = explode('/', $anggota->keluarga->rt_rw);
    //         return [
    //             'no_ktp' => $anggota->no_ktp,
    //             'nama' => $anggota->nama,
    //             'ttl' => $anggota->ttl,
    //             'jenis_kelamin' => $anggota->jenis_kelamin,
    //             'status' => $anggota->status,
    //             'pekerjaan' => $anggota->pekerjaan,
    //             'baptis' => $anggota->baptis,
    //             'no_kk' => $anggota->keluarga->no_kk,
    //             'nama_kepala_keluarga' => $anggota->keluarga->nama_kepala_keluarga,
    //             'alamat' => $anggota->keluarga->alamat,
    //             'rt' => $rt_rw[0],
    //             'rw' => $rt_rw[1],
    //             'desa_kelurahan' => $anggota->keluarga->desa_kelurahan,
    //             'kecamatan' => $anggota->keluarga->kecamatan,
    //             'kabupaten_kota' => $anggota->keluarga->kabupaten_kota,
    //             'provinsi' => $anggota->keluarga->provinsi,
    //             'kode_pos' => $anggota->keluarga->kode_pos,
    //         ];
    //     });
    
    //     $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
    //     $pdf->SetCreator('GMII Sola Gratia PTK');
    //     $pdf->SetAuthor('GMII Sola Gratia PTK');
    //     $pdf->SetTitle('Data Jemaat');
    //     $pdf->SetSubject('Ekspor Data Jemaat ke PDF');
    //     $pdf->SetKeywords('jemaat, data, pdf');
    
    //     $pdf->AddPage();
    
    //     // Buat tabel
    //     $pdf->SetFont('helvetica', '', 9);
    //     $pdf->SetFillColor(255, 255, 255);
    //     $pdf->SetTextColor(0, 0, 0);
    //     $pdf->SetDrawColor(0, 0, 0);
    //     $pdf->SetLineWidth(0.2);
    //     $pdf->SetFillColor(240, 240, 240);
    
    //     // Tulis header tabel
    //     $pdf->Cell(25, 7, 'No. KTP', 1, 0, 'C', 1);
    //     $pdf->Cell(30, 7, 'Nama', 1, 0, 'C', 1);
    //     $pdf->Cell(40, 7, 'TTL', 1, 0, 'C', 1);
    //     $pdf->Cell(20, 7, 'Jenis Kelamin', 1, 0, 'C', 1);
    //     $pdf->Cell(20, 7, 'Status', 1, 0, 'C', 1);
    //     $pdf->Cell(20, 7, 'Pekerjaan', 1, 0, 'C', 1);
    //     $pdf->Cell(25, 7, 'Baptis', 1, 0, 'C', 1);
    //     $pdf->Cell(25, 7, 'No. KK', 1, 0, 'C', 1);
    //     $pdf->Cell(40, 7, 'Nama Kepala Keluarga', 1, 0, 'C', 1);
    //     $pdf->Cell(40, 7, 'Alamat', 1, 0, 'C', 1);
    //     $pdf->Cell(10, 7, 'RT', 1, 0, 'C', 1);
    //     $pdf->Cell(10, 7, 'RW', 1, 0, 'C', 1);
    //     $pdf->Cell(20, 7, 'Desa/Kelurahan', 1, 0, 'C', 1);
    //     $pdf->Cell(20, 7, 'Kecamatan', 1, 0, 'C', 1);
    //     $pdf->Cell(20, 7, 'Kabupaten/Kota', 1, 0, 'C', 1);
    //     $pdf->Cell(20, 7, 'Provinsi', 1, 0, 'C', 1);
    //     $pdf->Cell(15, 7, 'Kode Pos', 1, 1, 'C', 1);
    
    //     // Tulis data tabel
    //     foreach ($data as $row) {
    //         $pdf->Cell(25, 7, $row['no_ktp'], 1, 0, 'C', 0);
    //         $pdf->Cell(30, 7, $row['nama'], 1, 0, 'L', 0);
    //         $pdf->Cell(40, 7, $row['ttl'], 1, 0, 'L', 0);
    //         $pdf->Cell(20, 7, $row['jenis_kelamin'], 1, 0, 'C', 0);
    //         $pdf->Cell(20, 7, $row['status'], 1, 0, 'C', 0);
    //         $pdf->Cell(20, 7, $row['pekerjaan'], 1, 0, 'C', 0);
    //         $pdf->Cell(25, 7, $row['baptis'], 1, 0, 'C', 0);
    //         $pdf->Cell(25, 7, $row['no_kk'], 1, 0, 'C', 0);
    //         $pdf->Cell(40, 7, $row['nama_kepala_keluarga'], 1, 0, 'L', 0);
    //         $pdf->Cell(40, 7, $row['alamat'], 1, 0, 'L', 0);
    //         $pdf->Cell(10, 7, $row['rt'], 1, 0, 'C', 0);
    //         $pdf->Cell(10, 7, $row['rw'], 1, 0, 'C', 0);
    //         $pdf->Cell(20, 7, $row['desa_kelurahan'], 1, 0, 'L', 0);
    //         $pdf->Cell(20, 7, $row['kecamatan'], 1, 0, 'L', 0);
    //         $pdf->Cell(20, 7, $row['kabupaten_kota'], 1, 0, 'L', 0);
    //         $pdf->Cell(20, 7, $row['provinsi'], 1, 0, 'L', 0);
    //         $pdf->Cell(15, 7, $row['kode_pos'], 1, 1, 'C', 0);
    //     }
    
    //     $pdf->Output('jemaat_data.pdf', 'I');
    // }

}
