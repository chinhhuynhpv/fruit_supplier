@extends('staff.body')

@section('container')
    <div>
        <div class="row">
            <div class="col-md-9"><h3>list fruit category</h3></div>
            <div class="col-md-3 text-right">
                <a class="btn btn-primary" href="{{Route('fruitCategoryCreate')}}">{{__("Create new fruit category")}}</a>
            </div>
        </div>
        
        @if ($list->count() > 0)
            <table class="table table-borderless list" data-delete-url="{{route('fruitCategoryDelete')}}">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{__("Id")}}</th>
                        <th scope="col">{{__("Name")}}</th>
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
                            <td>{{$item->name}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>
                                <a class="btn" href="">{{__("View")}}</a>
                                <a class="btn btn-delete" href="{{Route('fruitCategoryDelete')}}" data-id="{{$item->id}}" data-name="{{$item->name}}"  data-btn-delete>{{__("Delete")}}</a>
                                <a class="btn btn-update" href="{{Route('fruitCategoryEdit', $item->id)}}">{{__("Update")}}</a>
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
