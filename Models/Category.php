<?php

namespace Modules\Bar\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'bar_categories';

    protected $fillable = ['name', 'bar_category_id'];

    public function subcategory(){
        return $this->belongsTo(Category::class, 'bar_category_id', 'id');
    }

    public function items(){
        return $this->hasMany(Item::class, 'id', 'bar_category_id');
    }

}
