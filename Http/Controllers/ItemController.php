<?php

namespace Modules\Bar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Bar\Models\Category;
use Modules\Bar\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::query();
        return view('Bar::manage.items.index', [
            'items' => $items->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Bar::manage.items.create', [
            'categories' => Category::all()
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
        $item = new Item;
        $item->sellable = ($request->has('sellable') && $request->sellable == '1') ? true : false;
        $item->fill($request->except('_token'));
        $item->save();

        flash()->success('Prodotto salvato con successo.');
        return redirect()->route('manager.items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('Bar::manage.items.edit', [
            'item' => $item,
            'categories' => Category::all()
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
        $item = Item::findOrFail($id);
        $item->sellable = ($request->has('sellable') && $request->sellable == '1') ? true : false;
        $item->fill($request->except('_token'));
        $item->save();

        flash()->success('Prodotto modificato con successo.');
        return redirect()->route('manager.items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        if($item->stocks->count() > 0){
            flash()->warning("Impossibile eliminare {$item->name} ha causa di dipendenze.");
            return redirect()->route('manager.categories.index');
        }

        $item->delete();

        flash()->success('Prodotto eliminato con successo.');
        return redirect()->route('manager.categories.index');
    }
}
