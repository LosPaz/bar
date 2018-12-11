<?php

namespace Modules\Bar\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\Bar\Models\StockTransaction;
use Modules\Bar\Models\Workshift;

class WorkshiftController extends Controller {

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function open(){
        if(Workshift::mustBeClosed()){
            return response()->json([
                'success' => false,
                'msg' => 'Per aprire un nuovo turno è necessario chiudere il precedente'
            ]);
        }

        $w = new Workshift;
        $w->type = 0;
        $w->save();
        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function close(){
        if(Workshift::mustBeOpened()){
            return response()->json([
                'success' => false,
                'msg' => 'Per chiudere un nuovo turno è necessario aprirne uno.'
            ]);
        }

        $start = (Workshift::latest()->where('type', 0)
            ->first())
            ->created_at;
        $end = Carbon::now();

        $w = new Workshift;
        $w->type = 1;
        $w->estimate_amount = (StockTransaction::amountBetweenTwoDate($start, $end))[0]['total'];
        $w->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function index(){
        $w = Workshift::query();
        $w->orderBy('id', 'DESC');
        return view('Bar::manage.workshifts.index', [
            'workshifts' => $w->paginate(10)
        ]);
    }
}
