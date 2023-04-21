<?php

namespace App\Imports;

Use App\Models\WaterSupplyInfo\WaterSupply;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;

class WaterSupplyImport implements ToModel, WithHeadingRow, WithChunkReading,WithValidation, SkipsOnError
{
    use Importable;
    
    public function model(array $row)
    {
        return new WaterSupply([
            "tax_id" => $row['tax_id'],
            "owner_name" => $row['owner_name']?$row['owner_name']:'',
            "gender" => $row['gender']?$row['gender']:'',
            "contact_no" => $row['contact_no']?$row['contact_no']:'',
            "last_payment_date" => $row['last_payment_date']
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
            'tax_id' => [
                'required',
                'string',
            ],
             'last_payment_date' => [
                 'nullable',
                 'date',
             //'regex:/\d{1,2}\/\d{1,2}\/\d{4}/'
            ],
        ];
    }

    public function onError(\Throwable $e) {
        
    }

}