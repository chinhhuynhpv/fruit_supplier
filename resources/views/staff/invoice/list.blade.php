@extends('staff.body')

@section('container')
    <div>
        <div class="row">
            <div class="col-md-9"><h3>list invoices</h3></div>
            <div class="col-md-3 text-right">
                <a class="btn btn-primary" href="{{Route('invoiceCreate')}}">{{__("Create New Invoice")}}</a>
            </div>
        </div>
    
        @if ($list->count() > 0)
            <table class="table table-borderless list" data-delete-url="{{route('invoiceDelete')}}">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{__("Id")}}</th>
                        <th scope="col">{{__("Customer name")}}</th>
                        <th scope="col">{{__("Amount")}}</th>
                        <th scope="col">{{__("Staff id")}}</th>
                        <th scope="col">{{__("Staff name")}}</th>
                        <th scope="col">{{__("Created at")}}</th>
                        <!--<th scope="col">{{__("Incentive unit price")}}</th>-->
                        <th scope="col">{{__("Action")}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $key => $item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$item->id}}</td>
                            <td>{{$item->customer_name}}</td>
                            <td>{{$item->amount }}</td>
                            <td>{{$item->staff_id}}</td>
                            <td>{{$item->staff->name}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>
                                <a class="btn" href="{{Route('invoiceDetail', $item->id)}}">{{__("View")}}</a>
                                <a class="btn btn-delete" href="{{Route('invoiceDelete')}}" data-id="{{$item->id}}" data-name="{{$item->id}}"  data-btn-delete>{{__("Delete")}}</a>
                               
                                <a class="btn btn-export" href="{{Route('invoiceExport', $item->id)}}">{{__("Export")}}</a>
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
