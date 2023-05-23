<?php

namespace App\Exports;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;

class BuildingsWithTaxStatusExport implements FromView, WithTitle, WithEvents
{ 
    private $bin;
    private $due_year;
    private $hownr;
    private $tole;
    private $strtcd;
    private $ward;
    
    public function __construct($bin, $due_year, $hownr, $tole, $strtcd, $ward)
    {
        
        $this->bin = $bin;
        $this->due_year = $due_year;
        $this->hownr = $hownr;
        $this->tole = $tole;
        $this->strtcd = $strtcd;
        $this->ward = $ward;

    }
    public function view(): View
    { 
       
         $bin = $this->bin;
         $due_year = $this->due_year;
         $hownr = $this->hownr;
         $tole = $this->tole;
         $strtcd = $this->strtcd;
         $ward = $this->ward;
            $where = "WHERE 1=1";
            if (!empty($bin)) {
                $where .= " AND bldg.bin = ".$bin;
            }

            if (!empty($ward)) {
                $where .= " AND bldg.ward = ".$ward;
            }

//            if (!empty($hownr)) {
//                $where .= " AND bldg.bin = ".$bin;
//            }

            if (!empty($due_year)) {
                $where .= " AND due.name = '".$due_year."'";
            }

            if (!empty($tole)) {
                $where .= " AND bldg.tole = ".$tole;
            }

            if (!empty($strtcd)) {
                $where .= " AND bldg.strtcd = ".$strtcd;
            }

         $buildingResults = DB::select(DB::raw("select bldg.bin,bldg.bldgcd,bldg.ward,bldg.tole,bldg.oldhno,bldg.haddr,bldg.haddrplt,bldg.strtcd,bldg.imgfl,bldg.addrzn,bldg.zonecode,bldg.bldgasc,bldg.bldguse,bldg.offcnm,bldg.hownr,bldg.prclkey,bldg.yoc,bldg.flrcount,bldg.flrar,bldg.consttyp,bldg.elecyn,bldg.bprmtyn,bldg.bprmtno,bldg.buildvflag,bldg.drnkwtr,bldg.wtrcons,bldg.toilyn,bldg.wwdischg,bldg.swsegyn,bldg.sngwoman,bldg.hhcount,bldg.hhpop,bldg.gt60yr,bldg.dsblppl,bldg.datsrc,bldg.txpyrname,bldg.txpyrid,bldg.btxyr,due.name As due_name
            FROM bldg 
            left join bldg_tax_payment_status AS tax ON bldg.bin = tax.bin
            left join due_years AS due ON due.value = tax.due_year $where group by bldg.bin, due.name"));

        return view('exports.buildings-with-tax-status', compact('buildingResults'));
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
