<?php

namespace Modules\Bar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Bar\Models\Repository;
use Modules\Bar\Models\Stock;
use Modules\Bar\Models\StockTransaction;

class StockTransactionController extends Controller
{

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id){
        $stock = Stock::findOrFail($id);

        return view('Bar::manage.stocks.transactions.create', [
            'stock' => $stock,
            'repositories' => Repository::all()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $id){
        $stock = Stock::findOrFail($id);

        $transaction = new StockTransaction;

        $transaction->user_id = Auth::id();
        $transaction->stock_id = $stock->id;

        $r = Repository::getOrCreate($request->repository_id);
        $transaction->repository_id = ($r != null) ? $r->id : 1;
        $transaction->type = ($request->type == '0') ? 0 : 1;
        $transaction->quantity = $request->quantity;
        $transaction->description = $request->description;
        $transaction->save();

        flash()->success('Transazione aggiunta con successo!');
        return redirect()->route('manager.stocks.show', $stock->id);
    }

    public function moveIndex($id){
        $stock = Stock::findOrFail($id);
        $repositories = Repository::all();

        return view('Bar::manage.stocks.transactions.move', [
            'stock' => $stock,
            'repositories' => $repositories
        ]);
    }

    public function move(Request $request, $id){
        $stock = Stock::findOrFail($id);
        $old = Repository::findOrFail($request->old_repo);
        $new = Repository::getOrCreate($request->new_repo);
        $quantity = $request->quantity;
        //Check if the repos are the same
        if($new == null || $old->id === $new->id){
            flash()->warning('Non puoi spostare merce all\'interno dello stesso deposito.');
            return redirect()->route('manager.stocks.transactions.move', $stock->id);
        }
        //Check if quantity is available from old repo
        if( $quantity > ($stock->availability($old->id)) ){
            flash()->warning('La quantità inserità è maggiore della disponibiltà nel deposito.');
            return redirect()->route('manager.stocks.transactions.move', $stock->id);
        }
        
        //Remove quantity from old repo
        StockTransaction::create([
            'stock_id' => $stock->id,
            'repository_id' => $old->id,
            'type' => 1,
            'quantity' => $quantity,
            'description' => StockTransaction::MOVED
        ]);
        //Add quantity to new repo
        StockTransaction::create([
            'stock_id' => $stock->id,
            'repository_id' => $new->id,
            'type' => 0,
            'quantity' => $quantity,
            'description' => StockTransaction::MOVED
        ]);

        flash()->success('Merce spostata con successo!');
        return redirect()->route('manager.stocks.index', $stock->id);
    }
}
