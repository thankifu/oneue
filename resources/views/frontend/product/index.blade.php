@extends('frontend.common.index')

@section('body')

<div class="container star-mb-25">
	<ol class="breadcrumb">
		<li><a href="/">首页</a></li>
		@if(!isset($category))
		<li class="active">商品</li>
		@endif

		@if(isset($category))
		<li><a href="/product">商品</a></li>
		<li class="active">{{$category['name']}}</li>
		@endif
	</ol>
	<div class="row star-main">
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
	</div>
</div>

@endsection