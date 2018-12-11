<?php

namespace Modules\Bar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Bar\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = Category::query();

        if($request->has('q')){
            $models->where('name', 'like', "%{$request->q}%")
                ->orWhereHas('subcategory', function ($q) use ($request){
                    $q->where('name', 'like', "%{$request->q}%");
                });
        }

        return view('Bar::manage.categories.index', [
            'categories' => $models->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Bar::manage.categories.create', [
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
        $model = new Category;
        $model->fill($request->except('_token'));
        $model->save();

        flash()->success('Categoria creata con successo.');
        return redirect()->route('manager.categories.index');
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
        $model = Category::findOrFail($id);

        return view('Bar::manage.categories.edit', [
            'category' => $model,
            'categories' => Category::where('id', '<>', $id)->get()
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
        $model = Category::findOrFail($id);
        $model->fill($request->except('_token'));
        $model->save();

        flash()->success('Categoria modificata con successo.');
        return redirect()->route('manager.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Category::findOrFail($id);

        if($model->items->count() > 0){
            flash()->warning("Impossibile eliminare {$model->name} ha causa di dipendenze.");
            return redirect()->route('manager.categories.index');
        }

        $model->delete();

        flash()->success('Categoria eliminata con successo.');
        return redirect()->route('manager.categories.index');
    }
}
