<?php

namespace App\Exports;

use App\Bills;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
class BillsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Bills::all();
    }
    public function headings(): array
    {
        return [
            'Supplier Name',
            'Site Name',
            'REF NO',
            'Added On',
            'Item',
            'Total Cost',
            'Balance',
            'Amount Paid',
            'VAT',
            'Description'
        ];
    }
}
