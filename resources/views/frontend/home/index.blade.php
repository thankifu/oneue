@extends('frontend.common.index')

@section('body')
<div class="container-fluid star-main">
    <div class="row star-slides">
        <div class="swiper-container">
            <ul class="list-unstyled swiper-wrapper">
                <li class="swiper-slide">
                    <a href="" style="background-image:url(https://www.oneue.com/images/slide-1.jpg);" title="">
                        <div class="star-title">欢迎光临</div>
                        <div class="star-content">精致生活、从ONEUE开始，给生活来一点不一样的色彩！</div>
                    </a>
                </li>
            </ul>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="container star-floor">
        <div class="clearfix star-hd">
            <div class="pull-left">
                <a href="{{route('product')}}"><h2>商品</h2></a>
            </div>
            <div class="pull-right">
                <a href="{{route('product')}}">查看更多<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
            </div>
        </div>
        <div class="row star-bd">
            <ul class="list-unstyled star-list-product">
                @foreach($product as $item)
                <li class="col-md-2 col-xs-6">
                    <a href="{{route('product.item',$item['id'])}}" title="{{$item['name']}}">
                        <p class="star-image">
                            <img src="/images/none.png" data-original="{{$item['picture']}}?x-oss-process=image/resize,m_fill,w_600,h_600" alt="{{$item['name']}}"/>
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
                <a href="{{route('article')}}"><h2>图文</h2></a>
            </div>
            <div class="pull-right">
                <a href="{{route('article')}}">查看更多<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
            </div>
        </div>
        <div class="row star-bd">
            <ul class="list-unstyled star-list-article">
                @foreach($article as $item)
                <li class="col-md-4">
                    <a href="{{route('article.item',$item['id'])}}" title="{{$item['title']}}">
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
