<?php

namespace Modules\Bar\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model {

    protected $fillable = ['item_id', 'supplier_id', 'price', 'client_price'];

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function transactions(){
        return $this->hasMany(StockTransaction::class);
    }

    public function getTotal(){
        $ongoing = $this->transactions->where('type', 0)->select('SUM(quantity)');
        $outgoing = $this->transactions->where('type', 1)->select('SUM(quantity)');
        return $ongoing - $outgoing;
    }

    public function getRepositoryTotal(){
        $result = [];
        foreach ($this->transactions->groupBy('repository_id') as $transaction) {
            $total = 0;
            foreach ($transaction as $item) {
                $total += ($item->type == 0) ? $item->quantity : (-$item->quantity);
            }
            $result[] = ['name' => $transaction[0]->repository->name, 'total' => $total];
        }

       return $result;
    }

    public function availability($repoid){
        $ongoing = StockTransaction::where('stock_id', $this->id)
            ->where('type', 0)
            ->where('repository_id', $repoid)
            ->sum('quantity');

        $outgoing = StockTransaction::where('stock_id', $this->id)
            ->where('type', 1)
            ->where('repository_id', $repoid)
            ->sum('quantity');

        return ($ongoing - $outgoing);
    }
}
