<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;

class BusinessInfoAreaExport implements FromView, WithTitle, WithEvents
{
    private $geom;
    
    
    public function __construct($geom)
    {
        
        $this->geom = $geom;
    }
    public function view(): View
    {
        $geom = $this->geom;
     

        $buildingbusiness= " SELECT bin,ward,roadname,houseno,houseownername,ownerphone,houseownermail,businesowner,businessname,businesstype,category,businessoprdate,registration,oldinternalnumber,taxlastdate,businessownermobile,email,remarks
        FROM bldg_business_tax
        WHERE ST_Intersects(geom, ST_GeomFromText('$geom' , 4326))";
      
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