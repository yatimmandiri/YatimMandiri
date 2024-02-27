@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <form method="POST" id="formCategoryUpdate" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-header">
                    <h3 class="card-title">{{$pageTitle}}</h3>
                </div>
                <div class="card-body row">
                    <div class="form-group col-md-6">
                        <label for="categories_name" class="mb-1">Name</label>
                        <input type="text" name="categories_name" placeholder="Name" class="form-control" id="categories_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="categories_icon" class="mb-1">Icon</label>
                        <input type="file" name="categories_icon" placeholder="Icon" class="form-control" id="categories_icon">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="categories_featureimage" class="mb-1">Feature Image</label>
                        <input type="file" name="categories_featureimage" placeholder="Feature Image" class="form-control" id="categories_featureimage">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="categories_description" class="mb-1">Description</label>
                        <textarea name="categories_description" placeholder="Description" class="form-control editors" id="categories_description">
                            </textarea>
                    </div>
                    <div class="form-group col-md-12 text-right">
                        <a href="{{ route('categories.index') }}">
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
        $('#categories_name').val('{{ $category->categories_name }}')

        setDataEditors({
            tagid: '#categories_description',
            value: '{!! $category->categories_description !!}',
        })

        $('#formCategoryUpdate').ajaxForm({
            url: `/master/categories/{{$category->id}}`,
            type: 'POST',
            resetForm: true,
            beforeSubmit: function(formData) {
                var formSerialize = $.param(formData);
                formData[5]['value'] = myEditor.getData();
                return true;
            },
            success: function(result) {
                Toast.fire({
                    icon: 'success',
                    title: result.message
                })

                window.location.href = '/master/categories'
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