@extends('frontend.common.index')

@section('body')

<div class="container star-mb-25">
	<ol class="breadcrumb">
		<li><a href="/">首页</a></li>
		<li class="active">搜索</li>
	</ol>
	<div class="star-main">
        <ul class="nav nav-tabs star-tabs star-mb-25" role="tablist">
            <li{!!request()->path() == 'search' || request()->path() == 'search/product'?' class="active"':''!!}><a href="/search/product{{request()->get('keyword')?'?keyword='.request()->get('keyword'):''}}">商品</a></li>
            <li{!!request()->path() == 'search/article'?' class="active"':''!!}><a href="/search/article{{request()->get('keyword')?'?keyword='.request()->get('keyword'):''}}">文章</a></li>
        </ul>
        
        @if(request()->path() == 'search' || request()->path() == 'search/product')
        <div class="row">
            @if($lists)
            <ul class="clearfix list-unstyled star-list-product">
                @foreach($lists as $item)
                <li class="col-md-3 col-xs-6">
                    <a href="{{route('product.item',$item['id'])}}" title="{{$item['name']}}">
                        <p class="star-image">
                            <img src="/images/star-none.png" data-original="{{$item['picture']}}" alt="{{$item['name']}}"/>
                            <span class="star-heart"><span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span></span>
                        </p>
                        <p class="star-title">{{$item['name']}}</p>
                        <p class="star-price">
                            <span class="star-normal"><i>¥</i><em>{{$item['price']}}</em></span>
                            <span class="star-line-through"><i>¥</i><em>{{$item['market']}}</em></span>
                        </p>
                    </a>
                </li>
                @endforeach
            </ul>
            {{$links}}
            @else
            <ul class="star-list-no">
                <li>没有搜索到~</li>
            </ul>
            @endif
        </div>
        @else
        <div class="row">
            @if($lists)
            <ul class="clearfix list-unstyled star-list-article">
                @foreach($lists as $item)
                <li class="col-md-4">
                    <a href="{{route('article.item',$item['id'])}}" title="{{$item['title']}}">
                        <p class="star-image">
                            <img src="/images/star-none.png" data-original="{{$item['picture']}}" alt="{{$item['title']}}" />
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
            @else
            <ul class="star-list-no">
                <li>没有搜索到~</li>
            </ul>
            @endif
        </div>
        @endif
	</div>
</div>

@endsection