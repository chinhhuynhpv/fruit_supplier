<?php

namespace App\Repositories;

use App\Helpers\AppData as HelpersAppData;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class InvoiceRepository extends BaseRepository
{
    public function getModel()
    {
        return Invoice::class;
    }

    public function getInputs($request)
    {
        $inputs = $request->all();
    
        $attributes = [
            'customer_name' => $inputs['customer_name'],
            'phone' => $inputs['phone'],
            'email' => $inputs['email'],
            'staff_id' => $inputs['staff_id'],
            'amount' => floatval($inputs['total_bill']), 
            'bonus' => floatval($inputs['bonus']),
        ];

        return $attributes;
    }

    public function addFruitIntoInvoice($invoiceId, $fruitId = [], $quantity = []){
      
        try{
            if($invoiceId){
                foreach ($fruitId as $key => $item) {
                    // Create a record in the invoice_fruit table
                    DB::table('invoice_fruit')->insert([
                        'invoice_id' => $invoiceId,
                        'fruit_id' => intVal($item),
                        'quantity' => floatVal($quantity[$key]),
                    ]);
                }
                return true;
            }
        
        } catch (\Exception $e) {
            // If an error occurs, roll back the transaction
            DB::rollBack();
            // Handle the exception, log or report it
            return null;
        }
    }

    public function getlistInvoices() {
        $result = $this->model;
        
        return $result->with('staff')->with('fruits.fruit_category')->orderBy('created_at','DESC')->paginate(10);
    }

    public function getlistInvoicesByStaff($staffId) {
        $result = $this->model;
        
        return $result->with('staff')->with('fruits.fruit_category')->where('staff_id', $staffId)->orderBy('created_at','DESC')->paginate(10);
    }

    public function getInvoiceDetail($invoiceId) {
        $result = $this->model;
        
        return $result->with('staff')->with('fruits.fruit_category')->find($invoiceId);
    }

    public function updateFruitQuantity($invoiceId){
        $listFruit =  $this->getInvoiceDetail($invoiceId)->fruits;

        foreach($listFruit as $fruit){
            $fruit->decrement('quantity', $fruit->pivot->quantity);
        }

    }

    public function updateWithConditions($conditions, $data)
    {
        return $this->model->where($conditions)->update($data); 
    }

}