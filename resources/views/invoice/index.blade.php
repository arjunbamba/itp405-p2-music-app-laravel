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
                    {{-- {{$invoice->first_name}} {{$invoice->last_name}} --}}
                    {{-- {{$invoice->customer->first_name}} {{$invoice->customer->last_name}} --}}
                    
                    {{-- call getFullName() from customer model --}}
                    {{-- Couldn't have done with queryBuilder as no models. Querybuilder gave object back but couldnt add custom method to that. --}}
                    {{-- In ORM, classes are defined in model and that's returned when we use eloquent. so when you access customer relationship, you get back instance of customer model  --}}
                    {{-- If you change getFullName() to getFullNameAttribute() in customer model, then you can just do ->full_name instead of ->getFullName(); --}}
                    {{-- {{$invoice->customer->getFullName()}} --}}
                    {{$invoice->customer->full_name}}
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