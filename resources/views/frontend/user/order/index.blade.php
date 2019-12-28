@extends('frontend.common.index')

@section('style')
@endsection

@section('body')
<div class="container star-user star-mb-25">
    <ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li><a href="/user">用户中心</a></li>
        <li class="active">我的订单</li>
    </ol>
    <div class="row">

        <div class="col-md-3 star-side">
            @include('frontend.user.center')
        </div>

        <div class="col-md-9 star-main">
            <ul class="nav nav-tabs star-tabs" role="tablist">
                <li role="presentation" class="active"><a href="###" role="tab" data-toggle="tab">全部</a></li>
                <li role="presentation"><a href="###" role="tab" data-toggle="tab">待付款</a></li>
                <li role="presentation"><a href="###" role="tab" data-toggle="tab">待发货</a></li>
                <li role="presentation"><a href="###" role="tab" data-toggle="tab">待评价</a></li>
                <li role="presentation"><a href="###" role="tab" data-toggle="tab">退货退款</a></li>
                <li role="presentation"><a href="###" role="tab" data-toggle="tab">已完成</a></li>
            </ul>

            <div class="star-order">
                @if($lists)
                <ul class="list-unstyled">
                    @foreach($lists as $item)
                    <li data-order="">
                        <a href="/user/order/{{$item['id']}}">
                            <div class="star-hd">
                                <span class="star-number">订单编号：{{$item['no']}}</span>
                                <span class="star-state">
                                    @if($item['state']==1)<span>待付款</span>@endif
                                    @if($item['state']==2)<span style="color:#f36;">待发货</span>@endif
                                    @if($item['state']==3)<span style="color:#f36;">待收货</span>@endif
                                    @if($item['state']==4)<span style="color:#f36;">待评价</span>@endif
                                    @if($item['state']==-1)<span style="color:#f36;">已退款</span>@endif
                                    @if($item['state']==5)<span style="color:#2FAE3F;">已完成</span>@endif
                                </span>
                            </div>
                            <div class="star-bd star-trade">
                                <div class="star-products">
                                    <div class="star-bd">
                                        @if($item['products'])
                                        <dl>
                                            @foreach($item['products'] as $value)
                                            <dd>
                                                <div class="star-image">
                                                    <img src="{{$value['picture']}}"/>
                                                </div>
                                                <div class="star-title">{{$value['name']}}</div>
                                                <div class="star-price"><i>¥</i><span>{{$value['price']}}</span></div>
                                                <div class="star-quantity">
                                                    {{$value['quantity']}}
                                                </div>
                                                <div class="star-subtotal"><i>¥</i><span>{{$value['subtotal']}}</span></div>
                                            </dd>
                                            @endforeach
                                        </dl>
                                        @else
                                        <dl class="star-list-no">
                                            <dd>很单纯！没有商品</dd>
                                        </dl>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="star-ft">
                            <div class="star-total">共 {{$item['quantity']}} 件商品，合计：¥ {{$item['money']}}（含运费）</div>
                            <div class="star-clear"></div>
                            
                            @if($item['state']==1)
                            <a href="javascript:void(0);" class="payment" data-payment="" onclick="starPayment();">付款</a>
                            @endif
                            
                            @if($item['state']==2)
                            <a href="javascript:void(0);">商品备货中...</a>
                            @endif

                            @if($item['state']==3)
                            <a href="javascript:void(0);" class="received">确认收货</a>
                            <a href="javascript:void(0);">查看物流</a>
                            @endif

                            @if($item['state']==4)
                            <a href="javascript:void(0);">立即评价</a>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
                @else
                <ul class="star-list-no">
                    <li>很单纯！没有订单</li>
                </ul>
                @endif

                {{$links}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
function starAddressCreate(id){
    if( redirect_url !=null && redirect_url.toString().length>1 ) {
        window.location.href = '/user/address/'+id+'?redirect_url='+redirect_url;
    }else{
        window.location.href = '/user/address/'+id;
    }
}
function starPayment(){
    starToast('loading', '支付开发中', 0);
}
</script>
@endsection