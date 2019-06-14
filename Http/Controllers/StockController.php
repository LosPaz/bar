<?php

namespace Modules\Bar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Bar\Models\Item;
use Modules\Bar\Models\Stock;
use Modules\Bar\Models\StockTransaction;
use Modules\Bar\Models\Supplier;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::query();

        return view('Bar::manage.stocks.index', [
            'stocks' => $stocks->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Bar::manage.stocks.create', [
            'items' => Item::all(),
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Stock::where('item_id', $request->item_id)
                ->where('supplier_id', $request->supplier_id)
                ->count() >= 1 ){
            flash()->warning('Esiste già una giacenza per il prodotto e/o fornitore selezionato.');
            return redirect()->route('manager.stocks.index');
        }
        $stock = new Stock;
        $stock->fill($request->except('_token'));
        $stock->save();

        flash()->success('Giacenza aggiunta con successo');
        return redirect()->route('manager.stocks.show', $stock->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stock = Stock::findOrFail($id);
        $transactions = StockTransaction::where('stock_id', $stock->id)
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('Bar::manage.stocks.show', [
            'stock' => $stock,
            'transactions' => $transactions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stock = Stock::findOrFail($id);

        return view('Bar::manage.stocks.edit', [
            'stock' => $stock,
            'items' => Item::all(),
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);
        $stock->fill($request->except('_token'));
        $stock->save();

        flash()->success('Giacenza modificata con successo');
        return redirect()->route('manager.stocks.show', $stock->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        if($stock->transactions->count() > 0){
            flash()->warning("Impossibile eliminare {$stock->item->name} ha causa di dipendenze.");
            return redirect()->route('manager.stocks.index');
        }

        $stock->delete();

        flash()->success('Giacenza eliminata con successo.');
        return redirect()->route('manager.stocks.index');
    }
}
