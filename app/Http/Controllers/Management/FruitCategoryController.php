<?php
namespace App\Http\Controllers\Management;

use App\Repositories\FruitCategoryRepository;
use App\Http\Requests\FruitCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Enums\EError;


class FruitCategoryController 
{
    private $fruitCategoryRepository;

    public function __construct(FruitCategoryRepository $fruitCategoryRepository)
    {
        $this->fruitCategoryRepository = $fruitCategoryRepository;
    }

    public function index()
    {
        $list = $this->fruitCategoryRepository->getlistFruitCategories();
        return view('staff.fruit_category.list', compact('list'));
    }

    public function create()
    {
        return view('staff.fruit_category.input');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255','unique:fruit_category']
        ])->validate();

        $input['slug'] = Str::slug($request->input('name'));
         
        try {
            
            $fruitCategory = $this->fruitCategoryRepository->create($input);
           
            if (!$fruitCategory) {
                return \Redirect::back()->withErrors(['error' => 'Save Fail!']);
            }
            $notification = array(
                'message' => 'Save success.',
                'alert-type' => 'success'
            );
            return redirect()->route('fruitCategoryList')->with($notification);
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
            $category = $this->fruitCategoryRepository->getCategoryBySlug($url);
            if (empty($category)) {
                return \Response::json(['success' => EError::SUCCESS, 'datas' => $url]);
            } else {
                return \Response::json(['success' => EError::FAIL, 'datas' => 'Tên danh mục đã tồn tại!']);
            }
        }
    }

    public function edit ($categoryId) {
        if (!empty($categoryId)) {
            $category = $this->fruitCategoryRepository->find($categoryId);
            return view('staff.fruit_category.input', compact('category'));
        }
    }

    public function update (Request $request, $categoryId) {
        $inputs = $request->all();
        Validator::make($inputs, [
            'name' => ['required', 'string', 'max:255','unique:fruit_category']
        ])->validate();

        try {
            $attributes = [
                'name' => $inputs['name'],
                'slug' => Str::slug($inputs['name'])
            ];
            $category = $this->fruitCategoryRepository->update($categoryId, $attributes);
            if (!$category) {
                return \Redirect::back()->withErrors(['error' => 'Update fruit category Fail!']);
            }
            $notification = array(
                'message' => 'update fruit category success!',
                'alert-type' => 'success'
            );
            return redirect()->route('categories.fengshui.index')->with($notification);
        } catch (\Exception $e) {
            logger($e->getMessage() . ' at ' . $e->getLine() .  ' in ' . $e->getFile());
            $notification = array(
                'message' => 'Cập nhật danh mục thất bại',
                'alert-type' => 'error'
            );
            return \redirect()->back()->with($notification);
        }
    }

    public function delete (Request $request) {
        
        try {
            $input = $request->all();
            if (!empty($input['id'])) {
                $result = $this->fruitCategoryRepository->delete($input['id']);
                if ($result) {
                    return \Response::json(['success' => EError::SUCCESS, 'message' => 'Deleted successfull']);
                } else {
                    return \Response::json(['success' => EError::FAIL, 'message' => 'Error! Delete fail!']);
                }
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . ' at ' . $e->getLine() .  ' in ' . $e->getFile());
            return \Response::json(['success' => EError::FAIL, 'message' => 'Error! Delete fail!']);
        }
    }

}
