@extends('staff.body')

@section('container')
    <div>
        <div class="row">
            <div class="col-md-9"><h3>list fruits</h3></div>
            <div class="col-md-3 text-right">
                <a class="btn btn-primary" href="{{Route('fruitCreate')}}">{{__("Create New fruit")}}</a>
            </div>
        </div>
        
        @if ($list->count() > 0)
            <table class="table table-borderless list" data-delete-url="{{route('fruitDelete')}}">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{__("Id")}}</th>
                        <th scope="col">{{__("Fruit Name")}}</th>
                        <th scope="col">{{__("Fruit category")}}</th>
                        <th scope="col">{{__("Quantity")}}</th>
                        <th scope="col">{{__("Unit")}}</th>
                        <th scope="col">{{__("Price")}}</th>
                        <th scope="col">{{__("created_at")}}</th>
                        <!--<th scope="col">{{__("Incentive unit price")}}</th>-->
                        <th scope="col">{{__("Action")}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $key => $item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$item->id}}</td>
                            <td>{{$item->fruit_name}}</td>
                            <td>{{$item->fruit_category->name}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{ App\Enums\EUnit::valueToString($item->unit_id) }}</td>
                            <td>{{$item->price}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>
                                <a class="btn" href="">{{__("View")}}</a>
                                <a class="btn btn-delete" href="{{Route('fruitDelete')}}" data-id="{{$item->id}}" data-name="{{$item->fruit_name}}"  data-btn-delete>{{__("Delete")}}</a>
                                <a class="btn btn-update" href="{{Route('fruitEdit', $item->id)}}">{{__("Update")}}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $list->links() }}
        @else
            <div class="mt-3">No Result!</div>
        @endif
    </div>
    @include('modals.modal-delete')
@stop
