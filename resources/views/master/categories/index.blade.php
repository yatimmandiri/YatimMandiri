@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$pageTitle}}</h3>
                <div class="card-tools">
                    <a href="{{  route('categories.create') }}">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="card card-primary card-outline">
                    <div class="card-body row">
                        <div class="col-lg-4">
                            <label>Status</label>
                            <div class="form-group">
                                <select name="status" id="status" class="form-control select2">
                                    <option value="all">Semua</option>
                                    <option value="Y">Actived</option>
                                    <option value="N">Deactived</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>Populer</label>
                            <div class="form-group">
                                <select name="populer" id="populer" class="form-control select2">
                                    <option value="all">Semua</option>
                                    <option value="Y">Populer</option>
                                    <option value="N">Not Populer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button id="resetDataTable" class="btn btn-sm btn-warning">Clear</button>
                        </div>
                    </div>
                </div>
                {{ $dataTable->table(['class' => 'table table-sm table-hover table-striped'], true) }}
            </div>
        </div>
    </div>
</div>

{{ $dataTable->scripts() }}

<script type="module">
    $(document).ready(function() {
        setDataSelect({
            tagid: '#status',
            placeholder: 'Select Status',
        })
        setDataSelect({
            tagid: '#populer',
            placeholder: 'Select Populer',
        })

        let table = $('#category-table')
        var status = $('#status').val()
        var populer = $('#populer').val()

        table.on('preXhr.dt', function(e, settings, data) {
            data.status = status;
            data.populer = populer;
        })

        table.DataTable().ajax.reload()

        $('#status').on('change', function() {
            status = $(this).val();

            table.on('preXhr.dt', function(e, settings, data) {
                data.status = status;
                data.populer = populer;
            })

            table.DataTable().ajax.reload()
        })

        $('#populer').on('change', function() {
            populer = $(this).val();

            table.on('preXhr.dt', function(e, settings, data) {
                data.populer = populer;
                data.status = status;
            })

            table.DataTable().ajax.reload()
        })

        $('#resetDataTable').click(function() {
            $('#status').val('all')
            $('#populer').val('all')

            table.on('preXhr.dt', function(e, settings, data) {
                data.status = 'all';
                data.populer = 'all';
            })

            table.DataTable().ajax.reload()
        })
    })
</script>

@endsection