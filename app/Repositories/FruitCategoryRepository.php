<?php

namespace App\Repositories;

use App\Helpers\AppData as HelpersAppData;
use App\Models\FruitCategory;
use Illuminate\Support\Str;

class FruitCategoryRepository extends BaseRepository
{
    public function getModel()
    {
        return FruitCategory::class;
    }

    public function getInputs($request)
    {
        $inputs = $request->all();
        $attributes = [
            'name' => $inputs['name']
        ];

        return $attributes;
    }

    public function getlistFruitCategories() {
        $result = $this->model;
        
        return $result->orderBy('created_at','DESC')->paginate(10);
    }

    //get list category with condition
    public function getlistCategory($info = []) {

        $result = $this->model->orderBy('created_at','DESC')->get();
        
        return $result;
    }

    public function updateWithConditions($conditions, $data)
    {
        return $this->model->where($conditions)->update($data); 
    }
}