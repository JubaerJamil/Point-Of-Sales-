@extends('layout.app')
@section('content')
    @include('components.category.categoryList')
    @include('components.category.categoryCreate')
    @include('components.category.categoryDelete')
    @include('components.category.categoryUpdate')
@endsection
