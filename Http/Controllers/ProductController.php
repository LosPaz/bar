<?php

namespace Modules\Bar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Bar\Models\Category;
use Modules\Bar\Models\Stock;
use Modules\Bar\Models\Workshift;

class ProductController extends Controller {

    public function index(Request $request){
        $products = Stock::query();

        $products->whereHas('item', function ($q) use ($request) {
            $q->where('sellable', true);
            //Check category
            if($request->has('cat') && $request->cat != ''){
                $q->where('bar_category_id', $request->cat);
            }
        });
        $products->join('items', 'stocks.item_id', '=', 'items.id');
        $products->orderBy('name');
        $products->select('stocks.*');
        return view('Bar::products.index', [
            'products' => $products->get(),
            'estimatedAmount' => Workshift::getLastEstimatedAmount(),
            'categories' => self::getCategories()
        ]);
    }

    public static function getCategories(){
        return Category::all();
    }


}
