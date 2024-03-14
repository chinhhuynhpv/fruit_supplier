<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'invoice';

    protected $fillable = ['customer_name', 'phone', 'email','staff_id', 'amount', 'bonus'];

    public function fruits()
    {
        return $this->belongsToMany(Fruit::class, 'invoice_fruit')->withPivot('quantity');;
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    // Listen for the created event
    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($invoice) {

            $invoice->load('fruits');

            // Update product quantities when an invoice is created
           foreach ($invoice->fruits as $fruit) {
            dd($fruit);
                $fruit->decrement('quantity', $fruit->pivot->quantity);
            }
        });
    }
}
