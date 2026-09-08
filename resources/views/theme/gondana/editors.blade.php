@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection


@section('social-meta')
<link rel="canonical" href="{{ route('experts') }}" />
@endsection
@section('content') 




<!-- ROW-1 OPEN -->
<div class="section pb-0" style="background-color: #F0F0F5;">
    <div class="container">
      




@include('includes.editors')




</div>
<!-- ROW-1 CLOSED -->




@endsection