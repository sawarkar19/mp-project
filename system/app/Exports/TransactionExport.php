<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class TransactionExport implements FromCollection,WithHeadings
{

    use Exportable;
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */ 
    public function headings():array{
        return[
            'SR NO',
            'NAME',
            'INVOICE NO',
            'DATE',
            'TRANSACTION ID',
            'AMOUNT',
            'GST CLAIMED' 
        ];
    } 

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([$this->data]);
    }
}
