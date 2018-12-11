<?php

namespace Modules\Bar\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Pin extends Model {

    protected $fillable = ['user_id', 'pin'];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
