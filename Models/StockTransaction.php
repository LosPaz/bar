<?php

namespace Modules\Bar\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Michelangelo\Confy\Models\Confy;

class StockTransaction extends Model {

    protected $fillable = ['repository_id', 'stock_id', 'type', 'user_id', 'quantity', 'description'];

    const BAR_TRANSACTION = 'Acquisto da bar';
    const MOVED = 'Spostato ad altro deposito';

    protected static function boot() {
        parent::boot();

        self::creating(function ($model){
            $model->user_id = Auth::id();
        });
    }

    public function stock(){
        return $this->belongsTo(Stock::class);
    }

    public function repository(){
        return $this->belongsTo(Repository::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function amountBetweenTwoDate(Carbon $from, Carbon $to){
        $repo = Confy::getConfig('default_repo', 'settings');
        return StockTransaction::where('type', 1)
            ->whereBetween('stock_transactions.created_at', [$from, $to])
            ->where('repository_id', $repo)
            ->join('stocks', 'stock_transactions.stock_id', '=', 'stocks.id')
            ->join('items', 'stocks.item_id', '=', 'items.id')
            ->select(DB::raw('SUM(quantity * client_price) AS total'))
            ->get();
    }
}
