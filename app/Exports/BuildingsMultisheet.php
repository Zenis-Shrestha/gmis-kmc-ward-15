<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\BuildingsInfoExport;
use App\Exports\BusinessInfoExport;
use App\Exports\RentInfoExport;

class BuildingsMultisheet implements WithMultipleSheets
{
    private $long;
    private $bin;
    private $lat;

    public function __construct($lat, $long, $bin)
    {
        $this->long = $long;
        $this->bin = $bin;
        $this->lat = $lat;
  
    }

    public function sheets(): array
    {
        $sheets = [];
        
            $sheets[] = new BuildingsInfoExport($this->lat, $this->long);
            $sheets[] = new BusinessInfoExport($this->bin);
            $sheets[] = new RentInfoExport($this->bin);
        
        return $sheets;
    }
}