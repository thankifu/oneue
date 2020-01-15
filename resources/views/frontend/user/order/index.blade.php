@extends('frontend.common.index')

@section('style')
@endsection

@section('body')
<div class="container star-user star-mb-25">
    <ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li><a href="/user">用户中心</a></li>
        <li class="active">我购买的</li>
    </ol>
    <div class="row">

        <div class="col-md-3 star-side hidden-sm hidden-xs">
            @include('frontend.user.side')
        </div>

        <div class="col-md-9 star-main">
            <ul class="nav nav-tabs star-tabs" role="tablist">
                <li{!!!request()->get('state')?' class="active"':''!!}><a href="/user/order">全部</a></li>
                <li{!!request()->get('state') && request()->get('state') == 1?' class="active"':''!!}><a href="/user/order?state=1">待付款</a></li>
                <li{!!request()->get('state') && request()->get('state') == 2?' class="active"':''!!}><a href="/user/order?state=2">待发货</a></li>
                <li{!!request()->get('state') && request()->get('state') == 3?' class="active"':''!!}><a href="/user/order?state=3">待收货</a></li>
                <li{!!request()->get('state') && request()->get('state') == 5?' class="active"':''!!}><a href="/user/order?state=5">已完成</a></li>
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
                            <a href="javascript:void(0);" class="payment" data-payment="" onclick="starPayment({{$item['id']}});">付款</a>
                            @endif
                            
                            @if($item['state']==2)
                            <a href="javascript:void(0);">商品备货中...</a>
                            <a href="javascript:void(0);" onclick="starContact('refund');">申请退款</a>
                            @endif

                            @if($item['state']==3)
                            <a href="javascript:void(0);" class="received">确认收货</a>
                            <a href="javascript:void(0);">查看物流</a>
                            <a href="javascript:void(0);" onclick="starContact('refund');">申请退款</a>
                            @endif

                            @if($item['state']==5)
                            <a href="javascript:void(0);">查看详情</a>
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
</script>
@endsection