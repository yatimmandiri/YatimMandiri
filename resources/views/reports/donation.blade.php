@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$pageTitle}}</h3>
            </div>
            <div class="card-body">
                <div class="card card-primary card-outline">
                    <div class="card-body row">
                        <div class="col-lg-4">
                            <label>Tanggal</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control daterange float-right" id="filter_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>Status</label>
                            <div class="form-group">
                                <select name="status" id="status" class="form-control select2">
                                    <option value="all">Semua</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Expired">Expired</option>
                                    <option value="Success">Success</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>Zisco</label>
                            <div class="form-group">
                                <select name="zisco" id="zisco" class="form-control select2"></select>
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
        ajaxRequest({
            url: `/apis/users`,
            params: {
                roles: 'Zisco'
            },
        }).done((users) => {
            setDataSelect({
                tagid: '#zisco',
                data: users.data.map((item) => {
                    return {
                        id: item.referals,
                        text: item.name,
                    }
                }),
                placeholder: 'Select Zisco',
            })
        })

        $('#status').select2({
            theme: 'bootstrap-5'
        })

        let table = $('#transaction-table')

        setDateRange({
            idtag: '#filter_date'
        })

        var filterStartDate = $('#filter_date').data().startDate.format('YYYY-MM-DD')
        var filterEndDate = $('#filter_date').data().endDate.format('YYYY-MM-DD')
        var status = $('#status').val()
        var zisco = $('#zisco').val()

        table.on('preXhr.dt', function(e, settings, data) {
            data.startDate = filterStartDate;
            data.endDate = filterEndDate;
            data.zisco = zisco;
            data.status = status;
        })

        table.DataTable().ajax.reload()

        $('#zisco').on('change', function() {
            zisco = $(this).val();

            table.on('preXhr.dt', function(e, settings, data) {
                data.startDate = filterStartDate;
                data.endDate = filterEndDate;
                data.zisco = zisco;
                data.status = status;
            })

            table.DataTable().ajax.reload()
        })

        $('#status').on('change', function() {
            status = $(this).val();

            table.on('preXhr.dt', function(e, settings, data) {
                data.startDate = filterStartDate;
                data.endDate = filterEndDate;
                data.zisco = zisco;
                data.status = status;
            })

            table.DataTable().ajax.reload()
        })

        $('#filter_date').on('apply.daterangepicker', function(ev, picker) {
            filterStartDate = picker.startDate.format('YYYY-MM-DD')
            filterEndDate = picker.endDate.format('YYYY-MM-DD')

            table.on('preXhr.dt', function(e, settings, data) {
                data.startDate = filterStartDate;
                data.endDate = filterEndDate;
                data.zisco = zisco;
                data.status = status;
            })

            table.DataTable().ajax.reload()
        })

        $('#resetDataTable').click(function() {

            $('#status').val('all')

            resetDataSelect({
                tagid: '#zisco',
                placeholder: 'Select Users',
            })

            table.on('preXhr.dt', function(e, settings, data) {
                data.startDate = moment().startOf('month').format('YYYY-MM-DD');
                data.endDate = moment().endOf('month').format('YYYY-MM-DD');
                data.status = 'all';
            })

            table.DataTable().ajax.reload()
        })

    })
</script>

@endsection