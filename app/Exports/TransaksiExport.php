<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fromDate;
    protected $toDate;

    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function collection()
    {
        return Transaksi::with('user')
            ->whereBetween('created_at', [$this->fromDate, $this->toDate])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kode',
            'User Name',
            'Metode',
            'Jenis',
            'Status',
            'Keterangan',
            'Created At'
        ];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->kode,
            $transaksi->user->name,
            ucfirst($transaksi->metode),
            ucfirst($transaksi->jenis),
            $this->getStatusLabel($transaksi->status),
            $transaksi->keterangan,
            $transaksi->created_at->format('Y-m-d H:i:s'),
        ];
    }

    private function getStatusLabel($status)
    {
        switch ($status) {
            case '0':
                return 'Belum Lunas';
            case '1':
                return 'Cicil';
            case '2':
                return 'Lunas';
            default:
                return 'Unknown';
        }
    }
}
