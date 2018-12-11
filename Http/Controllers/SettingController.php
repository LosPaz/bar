<?php

namespace Modules\Bar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Michelangelo\Confy\Models\Confy;
use Modules\Bar\Models\Repository;

class SettingController extends Controller {

    public function index(){
        return view('Bar::manage.settings.index', [
            'repositories' => Repository::all()
        ]);
    }

    public function update(Request $request){
        foreach ($request->except('_token') as $key => $item) {
            Confy::put($key, $item, 'settings');
        }
        flash()->success('Impostazioni aggiornate con successo');
        return redirect()->route('manager.settings.index');
    }
}
