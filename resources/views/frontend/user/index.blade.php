@extends('frontend.common.index')

@section('style')
@endsection

@section('body')

<div class="container star-user star-mb-25">
	<form id="upload_form" target="upload_iframe" enctype="multipart/form-data" action="/admin/upload/index" method="post" style="display:none;">
        {{csrf_field()}}
        <input type="file" name="upload_file" id="upload_file" onchange="starUpload()">
        <input type="hidden" name="upload_place" id="upload_place" value="">
        <iframe name="upload_iframe" id="upload_iframe" style="display: none;"></iframe>
    </form>
    <ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li class="active">用户中心</li>
    </ol>
    <div class="row">

        <div class="col-md-3 star-side">
            @include('frontend.user.side')
        </div>

        <div class="col-md-9 star-main">
            
        </div>

	</div>
</div>

@endsection

@section('script')
@endsection