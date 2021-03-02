<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index() 
    {
        // Lecture 3/1/21 ORM/Eloquent
        // $invoices = Invoice::all(); // Suffers from the N=1 problem

        // Eager loading to solve N+1 problem
        $invoices = Invoice::with('customer')->get();


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

        return view('invoice.show', [
            'invoice' => $invoice,
            // 'invoiceItems' => $invoiceItems,
        ]);
    }
}
