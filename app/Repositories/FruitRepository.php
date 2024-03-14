<?php

namespace App\Repositories;

use App\Helpers\AppData as HelpersAppData;
use App\Models\Fruit;
use Illuminate\Support\Str;

class FruitRepository extends BaseRepository
{
    public function getModel()
    {
        return Fruit::class;
    }

    public function getInputs($request)
    {
        $inputs = $request->all();
        $attributes = [
            'unit_id' => $inputs['unit_id'],
            'fruit_category_id' => $inputs['fruit_category_id'],
            'fruit_name' => $inputs['fruit_name'],
            'quantity' => $inputs['quantity'],
            'price' => $inputs['price']
        ];

        return $attributes;
    }

    public function getlistFruits() {
        $result = $this->model;
        
        return $result->with('fruit_category')
        ->where('quantity', '>', 0)
        ->whereHas('fruit_category', function ($query) {
            // Optionally, add additional constraints for the fruit_category relationship
        })
        ->orderBy('created_at', 'DESC')
        ->paginate(10);
    }

    public function updateWithConditions($conditions, $data)
    {
        return $this->model->where($conditions)->update($data); 
    }

}