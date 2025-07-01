<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArrayExport implements FromArray, WithHeadings
{
    protected $data;
    protected $headings;

    public function __construct(array $data, array $headings = null)
    {
        $this->data = $data;
        $this->headings = $headings;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->headings ?? ['Nama Lengkap', 'NIS', 'Kelas', 'Jenis Kelamin'];
    }
}
