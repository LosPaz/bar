<?php

namespace Modules\Bar\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Workshift extends Model {

    protected static function boot() {
        parent::boot();
        self::creating(function ($model){
            $model->user_id = Auth::id();
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function mustBeOpened(){
        $lastStatus = Workshift::latest()->first();
        return ( $lastStatus == null OR $lastStatus->type == 1);
    }

    public static function mustBeClosed(){
        $lastStatus = Workshift::latest()->first();
        return (!self::mustBeOpened() && $lastStatus->type == 0);
    }

    public static function getLastEstimatedAmount(){
        return Workshift::latest()
            ->where('type', 1)
            ->select('estimate_amount', 'created_at')
            ->first();
    }
}
