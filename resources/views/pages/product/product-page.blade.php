@extends('layout.app')
@section('content')
    @include('components.product.productList')
    @include('components.product.productDelete')
    @include('components.product.productCreate')
    @include('components.product.productUpdate')
@endsection
