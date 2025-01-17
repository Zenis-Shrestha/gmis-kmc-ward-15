<?php

namespace App\Imports;

use App\BusinessTaxPayment;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use MilanTarami\NepaliCalendar\Facades\NepaliCalendar;

class BusinessTaxImport implements ToModel, WithHeadingRow, WithChunkReading,WithValidation, SkipsOnError
{
    use Importable;
    
    public function model(array $row)
    {
       
        $fiscal_year = explode("/",$row['fiscal_year']);
        //**Added one year 
        //$tax_paid_end_year = $fiscal_year[1] + 1;
        $tax_paid_end_year = $fiscal_year[1];
        $tax_paid_end_at = $tax_paid_end_year.'-03-31';
        
        return new BusinessTaxPayment([
            "registration" => $row['registration'],
            "fiscal_year" => $row['fiscal_year'],
            "tax_paid_end_at" => $tax_paid_end_at
           
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
            'registration' => [
                'required',
                
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