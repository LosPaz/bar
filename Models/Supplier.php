<?php

namespace Modules\Bar\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {

    protected $fillable = ['name'];

    public function stocks(){
        return $this->hasMany(Stock::class);
    }

}
