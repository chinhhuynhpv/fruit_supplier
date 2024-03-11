<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\InvoiceRepository;
use App\Repositories\FruitRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Enums\EError;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class InvoiceController extends Controller
{
    private $invoiceRepository;
    private $fruitRepository;

    public function __construct(FruitRepository $fruitRepository, InvoiceRepository $invoiceRepository)
    {
        $this->fruitRepository = $fruitRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function index()
    {
        $list = $this->invoiceRepository->getlistInvoices();
    
        return view('staff.invoice.list', compact('list'));
    }

    public function create()
    {
        $fruits = $this->fruitRepository->getlistFruits();
        return view('staff.invoice.input', compact('fruits'));
    }

    public function store(Request $request)
    {
        
        $input = $request->all();

        Validator::make($input, [
            'customer_name' => ['required', 'string'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
            'fruits' => ['required'],
            'quantity' => ['required'],
            'total_bill' => ['required'],
        ])->validate();

        $request['staff_id'] = Auth::guard('staff')->user()->id;
        
        try {
            DB::beginTransaction();
            $attributes = $this->invoiceRepository->getInputs($request);
            
            $invoice = $this->invoiceRepository->create($attributes);
            
            if($invoice->id) {
                $invoiceFuitInsert = $this->invoiceRepository->addFruitIntoInvoice($invoice->id, $input['fruits'], $input['quantity']);
            }
            
            $notification = array(
                'message' => 'Save success.',
                'alert-type' => 'success'
            );
            DB::commit();
            return redirect()->route('invoiceList')->with($notification);
        } catch (\Exception $e) {
            logger($e->getMessage() . ' at ' . $e->getLine() .  ' in ' . $e->getFile());
            $notification = array(
                'message' => 'Save Fail!',
                'alert-type' => 'error'
            );
            DB::rollBack();
            return \redirect()->back()->with($notification);
        }

    }

    public function export($invoiceId) {
        // get general  invoice
        $invoice = $this->invoiceRepository->getInvoiceDetail($invoiceId);

        // get list fruits by invoice
        $listFruitsByInvoice = $invoice->fruits;
        
        $issuedDate = Carbon::now()->format('d-m-Y');

        $pdf = PDF::loadView('staff/invoice/export/invoice-document', compact('invoice', 'listFruitsByInvoice' ,'issuedDate'));
        
        $pdf->setOptions([
            'enable_font_subsetting'    => true
        ]);
        return $pdf->download('invoice.pdf');
    }

    public function delete (Request $request) {
        
        // try {
            $input = $request->all();
            if (!empty($input['id'])) {
                $result = $this->invoiceRepository->delete($input['id']);
                if ($result) {
                    return \Response::json(['success' => EError::SUCCESS, 'message' => 'Deleted successfull']);
                } else {
                    return \Response::json(['success' => EError::FAIL, 'message' => 'Error! Delete fail!']);
                }
            }
        // } catch (\Exception $e) {
        //     logger($e->getMessage() . ' at ' . $e->getLine() .  ' in ' . $e->getFile());
        //     return \Response::json(['success' => EError::FAIL, 'message' => 'Error! Delete fail!']);
        // }
    }

    public function detail ($invoiceId) {
        
        try {
            // get invoice
            $invoice = $this->invoiceRepository->getInvoiceDetail($invoiceId);
            
            // get list fruits by invoice
            $listFruitsByInvoice = $invoice->fruits;
            
            return view('staff/invoice/detail', compact('invoice', 'listFruitsByInvoice'));
        } catch (\Exception $e) {
            logger($e->getMessage() . ' at ' . $e->getLine() .  ' in ' . $e->getFile());
            return \Response::json(['success' => EError::FAIL, 'message' => 'Error!  Something went wrong!']);
        }
    }

    // public function edit ($invoiceId) {
       
    //     if (!empty($invoiceId)) {
    //         $invoice = $this->invoiceRepository->getInvoiceDetail($invoiceId);
            
    //         // get list fruits by invoice
    //         $listFruitsByInvoice = $invoice->fruits()->get();
            
    //         // get list fruits
    //         $fruits = $this->fruitRepository->getlistFruits();
            
    //         return view('staff.invoice.edit', compact('invoice', 'listFruitsByInvoice', 'fruits'));
    //     }
    // }

    // public function update (Request $request, $invoiceId) {
        
    //     $inputs = $request->all();
        
    //     Validator::make($inputs, [
    //         'customer_name' => ['required', 'string'],
    //         'phone' => ['required'],
    //         'email' => ['required', 'email'],
    //         'fruits' => ['required'],
    //         'quantity' => ['required'],
    //         'total_bill' => ['required'],
    //     ])->validate();

    //     $request['staff_id'] = Auth::guard('staff')->user()->id;

    //     // try {
    //         DB::beginTransaction();
    //         $attributes = $this->invoiceRepository->getInputs($request);
            
    //         $invoice = $this->invoiceRepository->update($invoiceId, $attributes);
    //         // remove all the product in invoice
            
    //         $fruitIds = $inputs['fruits'];
    //         $quantities = $inputs['quantity'];
    //         $newFruits = [];

    //         // Loop through the arrays and combine them into the required format
    //         for ($i = 0; $i < count($fruitIds); $i++) {
    //             $newFruits[$fruitIds[$i]] = ['quantity' => $quantities[$i]];
    //         }

    //         // Update the relationship using sync method
    //         $invoice->fruits()->sync($newFruits);
            
    //         $notification = array(
    //             'message' => 'Save success.',
    //             'alert-type' => 'success'
    //         );
    //         DB::commit();
    //         return redirect()->route('invoiceList')->with($notification);
    //     // } catch (\Exception $e) {
    //     //     logger($e->getMessage() . ' at ' . $e->getLine() .  ' in ' . $e->getFile());
    //     //     $notification = array(
    //     //         'message' => 'Update fruit fail!',
    //     //         'alert-type' => 'error'
    //     //     );
    //     //     return \redirect()->back()->with($notification);
    //     // }
    // }



    
}
