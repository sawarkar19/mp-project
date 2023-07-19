<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class ExportContact implements FromCollection,WithHeadings,WithEvents,WithStyles
{
    use Exportable;
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings():array{
        return[
            'SR NO',
            'Name',
            'Mobile Number',
            'Email',
            'Message',
            'Date'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => [
                        'font' => ['bold' => true],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],

                        ],
                    ],

            'A:G' => [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ]
                    ],
        ];
    }

    public function registerEvents(): array
    {
        return [
                AfterSheet::class => function (AfterSheet $event) 
                {
                    $event->sheet->getColumnDimension('A')->setWidth(10);
                    $event->sheet->getColumnDimension('B')->setWidth(20);
                    $event->sheet->getColumnDimension('C')->setWidth(30);
                    $event->sheet->getColumnDimension('D')->setWidth(40);
                    $event->sheet->getColumnDimension('E')->setWidth(50);
                    $event->sheet->getColumnDimension('F')->setWidth(20);
                },
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
