<?php

namespace Modules\Bar\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    protected $fillable = ['name', 'format', 'bar_category_id', 'sellable'];

    public function category(){
        return $this->belongsTo(Category::class, 'bar_category_id', 'id');
    }

    public function stocks(){
        return $this->hasMany(Stock::class);
    }

}
