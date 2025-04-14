@extends('layouts.default')

@section('title','Lobby - ')

@section('content')

<div class="container-fluid h-100">
    <div class="row h-100">

        <livewire-chat-bar :conv-id="$id"/>

        <livewire-chat :conv-id="$id" />

    </div>
</div>

@endsection
