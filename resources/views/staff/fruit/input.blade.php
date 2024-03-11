@extends('staff.body')

@section('container')
    <div class="mt-5 mb-5">
        <div class="row">
            <div class="col-md-10"><h3>Create New Fruit</h3></div>
        </div>
        @include('alert.validate')
        <form method="post" action="{{route('fruitStore')}}">
            @csrf
            <div class="form-group">
                <label>{{__("Fruit category name")}}</label>
                <!-- <input type="text" name="fruit_category" class="form-control" value="{{$fruit->name ?? ''}}"> -->
                <select type="number" name="fruit_category_id" class="form-control">
                    <option value="">Choose fruit category</option>
                    @foreach ($fruitCategories as $value)
                    <option value="{{ $value->id }}" {{ old('fruit_category_id') == $value->id ? 'selected' : '' }}>
                        {{$value->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>{{__("Fruit Name")}}</label>
                <input type="text" name="fruit_name" class="form-control" value="{{$fruit->name ?? ''}}">
            </div>
            <div class="form-group">
                <label>{{__("Quantity")}}</label>
                <input type="number" step=".01" name="quantity" class="form-control" value="{{$fruit->quantity ?? ''}}">
            </div>
            <div class="form-group">
                <label>{{__("Price")}}</label>
                <input type="money" step=".01" name="price" class="form-control" value="{{$category->price ?? ''}}">
            </div>
            <div class="form-group">
                <label>{{__("Unit")}}</label>
                <!-- <input type="text" name="unit" class="form-control" value="{{$category->unit ?? ''}}"> -->
                <div class="sc-cuWcWY jmonRw my-custom-select">
                    <select type="number" name="unit_id" class="form-control">
                        <option value="">Choose unit</option>
                        @foreach (App\Enums\EUnit::ARRAY_UNIT as $value)
                        <option value="{{ $value }}" {{ old('unit')==$value ? 'selected' : '' }}>{{
                            App\Enums\EUnit::valueToString($value) }}</option>
                        @endforeach
                    </select>
                </div> 
            </div>
            <div>
                <a class="btn btn-cancel btn-square" href="{{route('fruitCategoryList')}}">{{__("Cancel")}}</a>
                <input type="submit" class="btn btn-submit" value="{{__('Submit')}}">
            </div>
        </form>
    </div>
@stop
