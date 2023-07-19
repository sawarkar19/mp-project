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

class ContactExport implements FromCollection, WithHeadings, WithEvents, WithStyles
{
    use Exportable;
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return ['SR NO', 'Whatsapp Number', 'Customer Name', 'Date of Birth ( Day )', 'Date of Birth ( Month )', 'Anniversary Date ( Day )', 'Anniversary Date ( Month )'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => [
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
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet
                    ->getDelegate()
                    ->getStyle('A1:G1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('d8d8d8');

                $event->sheet
                    ->getDelegate()
                    ->getRowDimension('1')
                    ->setRowHeight(25);

                $row_count = collect($this->data)->count() + 1;
                $column_count = count(collect($this->data[0])->toArray());

                // set dropdown column
                $select_columns_month = ['E', 'G'];
                $select_columns_date = ['D', 'F'];

                // set dropdown options
                $options = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                $numbers = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];

                // set dropdown list for first data row
                foreach ($select_columns_month as $select) {
                    $drop_column = $select;
                    $drop_column1 = $select;
                    // set dropdown list for first data row
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation = $event->sheet->getCell("{$drop_column1}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP );
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    $validation->setFormula2(sprintf('"%s"', implode(',', $numbers)));

                    // clone validation to remaining rows
                    for ($i = 3; $i <= $row_count; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                        $event->sheet->getCell("{$drop_column1}{$i}")->setDataValidation(clone $validation);
                    }
                    // set columns to autosize
                    for ($i = 1; $i <= $column_count; $i++) {
                        $column = Coordinate::stringFromColumnIndex($i);
                        $event->sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                }

                foreach ($select_columns_date as $date) {
                    $drop_column1 = $date;
                    // set dropdown list for first data row
                    $validation = $event->sheet->getCell("{$drop_column1}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP );
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $numbers)));

                    // clone validation to remaining rows
                    for ($i = 3; $i <= $row_count; $i++) {
                        $event->sheet->getCell("{$drop_column1}{$i}")->setDataValidation(clone $validation);
                    }
                    // set columns to autosize
                    for ($i = 1; $i <= $column_count; $i++) {
                        $column = Coordinate::stringFromColumnIndex($i);
                        $event->sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                }
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
