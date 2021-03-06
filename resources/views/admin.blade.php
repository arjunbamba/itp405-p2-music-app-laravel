@extends('layouts.main')

@section('title', 'Admin Settings Page')

@section('content')
{{-- Project 8: Emailing --}}
<form action="{{ route('admin.stats') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">
        Email Stats to Users
    </button>
</form>

<br/>

<form action="{{ route('admin.update') }}" method="POST">
    @csrf
    <div class="mb-3">
        @if ($admin && $admin->value == true)
        <input type="checkbox" id="maintenance-mode" name="maintenance-mode" value="maintenance-mode" checked="checked">
        @else
        <input type="checkbox" id="maintenance-mode" name="maintenance-mode" value="maintenance-mode">
        @endif
        <label for="maintenance-mode"> Maintenance Mode</label><br>
    </div>
    <button type="submit" class="btn btn-primary">
        Save
    </button>
</form>
@endsection