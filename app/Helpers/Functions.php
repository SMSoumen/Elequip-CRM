
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



?>