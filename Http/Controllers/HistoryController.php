<?php

namespace Modules\Bar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Bar\Models\StockTransaction;

class HistoryController extends Controller {

    public function index(Request $request){
        $transactions = StockTransaction::orderBy('created_at', 'DESC')
            ->with('stock.item')
            ->paginate(10);
        return view('Bar::history.index', [
            'transactions' => $transactions
        ]);
    }

}
