<?php

namespace Modules\Bar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Bar\Models\Stock;
use Modules\Bar\Models\Workshift;

class ProductController extends Controller {

    public function index(){
        $products = Stock::query();

        $products->whereHas('item', function ($q){
            $q->where('sellable', true);
        });

        return view('Bar::products.index', [
            'products' => $products->get(),
            'estimatedAmount' => Workshift::getLastEstimatedAmount()
        ]);
    }


}
