@extends('frontend.common.index')

@section('style')
@endsection

@section('body')
<div class="container star-item-article star-mb-25">
	<ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li><a href="/article">文章</a></li>
        @if($article['category_id'])
        <li><a href="/article/category/{{$article['category_id']}}">{{$article['category_name']}}</a></li>
        @endif
        <li class="active">{{$article['title']}}</li>
    </ol>
    <div class="row">
        <div class="col-md-9 star-main">
            {{csrf_field()}}
            <div class="star-info">
                <div class="star-title"><h1>{{$article['title']}}</h1></div>
                <div class="star-meta">
                    <span>{{$article['created']?date('Y-m-d H:i:s',$article['created']):'-'}}</span>
                </div>
                <div class="star-details">
                    {!!$article['content']!!}
                </div>
                <div class="star-actions">
                    <a class="star-heart{{$article['like'] == 1?' star-active':''}}" href="javascript:void(0);" data-type='article' data-id="{{$article['id']}}" onclick="starLike(this);">
                        <i class="glyphicon{{$article['like'] == 1?' glyphicon-heart':' glyphicon-heart-empty'}}" aria-hidden="true"></i>
                        <span>喜欢</span>
                    </a>
                </div>
            </div>
        </div>
        @include('frontend.common.side')
	</div>
</div>
@endsection

@section('script')
@endsection