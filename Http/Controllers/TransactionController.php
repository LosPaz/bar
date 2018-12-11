<?php

namespace Modules\Bar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Michelangelo\Confy\Models\Confy;
use Modules\Bar\Models\Stock;
use Modules\Bar\Models\StockTransaction;
use Modules\Bar\Models\Transaction;
use Modules\Bar\Models\Workshift;

class TransactionController extends Controller {

    public function bar(Request $request){
        $repo = Confy::getConfig('default_repo', 'settings');
        //Check default repo
        if($repo == null){
            return response()->json([
                'success' => false,
                'msg' => 'Impossibile continuare poichè nessun deposito di default è stato impostato'
            ]);
        }
        //Check if workshift is opened
        if(Workshift::mustBeOpened()){
            return response()->json([
                'success' => false,
                'msg' => 'È necessario aprire il turno per continuare.'
            ]);
        }

        $items = $request->except('_token');
        foreach ($items as $item){
            $stock = Stock::find($item['id']);
            $availability = $stock->availability($repo);
            //Check
            if($item['qty'] > $availability) {
                return response()->json([
                    'success' => false,
                    'msg' => "La quantità selezionata per {$stock->item->name} supera la disponibilità"
                ]);
            }
            //Add transaction
            $t = StockTransaction::create([
                'stock_id' => $stock->id,
                'repository_id' => $repo,
                'type' => 1,
                'quantity' => $item['qty'],
                'description' => StockTransaction::BAR_TRANSACTION
            ]);
        }
        flash()->success('Transazione aggiunta con successo.')->important();
        return response()->json(['success' => true]);
    }

}
