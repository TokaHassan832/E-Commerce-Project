<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $guarded=[];

    public static function findByCode($code){
        return self::where('code',$code)->first();
    }

    public function discount($total){
        if ($this->type == 'fixed'){
            return $this->value;
        }
        elseif ($this->type == 'percentage'){
            return ($this->offer->offer_percentage / 100) * $total;
        }
        else
            return 0;
    }

    public function offer(){
        return $this->belongsTo(Offer::class);
    }
}
