<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\SubCategory;
// use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Faq;
use App\Models\PageVisit;
use Illuminate\Support\Facades\Log;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        return view('front.theme1.home');
    }


    public function robotsText()
    {
        $lines = [
            "User-agent: *",
            "Disallow: /"
        ];

        $content = implode("\n", $lines);

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }
}
