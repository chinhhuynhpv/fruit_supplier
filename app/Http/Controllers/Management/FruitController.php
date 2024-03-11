<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\FruitRepository;
use App\Repositories\FruitCategoryRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Enums\EError;
use App\Enums\EUnit;
use Illuminate\Validation\Rule;


class FruitController extends Controller
{
    
    private $fruitRepository;
    private $fruitCategoryRepository;

    public function __construct(FruitRepository $fruitRepository, FruitCategoryRepository $fruitCategoryRepository)
    {
        $this->fruitRepository = $fruitRepository;
        $this->fruitCategoryRepository = $fruitCategoryRepository;
    }

    public function index()
    {
        $list = $this->fruitRepository->getlistFruits();
        return view('staff.fruit.list', compact('list'));
    }

    public function create()
    {
        $fruitCategories = $this->fruitCategoryRepository->getlistFruitCategories();
        return view('staff.fruit.input', compact('fruitCategories'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        Validator::make($input, [
            'fruit_name' => ['required', 'string', 'max:255','unique:fruits'],
            'fruit_category_id' => ['required'],
            'quantity' => ['required', 'numeric'],
            'unit_id' => ['required', 'numeric'],
            'price' => ['required', 'numeric']
        ])->validate();

        $input['slug'] = Str::slug($request->input('fruit_name'));
         
        try {
            
            $fruit = $this->fruitRepository->create($input);
           
            if (!$fruit) {
                return \Redirect::back()->withErrors(['error' => 'Save Fail!']);
            }
            $notification = array(
                'message' => 'Save success.',
                'alert-type' => 'success'
            );
            return redirect()->route('fruitList')->with($notification);
        } catch (\Exception $e) {
            logger($e->getMessage() . ' at ' . $e->getLine() .  ' in ' . $e->getFile());
            $notification = array(
                'message' => 'Save Fail!',
                'alert-type' => 'error'
            );
            return \redirect()->back()->with($notification);
        }

    }

    public function createSlug (Request $request) {
        if (!empty($request->value)) {
            $value = $request->value;
            $url = Str::slug($value);
            $category = $this->fruitRepository->getCategoryBySlug($url);
            if (empty($category)) {
                return \Response::json(['success' => EError::SUCCESS, 'datas' => $url]);
            } else {
                return \Response::json(['success' => EError::FAIL, 'datas' => 'Tên danh mục đã tồn tại!']);
            }
        }
    }

    public function edit ($fruitId) {
        if (!empty($fruitId)) {
            $fruit = $this->fruitRepository->find($fruitId);
            $fruitCategories = $this->fruitCategoryRepository->getlistFruitCategories();
            return view('staff.fruit.edit', compact('fruit', 'fruitCategories'));
        }
    }

    public function update (Request $request, $fruitId) {
        
        $inputs = $request->all();
        
        Validator::make($inputs, [
            'fruit_name' => ['required', 'string', 'max:255',Rule::unique('fruits')->ignore($fruitId),
            'fruit_category_id' => ['required'],
            'quantity' => ['required', 'numeric'],
            'unit_id' => ['required', 'numeric'],
            'price' => ['required', 'numeric']
            ]
        ])->validate();
            
        try {
            $attributes = [
                'name' => $inputs['name'],
                'fruit_category_id' => $inputs['fruit_category_id'],
                'quantity' => $inputs['quantity'],
                'unit_id' => $inputs['unit_id'],
                'price' => $inputs['price'],
            ];
            $fruit = $this->fruitRepository->update($fruitId, $inputs);
            if (!$fruit) {
                return \Redirect::back()->withErrors(['error' => 'Update fruit Fail!']);
            }
            $notification = array(
                'message' => 'update fruit success!',
                'alert-type' => 'success'
            );
            return redirect()->route('fruitList')->with($notification);
        } catch (\Exception $e) {
            logger($e->getMessage() . ' at ' . $e->getLine() .  ' in ' . $e->getFile());
            $notification = array(
                'message' => 'Update fruit fail!',
                'alert-type' => 'error'
            );
            return \redirect()->back()->with($notification);
        }
    }

    public function delete (Request $request) {
        
        try {
            $input = $request->all();
            if (!empty($input['id'])) {
                $result = $this->fruitRepository->delete($input['id']);
                if ($result) {
                    $notification = array(
                        'message' => 'Deleted fruit success!',
                        'alert-type' => 'success'
                    );
                } else {
                    $notification = array(
                        'message' => 'Deleted fruit fail!',
                        'alert-type' => 'error'
                    );
                }
                return redirect()->route('fruitList')->with($notification);
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . ' at ' . $e->getLine() .  ' in ' . $e->getFile());
            return \Response::json(['success' => EError::FAIL, 'message' => 'Error! Delete fail!']);
        }
    }
}
