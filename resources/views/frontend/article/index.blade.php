@extends('frontend.common.index')

@section('body')

<div class="container star-mb-25">
	<ol class="breadcrumb">
		<li><a href="/">首页</a></li>
		@if(!isset($category))
		<li class="active">图文</li>
		@endif

		@if(isset($category))
		<li><a href="/article">图文</a></li>
		<li class="active">{{$category['name']}}</li>
		@endif
	</ol>
	<div class="row star-main">
		<ul class="clearfix list-unstyled star-list-article">
            @foreach($lists as $item)
            <li class="col-md-4">
                <a href="/article/item/{{$item['id']}}.html" title="{{$item['title']}}">
                    <p class="star-image">
                        <img src="/images/none.png" data-original="{{$item['picture']}}?x-oss-process=image/resize,m_fill,w_600,h_320" alt="{{$item['title']}}" />
                        <span class="star-heart"><span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span></span>
                        <span class="star-views"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>{{$item['visit']}}</span>
                    </p>
                    <p class="star-title">{{$item['title']}}</p>
                    <p class="star-conte">{{str_limit(strip_tags($item['content']), $limit = 120, $end = '...')}}</p>
                </a>
            </li>
            @endforeach
        </ul>
        {{$links}}
	</div>
</div>

@endsection