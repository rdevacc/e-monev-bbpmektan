<?php

namespace App\Exports;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


class ActivityExport implements FromView, ShouldAutoSize, WithEvents
{


    protected $sfi;
    protected $sgi;
    protected $sui;


    /**
     * __construct
     *
     * @param  mixed $sfi
     * @param  mixed $sgi
     * @param  mixed $sui
     * @return void
     */
    public function __construct($sfi, $sgi, $sui)
    {
        $this->sfi = $sfi;
        $this->sgi = $sgi;
        $this->sui = $sui;
    }

    public function view(): View
    {
        $currentMonth = Carbon::now()->month;
        $sfi = $this->sfi;
        $sgi = $this->sgi;
        $sui = $this->sui;

        if (($this->sfi == "undefined" || $this->sfi == null) &&  ($this->sgi == "undefined" || $this->sgi == null) && ($this->sui == "undefined" || $this->sui == null)) {
            $activities = Activity::with('user', 'group', 'field')->whereMonth('created_at', '=', Carbon::now())->latest()->get();
        } else {
            $activities = Activity::with('user', 'group', 'field')->where(function ($query) use ($sfi, $sgi, $sui) {
                $query->where('field_id', '=', $sfi)
                    ->orWhere('group_id', '=', $sgi)
                    ->orWhere('user_id', '=', $sui);
            })->whereMonth('created_at', $currentMonth)->latest()->get();
        }

        return view('exports.activity', [
            'activities' => $activities,
            'next_month' => Carbon::parse(now()->addMonth(1))->translatedFormat('F'),
        ]);
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $headerRange      = 'A1:N1'; // All Header
                $sheet = $event->sheet;

                // Styles
                $sheet->getDelegate()->freezePane('A2'); // freezing here


                // Get the last row and column of the sheet
                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();

                // Loop through each row
                for ($row = 1; $row <= $lastRow; $row++) {
                    // Get the value of a specific cell (change A to the desired column)
                    $cellValue = $sheet->getCell("A{$row}")->getValue();

                    // Example condition: Set border if cell value is greater than 10
                    if ($cellValue > 0) {
                        $sheet->getStyle("A{$row}:{$lastColumn}{$row}")
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(Border::BORDER_THIN);
                        if ($cellValue == 1) {
                            $sheet->getDelegate()->getStyle($headerRange)->getFont()->setBold(true);
                            $sheet->getDelegate()->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                        }
                        $sheet->getDelegate()->getStyle("A{$row}:{$lastColumn}{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_TOP);
                    }
                }
            },
        ];
    }
}
