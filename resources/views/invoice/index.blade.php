@extends('layouts.main') 

@section('title', 'Invoices')

@section('content')
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Customer</th> 
            <th colspan="2">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td>
                    {{$invoice->id}}
                </td>
                <td>
                    {{$invoice->invoice_date}}
                </td>
                <td>
                    {{$invoice->first_name}} {{$invoice->last_name}}
                </td>
                <td>
                    ${{$invoice->total}}
                </td>
                <td>
                    {{-- /invoices/{{$invoice->id}} --}}
                    <a href="{{ route('invoice.show', [ 'id' => $invoice->id]) }}">
                        Details
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection