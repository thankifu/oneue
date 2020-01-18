@extends('frontend.common.index')

@section('body')
<div class="star-main">
    <div class="container-fluid">
        <div class="row star-slides">
            <div class="swiper-container">
                <ul class="list-unstyled swiper-wrapper">
                    @foreach($slide as $item)
                    <li class="swiper-slide">
                        <a href="{{$item['url']}}" style="background-image:url({{$item['picture']}});">
                            <div class="star-title">{{$item['title']}}</div>
                            <div class="star-content">{{$item['subtitle']}}</div>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
    <div class="container star-floor">
        <div class="clearfix star-hd">
            <div class="pull-left">
                <a href="/product"><h2>商品</h2></a>
            </div>
            <div class="pull-right">
                <a href="/product">查看更多<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
            </div>
        </div>
        <div class="row star-bd">
            <ul class="list-unstyled star-list-product">
                @foreach($product as $item)
                <li class="col-md-2 col-xs-6">
                    <a href="/product/{{$item['id']}}" title="{{$item['name']}}">
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
        </div>
    </div>

    <div class="container star-floor">
        <div class="clearfix star-hd">
            <div class="pull-left">
                <a href="/article"><h2>文章</h2></a>
            </div>
            <div class="pull-right">
                <a href="/article">查看更多<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
            </div>
        </div>
        <div class="row star-bd">
            <ul class="list-unstyled star-list-article">
                @foreach($article as $item)
                <li class="col-md-4">
                    <a href="/article/{{$item['id']}}" title="{{$item['title']}}">
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
        </div>
    </div>

</div>
<!-- <div class="star-main">
    <div class="floor container">
    </div>
</div> -->
@endsection

@section('script')
<script type="text/javascript">
    var mySwiper1 = new Swiper ('.star-slides .swiper-container', {
        direction: 'horizontal', // 垂直切换选项
        loop: true, // 循环模式选项
    
        // 如果需要分页器
        pagination: {
        el: '.swiper-pagination',
        },
    });
</script>
@endsection
