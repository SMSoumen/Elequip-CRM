
<?php

use Illuminate\Support\Facades\Config;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;

if (!function_exists('asset_path')) {
    function asset_path($path = null)
    {
        $prefix = Config::get('app_url.asset_base_url');
        return $prefix . $path;
    }
}

// if (!function_exists('random_fileName')) {
//     function random_fileName($prefix = "", $extension, $length = 0)
//     {
//         $output = $prefix . '-' . time() . '-' . mt_rand(10000, 99999) . '.' . $extension;
//         return $output;
//     }
// }

// if (!function_exists('upload_file')) {
//     function upload_file($requestImg, $slug, $staticPath = "upload/")
//     {
//         $image = $requestImg;
//         $new_image = random_fileName($slug, 'webp');

//         // $path = $staticPath;
//         $imagePath = $staticPath . $new_image;

//         // $pathReal = Config::get('app_url.asset_base_path') . $path;
//         $imagePathReal = Config::get('app_url.asset_base_path') . $imagePath;



//         if (!File::exists($staticPath)) {
//             File::makeDirectory($staticPath, 0755, true, true);
//         }
//         // dd($new_image);
//         $manager = new ImageManager(new Driver());

//         $iim = $manager->read($image)->scale(300)->toWebp()->save($imagePathReal);

//         // $iim = $manager::make($image)->resize(300, null, function ($constraint) {
//         //     $constraint->aspectRatio();
//         // })->save($imagePathReal);

//         return $imagePath;
//     }
// }



if (!function_exists('delete_file')) {
    function delete_file($filePath)
    {
        $pathReal = Config::get('app_url.asset_base_path') . $filePath;

        if (File::exists($pathReal)) {
            unlink($pathReal);
        }

        return true;
    }
}

if(!function_exists('numberTowords')){
    function numberTowords(float $amount){
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
       // Check if there is any number after decimal
       $amt_hundred = null;
       $count_length = strlen($num);
       $x = 0;
       $string = array();
       $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
         3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
         7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
         10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
         13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
         16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
         19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
         40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
         70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        while( $x < $count_length ) {
    		$get_divider = ($x == 2) ? 10 : 100;
    		$amount = floor($num % $get_divider);
    		$num = floor($num / $get_divider);
    		$x += $get_divider == 10 ? 1 : 2;
    		if ($amount) {
    			$add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
    			$amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
    			$string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
    			'.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
    			'.$here_digits[$counter].$add_plural.' '.$amt_hundred;
    		}else $string[] = null;
    		
       }
       $implode_to_Rupees = implode('', array_reverse($string));
       $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
       " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
       return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
    }
}



?>