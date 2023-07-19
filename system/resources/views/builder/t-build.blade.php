@extends('builder.layout')
@section('title', 'Dashboard: Template Builder')

@section('end_head')
    <link rel="stylesheet" href="{{asset('assets/templates/'.$id.'/template-style.css')}}">
@endsection

@section('content')
    @include('builder.templates.'.$id)
@endsection