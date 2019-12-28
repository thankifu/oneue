@extends('frontend.common.index')

@section('style')
@endsection

@section('body')
<div class="container star-user star-mb-25">
    <ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li><a href="/user">用户中心</a></li>
        <li class="active">收货地址</li>
    </ol>
    <div class="row">

        <div class="col-md-3 star-side">
            @include('frontend.user.center')
        </div>

        <div class="col-md-9 star-main">
        	
        	<div class="star-trade">	
				<div class="star-address">
					<div class="star-hd">
						<span class="star-title">收货地址</span>
					</div>
					<div class="star-bd">
						<dl>
							<dd>
								<div class="star-text">
									<p><span class="star-name">{{$order['address_name']}}</span><span class="phone">{{$order['address_phone']}}</span></p>
									<p>{{$order['address_content']}}</p>
								</div>
							</dd>
						</dl>
					</div>
				</div>

				<div class="star-products">
					<div class="star-hd">
						<span class="star-title">商品明细</span>
					</div>
					<div class="star-bd">
						<dl>
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
					</div>
				</div>

				<div class="star-details">
					<div class="star-bd">
						<dl>
							<dt>商品数量</dt>
							<dd>{{$order['quantity']}} 件</dd>
						</dl>
						<dl>
							<dt>商品金额</dt>
							<dd>¥ {{$order['selling']}}</dd>
						</dl>

						@if($order['vip_offer'])
						<dl class="star-red">
							<dt>VIP优惠</dt>
							<dd>¥ - {{$order['vip_offer']}}</dd>
						</dl>
						@endif

						<dl>
							<dt>商品运费</dt>
							<dd>¥ {{$order['freight']}}</dd>
						</dl>
						<dl>
							<dt>支付金额</dt>
							<dd>¥ {{$order['money']}}</dd>
						</dl>
					</div>
				</div>

				<div class="star-details">
					<div class="star-hd">
						<span class="star-title">订单明细</span>
					</div>
					<div class="star-bd">
						<dl>
							<dt>订单编号</dt>
							<dd>{{$order['no']}}</dd>
						</dl>
						<dl>
							<dt>下单时间</dt>
							<dd>{{date('Y-m-d H:i:s', $order['created'])}}</dd>
						</dl>

						@if($order['prepaid'])
						<dl>
							<dt>付款时间</dt>
							<dd>{{date('Y-m-d H:i:s', $order['prepaid'])}}</dd>
						</dl>
						@endif

						@if($order['shipped'])
						<dl>
							<dt>发货时间</dt>
							<dd>{{date('Y-m-d H:i:s', $order['shipped'])}}</dd>
						</dl>
						@endif

						@if($order['received'])
						<dl>
							<dt>确认时间</dt>
							<dd>{{date('Y-m-d H:i:s', $order['received'])}}</dd>
						</dl>
						@endif

						@if($order['reviewed'])
						<dl>
							<dt>评价时间</dt>
							<dd>{{date('Y-m-d H:i:s', $order['reviewed'])}}</dd>
						</dl>
						@endif

						@if($order['refunded'])
						<dl>
							<dt>退款时间</dt>
							<dd>{{date('Y-m-d H:i:s', $order['refunded'])}}</dd>
						</dl>
						@endif

					</div>
				</div>

				@if($order['state'] >= 3)
				<div class="star-details" id="star-express">
					<div class="star-hd">
						<span class="star-title">物流明细（请复制单号到相应官网查询哦~）</span>
					</div>
					<div class="star-bd">
						<dl>
							<dt>物流公司</dt>
							<dd>{{$order['express_name']}}</dd>
						</dl>
						<dl>
							<dt>物流单号</dt>
							<dd>{{$order['express_no']}}</dd>
						</dl>
					</div>
				</div>
				@endif

			</div>

        </div>
    </div>
</div>
@endsection

@section('script')
@endsection