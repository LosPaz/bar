<?php

namespace Modules\Bar\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Pin extends Model {

    protected $fillable = ['user_id', 'pin'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function generate(){
        $num_str = sprintf("%06d", mt_rand(1, 999999));
        return [
            'encrypted' => Crypt::encrypt($num_str),
            'pin' => $num_str
        ];
    }

}
