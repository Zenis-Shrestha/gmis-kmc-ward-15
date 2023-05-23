<?php

namespace App\Imports;

use App\BldgTaxPayment;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use MilanTarami\NepaliCalendar\Facades\NepaliCalendar;

class TaxImport implements ToModel, WithHeadingRow, WithChunkReading,WithValidation, SkipsOnError
{
    use Importable;
    
    public function model(array $row)
    {
        if($row['fiscal_year'])
        {
        $fiscal_year = explode("/",$row['fiscal_year']);
        $tax_paid_end_year = $fiscal_year[1] + 1;
        $tax_paid_end_at = $tax_paid_end_year.'-03-31';
        }
        else{
            $tax_paid_end_at = null;
        }
        return new BldgTaxPayment([
            "bin" => $row['bin'],
            "owner_name" => $row['owner_name'],
            "fiscal_year" => $row['fiscal_year'],
            "tax_paid_end_at" => $tax_paid_end_at,
           
        ]);
    }
      
    public function chunkSize(): int
    {
        return 1000;
    }
    /**
    * @return array
    */
    public function rules(): array {
         return [
            'bin' => [
                'required',
                'integer',
                'unique:bldg_tax_payments,bin',
                
            ],
            'owner_name' => [
                'nullable',
                'string',
            ],
             'fiscal_year' => [
                 'nullable',
                 'string',
             //'regex:/\d{1,2}\/\d{1,2}\/\d{4}/'
            ],
           
        ];
    }

    public function onError(\Throwable $e) {
        
    }
    

       
}