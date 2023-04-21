<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\BuildingsInfoAreaExport;
use App\Exports\BusinessInfoAreaExport;
use App\Exports\RentInfoAreaExport;

class BuildingsAreaMultisheet implements WithMultipleSheets
{
    private $geom;

    public function __construct($geom)
    {
        
        $this->geom = $geom;
  
    }

    public function sheets(): array
    {
        $sheets = [];
            $sheets[] = new BuildingsInfoAreaExport($this->geom);
            $sheets[] = new BusinessInfoAreaExport($this->geom);
            $sheets[] = new RentInfoAreaExport($this->geom);
        
        return $sheets;
    }
}