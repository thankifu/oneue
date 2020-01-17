@extends('frontend.common.index')

@section('style')

@endsection

@section('body')

<div class="container star-item-product">
	<ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li><a href="/product">商品</a></li>
        @if(isset($category))
        @if(!empty($category))
        <li><a href="/product/category/{{$category['id']}}">{{$category['name']}}</a></li>
        @endif
        <li class="active">{{$product['name']}}</li>
        @endif
    </ol>
    <div class="row">
        <div class="col-md-9 star-main">
            {{csrf_field()}}
            <div class="star-images">
                <div class="swiper-container gallery-top">
                    <ul class="list-unstyled swiper-wrapper">
                        <li class="swiper-slide"><img src="{{$product['picture']}}"></li>
                        @if($pictures)
                        @foreach($pictures as $item)
                        <li class="swiper-slide"><img src="{{$item['picture']}}"></li>
                        @endforeach
                        @endif
                    </ul>
                </div>
                <div class="swiper-container gallery-thumbs">
                    <ul class="list-unstyled swiper-wrapper">
                        <li class="swiper-slide"><img src="{{$product['picture']}}"></li>
                        @if($pictures)
                        @foreach($pictures as $item)
                        <li class="swiper-slide"><img src="{{$item['picture']}}"></li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <div class="star-info">
                <div class="star-title"><h1>{{$product['name']}}</h1></div>
                <div class="star-price">
                @if($product['quantity'] != 0)
                    <span class="star-normal" data-selling="{{$product['selling']}}" data-price="{{$product['price']}}">
                        <i>¥</i>
                        <em>{{$product['price']}}</em>

                        <!-- @if($product['price'] != $product['selling'])
                        <del>[{{$product['selling']}}]</del>
                        @endif -->

                        @if(isset($level['name']))
                        <strong>{{$level['name']}}</strong>
                        @endif
                    </span>
                    @if($product['market'] > $product['selling'])
                    <span class="star-line-through" data-market="{{$product['market']}}">
                        <i>¥</i>
                        <em>{{$product['market']}}</em>
                    </span>
                    @endif
                @else
                    <span>已下架</span>
                @endif
                </div>

            @if($product['quantity'] != 0)
                <div class="clearfix star-meta star-meta-volume">
                    <div class="star-meta-hd">销量</div>
                    <div class="star-meta-bd">
                        <div class="star-meta-text">{{$product['volume']}}</div>
                    </div>
                </div>

                @if($specifications)
                <div class="clearfix star-meta star-meta-specifications">
                    <div class="star-meta-hd">规格</div>
                    <div class="star-meta-bd">
                        <div class="star-meta-spec">
                            <ul class="list-unstyled">
                                @foreach($specifications as $item)
                                <li class="{{$item['quantity']==0?'star-disable':'star-normal'}}" data-product="{{$item['product_id']}}" data-specification="{{$item['id']}}" data-market="{{$item['market']}}" data-selling="{{$item['selling']}}" data-price="{{$item['price']}}" data-quantity="{{$item['quantity']}}">
                                    @if($item['picture'] != "")
                                    <img src="{{$item['picture']}}" alt="{{$item['name']}}" title="{{$item['name']}}">
                                    @endif
                                    <span>{{$item['name']}}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @else
                <div class="clearfix star-meta star-meta-specifications" style="display:none">
                    <div class="star-meta-hd">规格</div>
                    <div class="star-meta-bd">
                        <div class="star-meta-spec">
                            <ul class="list-unstyled">
                                <li class="star-normal star-current" data-product="{{$product['id']}}" data-specification="0" data-price="{{$product['price']}}" data-quantity="{{$product['quantity']}}">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <div class="clearfix star-meta star-meta-quantity">
                    <div class="star-meta-hd">数量</div>
                    <div class="star-meta-bd">
                        <div class="star-meta-quan">
                            <span class="star-del disabled"><i class="glyphicon glyphicon-minus" aria-hidden="true"></i></span>
                            <input class="star-num" type="text" value="1" readonly/>
                            <span class="star-add"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
            @endif

                <div class="clearfix star-actions">
                @if($product['quantity'] != 0)
                    <a class="star-buy-now" href="javascript:void(0);" onclick="starBuyNow()">立即购买</a>
                    <a class="star-add-cart" href="javascript:void(0);" onclick="starAddToCart()"><i class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></i>加入购物车</a>
                @else
                    <a class="star-buy-now-disable" href="javascript:void(0);">立即购买</a>
                    <a class="star-add-cart-disable" href="javascript:void(0);"><i class="fa fa-shopping-cart" aria-hidden="true"></i>加入购物车</a>
                @endif
                    <div class="star-clear"></div>
                    <a class="star-heart{{$like == 1?' star-active':''}}" href="javascript:void(0);" data-type='product' data-id="{{$product['id']}}" onclick="starLike(this);"><i class="glyphicon{{$like == 1?' glyphicon-heart':' glyphicon-heart-empty'}}" aria-hidden="true"></i><span>喜欢</span></a>
                </div>
            </div>

            <div class="star-clear"></div>

            <ul class="nav nav-tabs star-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">商品详情</a></li>
                <!-- <li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">商品评价 <span class="badge">42</span></a></li> -->
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="details">
                    @if ($product['description'])
                    <div class="star-details">
                        {!!$product['description']!!}
                    </div>
                    @endif
                </div>
                <!-- <div role="tabpanel" class="tab-pane" id="reviews">...</div> -->
            </div>
            
        </div>

        @include('frontend.common.side')

	</div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    var galleryThumbs = new Swiper('.gallery-thumbs', {
        spaceBetween: 20,
        slidesPerView: 5,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    var galleryTop = new Swiper('.gallery-top', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: galleryThumbs
        }
    });

    function starCheckQuantity() {
        var then = $(".star-num");
        var num = then.val();
        var ex = /^\d+$/;
        if (!ex.test(num)) {
            then.val("1");
            num = 1;
        }else{
            num = parseInt(num);
        }

        var quantity = parseInt( $(".star-meta-specifications ul li[class='star-normal star-current']").attr("data-quantity") );
        
        if ( quantity == "NaN") {
            return false;
        }

        if ( quantity == 1 ) {
            then.val(quantity);
            if ( !then.prev().hasClass("star-disabled") ) {
                then.prev().addClass("star-disabled");
            }
            if ( !then.next().hasClass("star-disabled") ) {
                then.next().addClass("star-disabled");
            }
            return false;
        }else{
            if( num >= quantity ){
                then.val(quantity);
                if ( then.prev().hasClass("star-disabled") ) {
                    then.prev().removeClass("star-disabled");
                }
                if ( !then.next().hasClass("star-disabled") ) {
                    then.next().addClass("star-disabled");
                }
                return false;
            } else if ( num == 1 ) {
                if ( !then.prev().hasClass("star-disabled") ) {
                    then.prev().addClass("star-disabled");
                }
                if ( then.next().hasClass("star-disabled") ) {
                    then.next().removeClass("star-disabled");
                }
                return false;
            }else{
                if ( then.prev().hasClass("star-disabled") ) {
                    then.prev().removeClass("star-disabled");
                }
                if ( then.next().hasClass("star-disabled") ) {
                    then.next().removeClass("star-disabled");
                }
                return false;
            }
        }
    }

    function starBuyNow(){
        if(starShopping == '0'){
            starContact('shopping');
            return;
        }
        var thisis = $(".star-item-product .star-meta-specifications ul li[class='star-normal star-current']");

        var data = new Object();
        data._token = $('input[name="_token"]').val();
        data.product = thisis.attr("data-product");
        data.specification = thisis.attr("data-specification");
        data.quantity = $('.star-item-product .star-meta-quantity .star-num').val();

        if( thisis.length == 0 ){
            starToast('fail', '请选择商品规格');
            return false;
        }else{
            $.ajax({
                type:'POST',
                url:'/checkout/create',
                data:data, 
                dataType:'json',
                timeout:10000,
                success:function(res,status){
                    if(res.code === 200){
                        window.location.href = '/checkout';
                        return false;
                    }else{
                        starToast("fail", res.text);
                    }
                },
                error:function(XMLHttpRequest,textStatus,errorThrown){
                    //console.log(errorThrown);
                    if(textStatus==='timeout'){
                        starToast("fail", '请求超时');
                        setTimeout(function(){
                            starToast("fail", '重新请求');
                        },2000);
                    }
                    if(errorThrown==='Too Many Requests'){
                        starToast("fail", '尝试次数太多，请稍后再试');
                    }
                    if(errorThrown==='Unauthorized'){
                        starToast("fail", '请先登录');
                        setTimeout(function(){
                            window.location.href = '/login';
                        },1000);
                    }
                }
            });
        }
    };

    function starAddToCart(){
        if(starShopping == '0'){
            starContact('shopping');
            return;
        }

        var thisis = $(".star-item-product .star-meta-specifications ul li[class='star-normal star-current']");

        var data = new Object();
        data._token = $('input[name="_token"]').val();
        data.product = thisis.attr("data-product");
        data.specification = thisis.attr("data-specification");
        data.quantity = $('.star-item-product .star-meta-quantity .star-num').val();

        if( thisis.length == 0 ){
            starToast('fail', '请选择商品规格');
            return false;
        }else{
            $.ajax({
                type:'POST',
                url:'/cart/create',
                data:data, 
                dataType:'json',
                timeout:10000,
                success:function(res,status){
                    if(res.code === 200){
                        $('.star-header-cart .star-count').text(Number($('.star-header-cart .star-count').text())+Number(data.quantity));
                        starToast('success', res.text);
                        return false;
                    }else{
                        starToast("fail", res.text);
                    }
                },
                error:function(XMLHttpRequest,textStatus,errorThrown){
                    //console.log(errorThrown);
                    if(textStatus==='timeout'){
                        starToast("fail", '请求超时');
                        setTimeout(function(){
                            starToast("fail", '重新请求');
                        },2000);
                    }
                    if(errorThrown==='Too Many Requests'){
                        starToast("fail", '尝试次数太多，请稍后再试');
                    }
                    if(errorThrown==='Unauthorized'){
                        starToast("fail", '请先登录');
                        setTimeout(function(){
                            window.location.href = '/login';
                        },1000);
                    }
                }
            });
        }
        
    };

    $(document).ready(function() {

        $(".star-meta-specifications ul li[class='star-normal']").on('click',function(){

            var market = $(this).attr("data-market");
            var selling = $(this).attr("data-selling");
            var price = $(this).attr("data-price");
            var picture = $(this).find("img").attr("src");

            if ( !$(this).hasClass('star-current') ) {
                
                $(this).addClass("star-current").siblings().removeClass("star-current");

                $(".star-info .star-price .star-normal em").text(price);
                $(".star-info .star-price .star-normal del").text('['+selling+']');
                $(".star-info .star-price .star-line-through em").text(market);

                $(".star-images .gallery-top li").eq(0).find("img").attr("src", picture);
                galleryTop.slideTo(0);

                starCheckQuantity();

            } else {
                
                $(this).removeClass("star-current");
                $(".star-info .star-price .star-normal em").text( $(".star-info .star-price .star-normal").attr('data-price') );
                $(".star-info .star-price .star-normal del").text( $(".star-info .star-price .star-normal").attr('data-selling') );
                $(".star-info .star-price .star-line-through em").text( $(".star-info .star-price .star-line-through").attr('data-market') );
            }

        });

        $(".star-num").on("change",function(){
            starCheckQuantity();
        });

        $('.star-add').click(function(){
            var quantity = $(".star-meta-specifications ul li[class='star-normal star-current']").attr("data-quantity");
            if ( quantity == 1 ) {
                if ( !$(this).hasClass("star-disabled") ) {
                    $(this).addClass("star-disabled");
                }

                if ( !$(this).prev().prev().hasClass("star-disabled") ) {
                    $(this).prev().prev().addClass("star-disabled");
                }
                return false;
            }

            var n=$(this).prev().val();
            if( n == quantity-1 ){
                $(this).addClass("star-disabled");
            }

            var num=parseInt(n)+1;
            if ( num > 1) {
                $(this).prev().prev().removeClass("star-disabled");
            }
            if( num > quantity ){
                return false;
            }
            $(this).prev().val(num);
        });

        $('.star-del').click(function(){
            var quantity = $(".star-meta-specifications ul li[class='star-normal star-current']").attr("data-quantity");
            if ( quantity == 1 ) {
                if ( !$(this).hasClass("star-disabled") ) {
                    $(this).addClass("star-disabled");
                }

                if ( !$(this).next().next().hasClass("star-disabled") ) {
                    $(this).next().next().addClass("star-disabled");
                }
                return false;
            }

            var n=$(this).next().val();
            if(n==2){
                $(this).addClass("star-disabled");
            }
            
            var num=parseInt(n)-1;
            $(this).next().next().removeClass("star-disabled");
            if (num==0) {
                $(this).addClass("star-disabled");
                return;
            }
            $(this).next().val(num);
        });

        

        
    });
</script>
@endsection