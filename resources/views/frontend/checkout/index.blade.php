@extends('frontend.common.index')

@section('body')

<div class="container star-checkout star-mb-25">
	<ol class="breadcrumb">
		<li><a href="/">首页</a></li>
		<li class="active">结算</li>
	</ol>

    <div class="row star-trade">
        <div class="col-md-9">
            @if($address)
    		<div class="star-address" data-address="">
                <div class="star-bd">
                    <dl>
                        <dt>收货地址</dt>
                        <dd>
                            <a href="javascript:void(0);" onclick="starAddressSelect();">
                                <div class="star-text">
                                    <p><span class="star-name">{{$address['name']}}</span><span class="star-phone">{{$address['phone']}}</span></p>
                                    <p>{{$address['content']}}</p>
                                </div>
                                <div class="star-icon">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                </div>
                            </a>
                        </dd>
                    </dl>
                </div>
            </div>
            @else
            <div class="star-address" data-address="0">
                <div class="star-bd">
                    <dl>
                        <dt>收货地址</dt>
                        <dd>
                            <a href="javascript:void(0);" onclick="starAddressSelect();" style="width:100%;display:block;">+ 请先添加收货信息</a>
                        </dd>
                    </dl>
                </div>
            </div>
            @endif

            <div class="star-products">
                <div class="star-bd">
                    @if($products)
                    <dl>
                        <dt class="hidden-sm hidden-xs">
                            <span>商品信息</span>
                            <span>价格</span>
                            <span>数量</span>
                            <span>小计</span>
                        </dt>
                        @foreach($products as $item)
                        <dd data-product="" data-specification="">
                            <div class="star-image">
                                <img src="{{$item['picture']}}"/>
                            </div>
                            <div class="star-title">{{$item['name']}}</div>
                            <div class="star-price"><i>¥</i><span>{{$item['price']}}</span></div>
                            <div class="star-quantity">
                                {{$item['quantity']}}
                            </div>
                            <div class="star-subtotal"><i>¥</i><span>{{$item['subtotal']}}</span></div>
                        </dd>
                        @endforeach
                    </dl>
                    @else
                    <dl class="star-list-no">
                        <dd>您米有商品哦~<br/><a href="/product" class="btn btn-xs btn-primary">去逛逛</a></dd>
                    </dl>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="star-details">
                <div class="star-bd">
                    <dl>
                        <dt>商品数量</dt>
                        <dd>{{$checkout['quantity']}}件</dd>
                    </dl>
                    <dl>
                        <dt>商品金额</dt>
                        <dd>¥ {{$checkout['selling']}}</dd>
                    </dl>

                    
                    <dl class="star-red">
                        <dt>VIP优惠</dt>
                        <dd>¥ - {{$checkout['vip_offer']}}</dd>
                    </dl>
                    

                    <dl>
                        <dt>商品运费</dt>
                        <dd>¥ {{$checkout['freight']}}</dd>
                    </dl>
                    <dl>
                        <dt>支付金额</dt>
                        <dd>¥ {{$checkout['money']}}</dd>
                    </dl>
                </div>
            </div>

            <div class="star-payments">
                <div class="star-bd">
                    <!-- <dl class="star-current" data-payment="alipay" onclick="starPaymentType(this);">
                        <dt><i class="glyphicon glyphicon-record" aria-hidden="true"></i><span>支付宝</span><img src="/images/star-logo-alipay.png"></dt>
                        <dd>熟悉的支付宝，安全的保证，你懂的。</dd>
                    </dl> -->
                    <dl class="star-current" data-payment="wxpay" onclick="starPaymentType(this);">
                        <dt><i class="glyphicon glyphicon-record" aria-hidden="true"></i><span>微信支付</span><img src="/images/star-logo-wxpay.png"></dt>
                        <dd>熟悉的微信，快捷的支付，你懂的。</dd>
                    </dl>
                    
                </div>
            </div>
            
            <div class="star-actions">
                <button type="button" class="btn btn-lg btn-block btn-primary" onclick="starPlaceOrder();">下　单</button>
            </div>

        </div>

	</div>

</div>

@endsection

@section('script')
<script type="text/javascript">
    function starAddressSelect(){
        window.location.href = '/user/address?redirect_url='+encodeURI(window.location.href);
    }
    function starPaymentType(object){
        $(object).addClass("star-current").siblings().removeClass("star-current");
        var payment = $(object).attr('data-payment');
        $('.actions button').attr('data-payment', payment);
    };
    function starPlaceOrder(){
        starToast('loading', '请稍后...', 0);
        var data = new Object();
        data._token = $('input[name="_token"]').val();
        data.payment = $('.actions button').attr('data-payment');

        $.post('/order/create',data,function(res){
            if(res.code === 200){
                bootbox.hideAll();
                //window.location.href = '/checkout';
                //starToast('loading', '支付开发中', 0);
                starPayment(res.data.id);
                return false;
            }else{
                bootbox.hideAll();
                starToast('fail', res.text);
            }
        },'json');
    };

    $(window).load(function(){
        $('.actions button').attr('data-payment', $('.star-payments .star-bd').find('.star-current').attr('data-payment'));
    });
</script>
@endsection