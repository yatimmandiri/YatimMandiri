@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$pageTitle}}</h3>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-6">
                    <label for="categories_name" class="mb-1">Name</label>
                    <div>{{ $category->categories_name }}</div>
                </div>
                <div class="form-group col-md-6">
                    <label for="categories_slug" class="mb-1">Slug</label>
                    <div>{{ $category->categories_slug }}</div>
                </div>
                <div class="form-group col-md-12">
                    <label for="categories_except" class="mb-1">Excerpt</label>
                    <div>{!! $category->categories_excerpt !!}</div>
                </div>
                <div class="form-group col-md-12">
                    <label for="categories_description" class="mb-1">Description</label>
                    <div>{!! $category->categories_description !!}</div>
                </div>
                <div class="form-group col-md-12">
                    <a href="{{ route('categories.index') }}">
                        <button type="button" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Back</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {

    })
</script>

@endsection