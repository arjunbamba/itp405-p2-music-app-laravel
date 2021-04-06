@extends('layouts.email')

@section('content')
<h1>We have a new album!</h1>
<p>
    {{ $album->artist->name }} has a new album called {{ $album->title }}.
</p>
@endsection