<?php

namespace Modules\Bar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Bar\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = Supplier::query();

        if($request->has('q')){
            $models->where('name', 'like', "%{$request->q}%");
        }

        return view('Bar::manage.suppliers.index', [
            'suppliers' => $models->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Bar::manage.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Supplier;
        $model->fill($request->except('_token'));
        $model->save();

        flash()->success('Fornitore creato con successo.');
        return redirect()->route('manager.suppliers.index');
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
        $model = Supplier::findOrFail($id);

        return view('Bar::manage.suppliers.edit', [
            'supplier' => $model,
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
        $model = Supplier::findOrFail($id);
        $model->fill($request->except('_token'));
        $model->save();

        flash()->success('Fornitore modificato con successo.');
        return redirect()->route('manager.suppliers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Supplier::findOrFail($id);

        if($model->stocks->count() > 0){
            flash()->warning("Impossibile eliminare {$model->name} ha causa di dipendenze.");
            return redirect()->route('manager.suppliers.index');
        }

        $model->delete();

        flash()->success('Fornitore eliminato con successo.');
        return redirect()->route('manager.suppliers.index');
    }
}
