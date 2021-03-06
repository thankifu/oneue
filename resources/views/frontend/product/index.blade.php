@extends('frontend.common.index')

@section('body')
<div class="container star-mb-25">
	<ol class="breadcrumb">
		<li><a href="/">首页</a></li>
		@if(isset($category))
		<li><a href="/product">商品</a></li>
		<li class="active">{{$category['name']}}</li>
        @else
        <li class="active">商品</li>
		@endif
	</ol>
	<div class="row star-main">
		<ul class="clearfix list-unstyled star-list-product">
            @foreach($products as $item)
            <li class="col-md-3 col-xs-6">
                <a href="/product/{{$item['id']}}" title="{{$item['name']}}">
                    <p class="star-image">
                        <img src="/images/star-none.png" data-original="{{$item['picture']}}" alt="{{$item['name']}}"/>
                        <span class="star-heart{{$item['like'] == 1?' star-active':''}}" data-type='product' data-id="{{$item['id']}}" onclick="starLike(this);"><i class="glyphicon{{$item['like'] == 1?' glyphicon-heart':' glyphicon-heart-empty'}}" aria-hidden="true"></i></span>
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
        {{$page['pagination']}}
	</div>
</div>
@endsection