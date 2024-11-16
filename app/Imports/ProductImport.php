<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\MeasuringUnit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        if(!empty($row['category']) && !empty($row['sub_category']) && !empty($row['brand']) && !empty($row['product_name']) && !empty($row['product_code']) && !empty($row['price']) && !empty($row['unit'])
            && !empty($row['technical_spec']) && !empty($row['marketing_information'])){

            $check_category    = ProductCategory::where('product_category_name',$row['category'])->first();
            if(!empty($check_category)){
                $check_subcategory = ProductSubCategory::where('product_subcat_name',$row['sub_category'])->where('product_category_id',$check_category->id)->first();
            }

            $check_brand       = Brand::where('brand_name',$row['brand'])->first();
            $check_unit        = MeasuringUnit::where('unit_type',$row['unit'])->first();

            if(!empty($check_brand) && !empty($check_category) && !empty($check_subcategory) && !empty($check_unit)){
                $data = array(
                    'product_category_id' => $check_category->id,
                    'product_sub_category_id' => $check_subcategory->id,
                    'product_name' => $row['product_name'],
                    'product_price' => $row['price'],
                    'measuring_unit_id' => $check_unit->id,
                    'brand_id' => $check_brand->id,
                    'product_tech_spec' => $row['technical_spec'],
                    'product_marketing_spec' =>$row['marketing_information'],
                );

                $check_product_code = Product::where('product_code',$row['product_code'])->exists();
                unset($check_category,$check_subcategory,$check_brand,$check_unit);
                if($check_product_code === false){
                    $data['product_code'] = $row['product_code'];
                    Product::create($data);
                }
                else{
                    Product::where('product_code',$row['product_code'])->update($data);
                }
            }

        }
    }
}
