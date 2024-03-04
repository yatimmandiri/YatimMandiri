@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$pageTitle}}</h3>
                <div class="card-tools">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCreateFaq"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="card card-primary card-outline">
                    <div class="card-body row">
                        <div class="col-lg-4">
                            <label>Categories</label>
                            <div class="form-group">
                                <select name="categories" id="categories" class="form-control select2"></select>
                            </div>
                        </div>
                    </div>
                </div>
                {{ $dataTable->table(['class' => 'table table-sm table-hover table-striped'], true) }}
            </div>
        </div>
    </div>
</div>

@include('master.faqs.create')
@include('master.faqs.edit')
@include('master.faqs.show')

{{ $dataTable->scripts() }}

<script type="module">
    $(document).ready(function() {

        ajaxRequest({
            url: `/apis/categories`,
        }).done((categories) => {
            setDataSelect({
                tagid: '#categories',
                data: categories.data.map((item) => {
                    return {
                        id: item.id,
                        text: item.categories_name,
                    }
                }),
                placeholder: 'Select Categories',
            })
        })

        let table = $('#faq-table')
        var categories = $('#categories').val()

        table.on('preXhr.dt', function(e, settings, data) {
            data.categories = categories;
        })

        table.DataTable().ajax.reload()

        $('#categories').on('change', function() {
            categories = $(this).val();

            table.on('preXhr.dt', function(e, settings, data) {
                data.categories = categories;
            })

            table.DataTable().ajax.reload()
        })

        $('#resetDataTable').click(function() {
            resetDataSelect({
                tagid: '#categories',
                placeholder: 'Select Categories',
            })

            table.on('preXhr.dt', function(e, settings, data) {
                data.status = 'all';
                data.populer = 'all';
            })

            table.DataTable().ajax.reload()
        })
    })
</script>

@endsection