<?php

namespace Modules\Bar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Modules\Bar\Models\Pin;

class LoginController extends Controller {

    protected $redirectTo = '/';

    public function __construct() {
        if(Auth::check())
            return redirect()->route('bar.home');
    }

    public function index(){
        return view('Bar::auth.login');
    }

    public function login(Request $request){
        $pin = $request->pin;
        $auth = Pin::all()->filter(function($record) use ($pin) {
            if(Crypt::decrypt($record->pin) == $pin) {
                return $record;
            }
            return null;
        })->first();

        if($auth !== null && $auth instanceof Pin){
            $userId = $auth->user->id;
            Auth::loginUsingId($userId);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'msg' => 'Credenziali errate!']);
    }
}
