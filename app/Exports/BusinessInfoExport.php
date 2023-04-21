<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;

class BusinessInfoExport implements FromView, WithTitle, WithEvents
{
    private $bin;
    
    
    public function __construct($bin)
    {
        
        $this->bin = $bin;
    }
    public function view(): View
    {
        $bin = $this->bin;
     

        $buildingbusiness= "SELECT bin,ward,roadname,houseno,houseownername,ownerphone,houseownermail,businesowner,businessname,businesstype,category,businessoprdate,registration,oldinternalnumber,taxlastdate,businessownermobile,email,remarks,
        ST_AsText(geom) AS geom"
        . " FROM bldg_business_tax"
        . " WHERE bin = " . (int)$bin;
        $buildingResults = DB::select($buildingbusiness);
       
        return view('exports.buildings-business', compact('buildingResults'));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:B1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }
     /**
     * @return string
     */
    public function title(): string
    {
        return 'Buildings Business List';
    }
}