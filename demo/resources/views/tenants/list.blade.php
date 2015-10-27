@extends('layouts.front')
@section('content')
<div class="col-sm-12">
    <ul class="list-unstyled">
        
        @foreach($tenants as $row)
        <li><a href="{{ URL::to('tenant/' . $row['id'] . '/items') }}">{{ $row['name'] }}</a></li>
        @endforeach
    </ul>
</div>
@stop