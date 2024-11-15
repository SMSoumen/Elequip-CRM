<?php

namespace App\Imports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CompanyImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        dd($row);
        // return new Company([
        //     //
        // ]);

        if (is_numeric($row[0]) && $row[0] > 0) {
            $company_data = [
                'company_name'      =>  $row[1] ? $row[1] : NULL,
                'company_email'     =>  $row[2] ? $row[2] : NULL,
                'company_phone'     =>  $row[3] ? $row[3] : NULL,
                'company_address'   =>  $row[4] ? $row[1] : NULL,
                'company_gstn'       =>  $row[5] ? $row[5] : NULL,
            ];
            if (!Company::where(['center_name' => $row[0], 'phone' => $row[1], 'email' => $row[2]])->exists()) {
                # code...
            }
        }
    }

    public function startRow(): int
    {
        return 3;
    }
}
