@extends('staff.body')

@section('container')
    <div class="mt-5 mb-5">
        <div class="row">
            <div class="col-md-10"><h3>Registration invoice</h3></div>
        </div>
        @include('alert.validate')
        <form id="buyForm" method="post" action="@if(!isset($invoice)){{route('invoiceStore')}}@else{{route('invoiceUpdate', $invoice->id)}}@endif">
            @csrf
            <div class="form-group">
                <label>{{__("Customer name")}}</label>
                <input type="text" name="customer_name" class="form-control" value="{{$invoice->customer_name ?? ''}}">
            </div>
            <div class="form-group">
                <label>{{__("Customer phone")}}</label>
                <input type="text" name="phone" class="form-control" value="{{$invoice->phone ?? ''}}">
            </div>
            <div class="form-group">
                <label>{{__("Customer email")}}</label>
                <input type="email" name="email" class="form-control" value="{{$invoice->email ?? ''}}">
            </div>
            <div class="form-group">
                <label>{{__("Bonus")}}</label>
                <select name="bonus" >
                    <option value="0">--choose Bonus--</option>
                    <option value="1">1$</option>
                    <option value="2">2$</option>
                    <option value="3">3$</option>
                    <option value="4">4$</option>
                </select>
            </div>

            <div class="list-product-for-buy">
                <label class="title-choose">{{__("Choose Fruit for buying")}}</label>
                <div class="box-choose-fruit">
                    <div class="choose-fruit">
                        <select name="choose_fruit" id="choose-fruit">
                            <option value="">--choose fruit--</option>
                            @foreach ($fruits as $fruit)
                                <option value="{{$fruit->id}}" data-name = "{{ $fruit->fruit_name }}" data-price = "{{$fruit->price}}"> {{ $fruit->fruit_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="choose-quantity">
                        <input id="choose_quantity" class="input_quantity form-control" type="number" name="choose_quantity" placeholder="input quantity" data-fruit="{{$fruit->id}}" data-price="{{$fruit->price}}">
                    </div>

                    <div class="btn-add-item">
                        <a href="javascript:void(0)" id="btn-add-item">Add to buy</a>
                    </div>

                    <div class="btn-add-item">
                        <a href="javascript:void(0)" id="btn-reset-choose-fruit">Reset chose fruit</a>
                    </div>
                </div>
            </div>

            
            <label class="title-choose">{{__("List Fruits for buying")}}</label>

            <table class="table" id="chosenItems">
                <thead>
                        <th scope="col">{{__("Fruit Name")}}</th>
                        <th scope="col">{{__("Quantity")}}</th>
                        <th scope="col">{{__("Price")}}</th>
                        <th scope="col">{{__("Action")}}</th>
                </thead>
                <tbody id="chosenItemsList">
                </tbody>
            </table>
            
            
            <div class="total-bill">
                    <label class="title-choose">{{__("Total bill: ")}}</label>
                    <input type="text" name="total_bill" id="totalBill" value="">
                </div>
             <div>
                <a class="btn btn-cancel btn-square" href="{{route('invoiceList')}}">{{__("Cancel")}}</a>
                <input type="button" id="submitButton" class="btn btn-submit" value="{{__('Submit')}}">
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            let totalBill = 0
            localStorage.clear();
            updateChosenItems();
            updateTotalBillUI();

            $('#btn-reset-choose-fruit').click(function(event) {
                localStorage.clear();

                // reset chose items
                updateChosenItems();

                // reset total bill
                updateTotalBillUI();
            });
            

            $('#btn-add-item').click(function(event) {
                // Prevent the default action of the anchor link
                var selectedOption = $('#choose-fruit').find(':selected');

                // Get the price from the data-price attribute
                var fruitId = $('#choose-fruit').val();
                var fruitPrice = parseFloat(selectedOption.data('price'));
                var fruitName = selectedOption.data('name');
                var fruitQuantity = parseFloat($('#choose_quantity').val());

                // Create object with the data
                var fruitData = {
                    id: fruitId,
                    name: fruitName,
                    price: fruitPrice,
                    quantity: fruitQuantity
                };
                
                // Get existing cart items from local storage or create empty array
                var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
                
                // Check if the fruit is already in the cart
                var existingItemIndex = cartItems.findIndex(function(item) {
                    return item.id == fruitId;
                });
                
                if (existingItemIndex !== -1) {
                    // If the fruit is already in the cart, update its quantity
                    cartItems[existingItemIndex].quantity += parseFloat(fruitQuantity) ;
                } else {
                    // If the fruit is not in the cart, add it to the cart with quantity 1
                    cartItems.push({
                        id: fruitId,
                        name: fruitName,
                        price: fruitPrice,
                        quantity: fruitQuantity
                    });
                }
                
                // Save the updated cart items to local storage
                localStorage.setItem('cartItems', JSON.stringify(cartItems));
                updateChosenItems()

                // recalculate totalbuild
                updateTotalBillUI()
            });

            function updateChosenItems() {
                // Clear the existing items in the list
                $('#chosenItemsList').empty();
                
                // Get the cart items from local storage
                var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
                
                // Loop through each item and add it to the list
                cartItems.forEach(function(item) {
                    
                    var newRow = $('<tr>').append(
                        $('<td>').text(item.name),
                        $('<td>').text(item.quantity),
                        $('<td>').text(item.price),
                        $('<td>').append($('<a>').text('Remove').attr('href', 'javascript:void(0)').attr('class', 'btn-remove').attr('data-fruitId', item.id))
                    );

                    $('#chosenItemsList').append(newRow);
                });
            }

            function calculateTotalBill() {
                // Retrieve cart items from localStorage
                var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
                
                // Initialize total bill
                var totalBill = 0;

                // Iterate over cart items and calculate total bill
                cartItems.forEach(function(item) {
                    totalBill += item.quantity * item.price;
                });

                return totalBill;
            }
            
            // Update total bill in the UI
            function updateTotalBillUI() {
                var totalBill = calculateTotalBill();
                $('#totalBill').text(totalBill);
                $('#totalBill').val(totalBill);
            }
            
            // Initial update of total bill in the UI
            updateTotalBillUI();

            $(document).on('click', '.btn-remove', function(event) {
                // Prevent the default action of the anchor tag
                event.preventDefault();

                // Get the value of data-fruitid attribute
                var fruitId = $(this).data('fruitid');

                // Retrieve cart items from localStorage
                var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

                // Filter out the item with the matching fruitId
                var updatedCartItems = cartItems.filter(function(item) {
                    return item.id != fruitId;
                });

                // Save the updated cart items back to localStorage
                localStorage.setItem('cartItems', JSON.stringify(updatedCartItems));
                
                // Optionally, you can update the UI to reflect the removal
                $(this).closest('tr').remove(); // Remove the row from the table

                // calculate total bill
                updateTotalBillUI();
            });

            // Initial update of chosen items
            updateChosenItems();

            // Function to create request inputs for fruitId and quantity
            function createRequestInputs() {
                // Retrieve cart items from localStorage
                var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

                // Iterate over cart items and create request inputs
                cartItems.forEach(function(item) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'fruits[]',
                        value: item.id
                    }).appendTo('#buyForm');

                    $('<input>').attr({
                        type: 'hidden',
                        name: 'quantity[]',
                        value: item.quantity
                    }).appendTo('#buyForm');
                });
            }

            $('#submitButton').click(function(event) {
                // Create request inputs for fruitId and quantity
                createRequestInputs();

                // Submit the form
                $('#buyForm').submit();
            });
        });
    </script>
@stop
