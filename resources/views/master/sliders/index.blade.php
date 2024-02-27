@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$pageTitle}}</h3>
                <div class="card-tools">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCreateSlider"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table(['class' => 'table table-sm table-hover table-striped'], true) }}
            </div>
        </div>
    </div>
</div>

@include('master.sliders.create')
@include('master.sliders.edit')
@include('master.sliders.show')

{{ $dataTable->scripts() }}

@endsection