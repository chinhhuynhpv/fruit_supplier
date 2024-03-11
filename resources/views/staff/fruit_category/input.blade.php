@extends('staff.body')

@section('container')
    <div class="mt-5 mb-5">
        <div class="row">
            <div class="col-md-10"><h3> @if(!isset($category)) Create @else Update @endif  Fruit Category</h3></div>
        </div>
        @include('alert.validate')
        <form method="post" action="@if(!isset($category)){{route('fruitCategoryStore')}}@else{{route('fruitCategoryUpdate', $category->id)}}@endif">
            @csrf
            <div class="form-group">
                <label>{{__("Fruit category name")}}</label>
                <input type="text" name="name" class="form-control" value="{{$category->name ?? ''}}">
            </div>
            <div>
                <a class="btn btn-cancel btn-square" href="{{route('fruitCategoryList')}}">{{__("Cancel")}}</a>
                <input type="submit" class="btn btn-submit" value="{{__('Submit')}}">
            </div>
        </form>
    </div>
@stop
