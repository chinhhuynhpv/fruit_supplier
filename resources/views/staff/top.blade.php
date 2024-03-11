@extends('staff.body')

@section('container')
    <div class="d-flex flex-column align-items-center mt-5">
        <div class="mt-3">
            <a href="{{Route('fruitCategoryList')}}" class="btn btn-primary">{{__("fruit category list")}}</a>
        </div>
        <div class="mt-3">
            <a href="{{Route('fruitList')}}" class="btn btn-primary">{{__("fruit list")}}</a>
        </div>
        <div class="mt-3">
            <a href="{{Route('invoiceList')}}" class="btn btn-primary">{{__("invoice list")}}</a>
        </div>
    </div>
@stop
