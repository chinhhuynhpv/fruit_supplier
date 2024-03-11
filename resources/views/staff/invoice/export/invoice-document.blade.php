@extends('staff.invoice.export.master')

@section('content')
    <div style="max-width: 380px; background: #eedfdf; padding: 15px;">
        <div style="">
            <div class="float-left" style="width:50%;font-size: 14px; text-align:left; float:left">{{__("SR Fruit Supplier ")}}</div>
            <div class="text-right" style="width:50%; text-align:right; float:right; padding-right:20px;margin-bottom:-10px">{{__("Invoice")}}</div>
        </div>
        <hr style="clear: both;margin-top:0px!important">
        <div  style="text-align:right; margin-bottom:8px; font-weight:bold">{{__("Date of issue")}}: {{$issuedDate}}</div>
        <div class="mt-3" style="">
            <div>
                <div><span style="font-weight:bold">{{__("Customer name")}}:</span> <span>{{$invoice->customer_name}}</span></div>
                <div><span style="font-weight:bold">{{__("Customer phone")}}:</span> <span> {{$invoice->phone}} </span></div>
                <div><span style="font-weight:bold">{{__("Customer email")}}:</span> <span> {{$invoice->email}} </span></div>
                <div><span style="font-weight:bold">{{__("Amount")}}:</span> <span> {{$invoice->amount}} $</span></div>
                <div><span style="font-weight:bold">{{__("Bonus (Not comprise in Amount)")}}:</span> <span> {{$invoice->bonus}} $</span></div>
                <div><span style="font-weight:bold">{{__("Customer payment")}}:</span> <span> {{$invoice->bonus + $invoice->amount}} $</span></div>
                <div><span style="font-weight:bold">{{__("Date")}}:</span> <span> {{$invoice->created_at}} </span></div>
                <div><span style="font-weight:bold">{{__("Staff id")}}:</span> <span>{{$invoice->staff_id}}</span></div>
                <div><span style="font-weight:bold">{{__("Staff name")}}:</span> <span>{{$invoice->staff->name}}</span></div>
            </div>
            <div>
                <div><span style="font-weight:bold; margin:15px 0px; text-decoration:underline">{{__("List Fruits")}}</span></div>
                <div>
                    <table class="table-border" >
                        <tbody>
                            <thead>
                                <td style="font-weight:bold ; padding:0px 7px">Fruit Category</td>
                                <td style="font-weight:bold ; padding:0px 7px">Fruit name</td>
                                <td style="font-weight:bold ; padding:0px 7px">Quantity</td>
                                <td style="font-weight:bold; padding:0px 7px">Price/Unit</td>
                                <td style="font-weight:bold; padding:0px 7px">total by fruit</td>
                            </thead>
                            @foreach( $listFruitsByInvoice as $fruit)
                                <tr>
                                    <td style="width: 24%; padding:0px 7px">
                                        {{$fruit->fruit_category->name}}
                                    </td>
                                    <td style="width: 24%; padding:0px 7px">
                                        {{$fruit->fruit_name}}
                                    </td>
                                    <td style="width: 24%; padding:0px 7px">
                                        {{$fruit->pivot->quantity}} {{ App\Enums\EUnit::valueToString($fruit->unit_id) }}
                                    </td>
                                    <td style="width: 24%; padding:0px 7px">
                                        {{$fruit->price}} $/{{ App\Enums\EUnit::valueToString($fruit->unit_id) }}
                                    </td>
                                    <td style="width: 24%; padding:0px 7px">
                                        {{$fruit->price * $fruit->pivot->quantity}} $
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
        <div style="clear: both;"></div>
    </div>
@stop
