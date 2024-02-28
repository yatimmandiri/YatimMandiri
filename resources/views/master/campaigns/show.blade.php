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
                    <label for="campaign_name" class="mb-1">Name</label>
                    <div>{{ $campaign->campaign_name }}</div>
                </div>
                <div class="form-group col-md-6">
                    <label for="campaign_title" class="mb-1">Title</label>
                    <div>{{ $campaign->campaign_title }}</div>
                </div>
                <div class="form-group col-md-12">
                    <label for="campaign_excerpt" class="mb-1">Excerpt</label>
                    <div>{!! $campaign->campaign_excerpt !!}</div>
                </div>
                <div class="form-group col-md-12">
                    <label for="campaign_description" class="mb-1">Description</label>
                    <div>{!! $campaign->campaign_description !!}</div>
                </div>
                <div class="form-group col-md-12">
                    <a href="{{ route('campaigns.index') }}">
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