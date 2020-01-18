@extends('frontend.common.index')

@section('style')
@endsection

@section('body')

<div class="container star-item-article star-mb-25">
	<ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li><a href="/help">帮助</a></li>
        <li class="active">{{$help['title']}}</li>
    </ol>
    <div class="row">
        <div class="col-md-9 star-main">
            <div class="star-info">
                <div class="star-title"><h1>{{$help['title']}}</h1></div>
                <div class="star-meta">
                    <span>{{$help['created']?date('Y-m-d H:i:s',$help['created']):'-'}}</span>
                </div>
                <div class="star-details">

                    {!!$help['content']!!}

                </div>
            </div>
        </div>

        @include('frontend.common.side')

	</div>
</div>

@endsection

@section('script')
@endsection