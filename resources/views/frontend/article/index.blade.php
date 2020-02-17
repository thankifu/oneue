@extends('frontend.common.index')

@section('body')
<div class="container star-mb-25">
	<ol class="breadcrumb">
		<li><a href="/">首页</a></li>
		@if(isset($category))
		<li><a href="/article">文章</a></li>
		<li class="active">{{$category['name']}}</li>
        @else
        <li class="active">文章</li>
		@endif
	</ol>
	<div class="row star-main">
		<ul class="clearfix list-unstyled star-list-article">
            @foreach($articles as $item)
            <li class="col-md-4">
                <a href="/article/{{$item['id']}}" title="{{$item['title']}}">
                    <p class="star-image">
                        <img src="/images/star-none.png" data-original="{{$item['picture']}}" alt="{{$item['title']}}" />
                        <span class="star-heart{{$item['like'] == 1?' star-active':''}}" data-type='article' data-id="{{$item['id']}}" onclick="starLike(this);"><i class="glyphicon{{$item['like'] == 1?' glyphicon-heart':' glyphicon-heart-empty'}}" aria-hidden="true"></i></span>
                        <span class="star-views"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>{{$item['visit']}}</span>
                    </p>
                    <p class="star-title">{{$item['title']}}</p>
                    <p class="star-conte">{{str_limit(strip_tags($item['content']), $limit = 120, $end = '...')}}</p>
                </a>
            </li>
            @endforeach
        </ul>
        {{$page['pagination']}}
	</div>
</div>
@endsection