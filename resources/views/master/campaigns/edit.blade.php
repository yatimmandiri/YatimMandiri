@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <form method="POST" id="formCampaignUpdate" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-header">
                    <h3 class="card-title">{{$pageTitle}}</h3>
                </div>
                <div class="card-body row">
                    <div class="form-group col-md-6">
                        <label for="campaign_name" class="mb-1">Name</label>
                        <input type="text" name="campaign_name" placeholder="Name" class="form-control" id="campaign_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="campaign_nominal" class="mb-1">Nominal Paket</label>
                        <input type="number" name="campaign_nominal" placeholder="Nominal" class="form-control" id="campaign_nominal">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="campaign_nominal_min" class="mb-1">Nominal Minimum</label>
                        <input type="number" name="campaign_nominal_min" placeholder="Nominal" class="form-control" id="campaign_nominal_min">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="categories_id" class="mb-1">Categories</label>
                        <select name="categories_id" id="categories_id" class="form-control select2"></select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="paket_id" class="mb-1">Paket</label>
                        <select name="paket_id" id="paket_id" class="form-control select2"></select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="campaign_template" class="mb-1">Template</label>
                        <select name="campaign_template" id="campaign_template" class="form-control select2"></select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="campaign_featureimage" class="mb-1">Feature Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="campaign_featureimage" id="campaign_featureimage">
                            <label class="custom-file-label" for="campaign_featureimage">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="campaign_description" class="mb-1">Description</label>
                        <textarea name="campaign_description" placeholder="Description" class="form-control editors" id="campaign_description">
                            </textarea>
                    </div>
                    <div class="form-group col-md-12 text-right">
                        <a href="{{ route('campaigns.index') }}">
                            <button type="button" class="btn btn-danger"><i class="fas fa-times"></i> Cancel</button>
                        </a>
                        <button type="button" class="btn btn-primary" id="submitData" onclick="$(this).submit()"><i class="fas fa-save"></i>
                            Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        bsCustomFileInput.init();
        // getPakets({})
        // getCategory({})

        $('#campaign_name').val('{{ $campaign->campaign_name }}')
        $('#campaign_title').val('{{ $campaign->campaign_title }}')
        $('#campaign_nominal').val('{{ $campaign->campaign_nominal }}')
        $('#campaign_nominal_min').val('{{ $campaign->campaign_nominal_min }}')

        ajaxRequest({
            url: `/apis/categories`,
        }).done((categories) => {
            setDataSelect({
                tagid: '#categories_id',
                data: categories.data.map((item) => {
                    return {
                        id: item.id,
                        text: item.categories_name,
                    }
                }),
                dataSelected: '{{ $campaign->categories_id }}',
                placeholder: 'Select Categories',
            })
        })

        ajaxRequest({
            url: `/sim/paket`,
        }).done((pakets) => {
            setDataSelect({
                tagid: '#paket_id',
                data: pakets.data.map((item) => {
                    return {
                        id: item.id,
                        text: item.name,
                    }
                }),
                dataSelected: '{{ $campaign->paket_id }}',
                placeholder: 'Select Paket',
            })
        })

        setDataSelect({
            tagid: '#campaign_template',
            data: [{
                    id: 'T1',
                    text: 'Template 1',
                },
                {
                    id: 'T2',
                    text: 'Template 2',
                },
                {
                    id: 'T3',
                    text: 'Template 3',
                },
                {
                    id: 'T4',
                    text: 'Template 4',
                }
            ],
            dataSelected: '{{ $campaign->campaign_template }}',
            placeholder: 'Select Template',
        })

        setDataEditors({
            tagid: '#campaign_description',
            value: '{!! $campaign->campaign_description !!}'
        })

        $('#formCampaignUpdate').ajaxForm({
            url: `/master/campaigns/{{$campaign->id}}`,
            type: 'POST',
            resetForm: true,
            beforeSubmit: function(formData) {
                var formSerialize = $.param(formData);
                formData[9]['value'] = myEditor.getData();
                return true;
            },
            success: function(result) {
                Toast.fire({
                    icon: 'success',
                    title: result.message
                })

                window.location.href = '/master/campaigns'
            },
            error: function(errors) {
                Toast.fire({
                    icon: 'error',
                    title: errors.responseJSON.message,
                })
            }
        });
    })
</script>

@endsection