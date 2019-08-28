@extends('layouts.app')
@section('title', 'Dashboard')
@section('new_post', 'active')
@section('dash-title', $post->title)
@section('dash-content')
{!! $post->description !!}
@endsection