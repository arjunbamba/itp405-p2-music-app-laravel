<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


class InvoiceController extends Controller
{
    public function index() 
    {
        // Lecture 03/22
        $this->authorize('viewAny', Invoice::class);

        // Lecture 3/1/21 ORM/Eloquent
        // $invoices = Invoice::all(); // Suffers from the N=1 problem

        // A7: Take OUT: Eager loading to solve N+1 problem
        //$invoices = Invoice::with('customer')->get(); 


        // ----------
        // $invoices = DB::table('invoices')
        //     ->join('customers','invoices.customer_id', '=', 'customers.id')
        //     ->get([
        //         'invoices.id AS id',
        //         'invoice_date',
        //         'first_name',
        //         'last_name',
        //         'total',
        //     ]); // Model Layer; 

            //SELECT invoices.id AS id, invoice_date, first_name, last_name, total
            //FROM invoices
            //INNER JOIN  customers ON invoices.customer_id = customers.id
        
        //A7
        $invoices = Invoice::select('invoices.*')
             ->with(['customer'])
             ->join('customers', 'invoices.customer_id', '=', 'customers.id')
             ->when(!Auth::user()->isAdmin(), function($query) {
                 return $query->where('customers.email', '=', Auth::user()->email);
             })
             ->get();

        return view('invoice.index', [
            'invoices' => $invoices
        ]);
    }

    public function show($id) 
    {
        // // dd($id);
        // $invoice = DB::table('invoices')
        //     ->where('id', '=', $id)
        //     ->first();

        // // dd($invoice);

        // $invoiceItems = DB::table('invoice_items')
        //     ->where('invoice_id', '=', $id)
        //     ->join('tracks', 'invoice_items.track_id', '=', 'tracks.id')
        //     ->join('albums', 'tracks.album_id', '=', 'albums.id')
        //     ->join('artists', 'albums.artist_id', '=', 'artists.id')
        //     ->get([
        //         'invoice_items.unit_price',
        //         'tracks.name AS track',
        //         'albums.title AS album',
        //         'artists.name AS artist',
        //     ]);

        // Eager load tracks; means go eager load tracks when you go get invoiceitems for invoice you're finding
        // invoices that you get back are instances of the invoice model class
        $invoice = Invoice::with([
            'invoiceItems.track',
            'invoiceItems.track.album', //assumes track model has album relationship
            'invoiceItems.track.album.artist',
        ])->find($id);

        // Lecture 03/22: Gates

        // Via view-invoice gate
        
        // if (Gate::denies('view-invoice', $invoice)) { //if returns false, gate denies will be false because you should have access to the invoice
        //     abort(403);
        // }

        // if (!Gate::allows('view-invoice', $invoice)) { 
        //     abort(403);
        // }

        // if (Auth::user()->cannot('view-invoice', $invoice)) {
        //     abort(403);
        // }

        // if (!Auth::user()->can('view-invoice', $invoice)) {
        //     abort(403);
        // }

        // $this->authorize('view-invoice', $invoice); //will throw error if authorization doesn't pass and it'll automatiically call abort(403) for us

        // Via InvoicePolicy

        $this->authorize('view', $invoice); //will look for a method called view on the invoice policy which it can look up via the invoice object we pass in below //@36:35 Lecture 3/22

        // if (Gate::denies('view', $invoice)) { //this will invoke policy
        //     abort(403);
        // }

        // if (Auth::user()->cannot('view', $invoice)) {
        //     abort(403);
        // }


        return view('invoice.show', [
            'invoice' => $invoice,
            // 'invoiceItems' => $invoiceItems,
        ]);
    }
}
