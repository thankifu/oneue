@extends('frontend.common.index')

@section('style')
@endsection

@section('body')

<div class="container star-user star-mb-25">
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