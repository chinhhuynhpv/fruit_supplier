<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fruit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'fruits';

    protected $fillable = ['unit_id', 'fruit_category_id', 'fruit_name','quantity', 'price'];

    public function fruit_category () {
        return $this->belongsTo(FruitCategory::class, 'fruit_category_id', 'id');
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_fruit');
    }

}
