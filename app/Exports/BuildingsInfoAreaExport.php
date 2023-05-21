<?php

namespace App\Exports;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;

class BuildingsInfoAreaExport implements FromView, WithTitle, WithEvents
{ 
    private $geom;

    public function __construct($geom)
    {
        
        $this->geom = $geom;

    }
    public function view(): View
    { 
       
        $geom = $this->geom;
        
        $buildingQuery =  "SELECT b.bin, b.ward, b.tole, b.haddr, b.hownr, b.yoc, b.flrcount, bu.name AS building_use, bc.name AS construction_type, s.strtnm AS street, due.name AS tax_status
        FROM bldg b
        LEFT JOIN building_use bu ON b.bldguse = bu.value
        LEFT JOIN building_construction bc ON b.consttyp = bc.value
        left join bldg_tax_payment_status tax ON tax.bin = b.bin
        left join due_years due ON due.value = tax.due_year
        LEFT JOIN street s ON b.strtcd = s.strtcd
        WHERE ST_Intersects(b.geom, ST_GeomFromText('$geom' , 4326))";
       
        $buildingResults = DB::select($buildingQuery);
   
        return view('exports.buildings', compact('buildingResults'));
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
        return 'Buildings List';
    }
}
