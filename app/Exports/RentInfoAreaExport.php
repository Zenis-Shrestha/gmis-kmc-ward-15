<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;

class RentInfoAreaExport implements FromView, WithTitle, WithEvents
{
    private $geom;
    
    
    public function __construct($geom)
    {
        
        $this->geom = $geom;
    }
    public function view(): View
    {
        $geom = $this->geom;

        $buildingrent= "SELECT bin,ward,roadname,houseno,taxpayercode,hownername,hownernumber,howneremail,
            housetype,length,width,area,rentername,rentpurpose,rentstart,monthlyrent,rentaxresponsible,rentmobilenumber,rentincreseperyear,remarks
            FROM bldg_rent_tax 
            WHERE ST_Intersects(geom, ST_GeomFromText('$geom' , 4326))";
        
        $buildingResults = DB::select($buildingrent);
        
       
        return view('exports.buildings-rent', compact('buildingResults'));
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
        return 'Buildings Rent List';
    }
}