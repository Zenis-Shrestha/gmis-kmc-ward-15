<?php

namespace App\Exports;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;

class BuildingsInfoExport implements FromView, WithTitle, WithEvents
{ 
    private $lat;
    private $long;

    public function __construct($lat, $long)
    {
        
        $this->lat = $lat;
        $this->long = $long;

    }
    public function view(): View
    { 
       
        $lat = $this->lat;
        $long =  $this->long;

        $buildingQuery =  "SELECT b.gid, b.bin, b.ward, b.tole, b.haddr, b.hownr, b.yoc, b.flrcount, bu.name AS building_use, bc.name AS construction_type, t.name AS tax_status, s.strtnm AS street, ST_AsText(b.geom) AS geom"
            . " FROM bldg b"
            . " LEFT JOIN building_use bu"
            . " ON b.bldguse = bu.value"
            . " LEFT JOIN building_construction bc"
            . " ON b.consttyp = bc.value"
            . " LEFT JOIN tax_status_code t"
            . " ON b.btxsts = t.value"
            . " LEFT JOIN street s"
            . " ON b.strtcd = s.strtcd"
            . " WHERE ST_Contains(b.geom, ST_GeomFromText('POINT(" . $long . " " . $lat . ")', 4326))";
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
