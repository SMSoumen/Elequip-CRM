<?php

namespace App\Imports;

use App\Models\ServiceCenter;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ServiceCentersImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if (!ServiceCenter::where(['center_name' => $row[0], 'phone' => $row[1], 'email' => $row[2]])->exists()) {
            return new ServiceCenter([
                'center_name' => ($row[0] !== "") ? $row[0] : "",
                'phone' => $row[1],
                'email' => $row[2],
                'contact_person' => $row[3],
                'address' => $row[4],
                'state' => ($row[5] !== "") ? $row[5] : "",
                'city' => ($row[6] !== "") ? $row[6] : "",
                'pincode' => ($row[7] !== "") ? $row[7] : "",
            ]);
        }

        return new ServiceCenter([
            //
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
