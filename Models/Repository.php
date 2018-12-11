<?php

namespace Modules\Bar\Models;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model {

    protected $fillable = ['name'];

    public function transactions(){
        return $this->hasMany(StockTransaction::class);
    }

    public static function getOrCreate($id){
        if(is_numeric($id)){
            return Repository::find($id);
        } else {
            return Repository::create(['name' => $id]);
        }
    }
}
