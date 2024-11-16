<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CompanyImport implements ToCollection, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // public function model(array $row)
    // {
    //     dd($row);
    //     // return new Company([
    //     //     //
    //     // ]);

    // if (is_numeric($row[0]) && $row[0] > 0) {
    //     $company_data = [
    //         'company_name'      =>  $row[1] ? $row[1] : NULL,
    //         'company_email'     =>  $row[2] ? $row[2] : NULL,
    //         'company_phone'     =>  $row[3] ? $row[3] : NULL,
    //         'company_address'   =>  $row[4] ? $row[1] : NULL,
    //         'company_gstn'       =>  $row[5] ? $row[5] : NULL,
    //     ];
    //     if (!Company::where(['center_name' => $row[0], 'phone' => $row[1], 'email' => $row[2]])->exists()) {

    //         $company = Company::first(['center_name' => $row[0], 'phone' => $row[1], 'email' => $row[2]]);

    //         return new Customer([
    // 'company_id' => $company->id,
    // 'customer_name' => $row[6],
    // 'designation' => $row[7],
    // 'mobile' => $row[8],
    // 'email' => $row[9],
    // 'address' => $row[10],
    //         ]);
    //     }
    // }
    // }


    public function collection(Collection $rows)
    {
        // dd($rows);

        // Validator::make($rows->toArray(), [
        //     '*.0' => 'required',
        // ])->validate();


        $contacts = [];
        $company_id = 0;

        foreach ($rows as $row) {

            if (is_numeric($row[0]) && $row[0] > 0) {
                $company_data = [
                    'company_name'      =>  $row[1],
                    'email'             =>  $row[2] ? $row[2] : NULL,
                    'phone'             =>  $row[3] ? $row[3] : NULL,
                    'address'           =>  $row[4],
                    'gst'               =>  $row[5] ? $row[5] : NULL,
                ];                

                if (Company::where($company_data)->exists()) {
                    $company = Company::where($company_data)->first();
                    $company_id = $company->id;
                }

                // else {
                //     $company = Company::create($company_data);
                //     $company_id = $company->id;
                // }
            }

            if ($row[0] == "#" && $company_id > 0) {
                $customer_data = [
                    'company_id' => $company_id,
                    'customer_name' => $row[6],
                    'designation' => $row[7],
                    'mobile' => $row[8],
                    'email' => $row[9],
                    'address' => $row[10],
                ];

                if (!Customer::where($customer_data)->exists()) {
                    array_push($contacts, $customer_data);
                }
            }
        }

        if (count($contacts) > 0) {
            Customer::insert($contacts);
        }
    }

    public function startRow(): int
    {
        return 3;
    }
}
