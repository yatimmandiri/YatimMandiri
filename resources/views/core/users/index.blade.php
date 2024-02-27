@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$pageTitle}}</h3>
                <div class="card-tools">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCreateUser"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="card card-primary card-outline">
                    <div class="card-body row">
                        <div class="col-lg-4">
                            <label>Role</label>
                            <div class="form-group">
                                <select name="role" id="role" class="form-control select2">
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

@include('core.users.create')
@include('core.users.edit')
@include('core.users.show')

{{ $dataTable->scripts() }}

<script type="module">
    $(document).ready(function() {

        ajaxRequest({
            url: `/apis/roles`,
        }).done((roles) => {
            setDataSelect({
                tagid: '#role',
                data: roles.data.map((item) => {
                    return {
                        id: item.id,
                        text: item.name,
                    }
                }),
                placeholder: 'Select Role',
            })
        })

        let table = $('#user-table')
        var role = $('#role').val()

        table.on('preXhr.dt', function(e, settings, data) {
            data.role = role;
        })

        table.DataTable().ajax.reload()

        $('#role').on('change', function() {
            role = $(this).val();

            table.on('preXhr.dt', function(e, settings, data) {
                data.role = role;
            })

            table.DataTable().ajax.reload()
        })

        $('#resetDataTable').click(function() {
            resetDataSelect({
                tagid: '#role',
                placeholder: 'Select Role',
            })

            table.on('preXhr.dt', function(e, settings, data) {
                data.role = '';
            })

            table.DataTable().ajax.reload()
        })
    })
</script>


@endsection