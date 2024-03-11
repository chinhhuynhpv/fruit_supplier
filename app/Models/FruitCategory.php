<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FruitCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'fruit_category';

    protected $fillable = ['name', 'slug'];

    function news()
    {
        return $this->hasMany(Fruit::class,'fruit_category_id', 'id');
    }
}
