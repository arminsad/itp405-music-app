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
        $this->authorize('viewAny', Invoice::class);

        // $invoices = Invoice::all(); // Suffers from the N+1 problem
        $invoices = Invoice::select('invoices.*')
            ->with(['customer'])
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->when(!Auth::user()->isAdmin(), function($query){
                return $query->where('customers.email', '=', Auth::user()->email);
            })
            ->get();

        // $invoices = DB::table('invoices')
        // ->join('customers', 'invoices.customer_id', '=', 'customers.id')
        // ->get([
        //     'invoices.id AS id',
        //     'invoice_date',
        //     'first_name',
        //     'last_name',
        //     'total',
        // ]);

        // SELECT invoices.id AS id, invoice_date, first_name, last_name, total
        // FROM invoices
        // INNER JOIN customers ON invoices.customer_id = customers.id

        return view('invoice.index', [
            'invoices' => $invoices
        ]);
    }
    public function show($id)
    {
        // $invoice = DB::table('invoices')
        // ->where('id', '=', $id)
        // ->first();

        // $invoiceItems = DB::table('invoice_items')
        //     ->where('invoice_id', '=', $id)
        //     ->join('tracks', 'tracks.id', '=', 'invoice_items.track_id')
        //     ->join('albums', 'tracks.album_id', '=', 'albums.id')
        //     ->join('artists', 'albums.artist_id', '=', 'artists.id')
        //     ->get([
        //         'invoice_items.unit_price',
        //         'tracks.name AS track',
        //         'albums.title AS album',
        //         'artists.name AS artist',
        //     ]);

        $invoice = Invoice::with([
            'invoiceItems.track',
            'invoiceItems.track.album',
            'invoiceItems.track.album.artist',
        ])->find($id);
        
        // if (Gate::denies('view-invoice', $invoice)){
        //     abort(403);
        // }

        // if (!Gate::allows('view-invoice', $invoice)){
        //     abort(403);
        // }

        // if (Auth::user()->cannot('view-invoice', $invoice)){
        //     abort(403);
        // }

        // if (!Auth::user()->can('view-invoice', $invoice)){
        //     abort(403);
        // }

        // $this->authorize('view-invoice', $invoice);
        
        // Via InvoicePolicy
        // $this->authorize('view', $invoice);

        // if (Gate::denies('view', $invoice)){
        //     abort(403);
        // }

        // if (Auth::user()->cannot('view', $invoice)){
        //     abort(403);
        // }

        return view('invoice.show' , [
            'invoice' => $invoice,
            // 'invoiceItems' => $invoiceItems,
        ]);
    }
}
