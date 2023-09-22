<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Counter;
use App\Models\InvoiceItem;

class InvoiceController extends Controller
{
    public function get_all_invoice() {
        $invoices = Invoice::with('customer')->orderBy('id', 'DESC')->get();

        return response()->json([
            'invoices' => $invoices
        ],200);
    }

    public function search_invoice(Request $request) {
        $search = $request->get('s');

        if($search != null ) {
            $invoices = Invoice::with('customer')->where('id','LIKE', "%$search%")
            ->get();

            return response()-> json([
                'invoices' => $invoices
            ],200);
        }else {
            return $this->get_all_invoice();
        }
    }

    public function create_invoice(Request $request) {
        $counter = Counter::where('key', 'invoice')->first();
        $random = Counter::where('key', 'invoice')->first();

        $invoice = Invoice::orderBy('id', 'DESC')->first();

        if($invoice) {
            $invoice = $invoice->id+1;
            $counters = $counter->value + $invoice;
        }else{
            $counters = $counter->value;
        }

        $formData = [
            'number' =>$counter->prefix.$counters,
            'customer_id' => null,
            'customer' => null,
            'date' => date('Y-m-d'),
            'due_date' => null,
            'reference' => null,
            'discount' => 0,
            'term_and_conditions' => 'Default Terms and Conditions',
            'item' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'price' => 0,
                    'quantity'=> 1
                ]
            ]
        ];
        return response()->json($formData);
    }

    public function add_invoice(Request $request) {

        $invoiceitem = $request->input("invoice_item");

        $invoiceData['sub_total'] = $request->input("sub_total");
        $invoiceData['total'] = $request->input("total");
        $invoiceData['customer_id'] = $request->input("customer_id");
        $invoiceData['number'] = $request->input("number");
        $invoiceData['date'] = $request->input("date");
        $invoiceData['due_date'] = $request->input("due_date");
        $invoiceData['reference'] = $request->input("reference");
        $invoiceData['terms_and_conditions'] = $request->input("terms_and_conditions");

        $invoice = Invoice::create($invoiceData);

        foreach(json_decode($invoiceitem) as $item) {
            $itemdata['product_id'] = $item->id;
            $itemdata['invoice_id'] = $invoice->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['price'] = $item->price;

            InvoiceItem::create($itemdata);
        }
    }
}
