@extends('layout.app')
@section('content')
    @include('components.customer.customerList')
    @include('components.customer.customerCreate')
    @include('components.customer.customerDelete')
    @include('components.customer.customerUpdate')
@endsection
