<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>查看订单</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">
	<table class="table table-condensed star-table-text-left">
		<caption>基础信息</caption>
		<thead>
			<tr>
				<th>订单号</th>
				<th>用户</th>
				<th>下单时间</th>
				<th>付款时间</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{$order['no']}}</td>
				<td>{{isset($users[$order['user_id']])?$users[$order['user_id']]['username']:'-'}}</td>
				<td>{{$order['created']?date('Y-m-d H:i:s',$order['created']):'-'}}</td>
				<td>{{$order['prepaid']?date('Y-m-d H:i:s',$order['prepaid']):'-'}}</td>
			</tr>
		</tbody>
	</table>

	<table class="table table-condensed star-table-text-left">
		<caption>收货信息</caption>
		<thead>
			<tr>
				<th>收货人</th>
				<th>收货电话</th>
				<th>收货地址</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{$order['address_name']}}</td>
				<td>{{$order['address_phone']}}</td>
				<td>{{$order['address_content']}}</td>
			</tr>
		</tbody>
	</table>

	@if($products)
	<table class="table table-condensed star-table-text-left">
		<caption>商品信息</caption>
		<thead>
			<tr>
				<th width="10%">商品</th>
				<th>售价</th>
				<th>优惠</th>
				<th>单价</th>
				<th>数量</th>
				<th>运费</th>
				<th>小计</th>
			</tr>
		</thead>
		<tbody>
			@foreach($products as $item)
			<tr>
				<td colspan="7">{{$item['name']}}</td>
			</tr>
			<tr>
				<td style="border-top:0;">
					<span class="star-picture-square" style="background-image:url({{$item['picture']}});width:80px;height:80px;"></span>					
				</td>
				<td style="border-top:0;">&yen; {{$item['selling']}}</td>
				<td style="border-top:0;">- &yen; {{$item['vip_offer']}}</td>
				<td style="border-top:0;">&yen; {{$item['price']}}</td>
				<td style="border-top:0;">{{$item['quantity']}}</td>
				<td style="border-top:0;">-</td>
				<td style="border-top:0;">&yen; {{$item['subtotal']}}</td>
			</tr>
			@endforeach
		</tbody>
		<tbody style="border-top:0;">
			<tr>
				<td>合计</td>
				<td>&yen; {{$order['selling']}}</td>
				<td>- &yen; {{$order['vip_offer']}}</td>
				<td>&yen; {{$order['total']}}</td>
				<td>{{$order['quantity']}}</td>
				<td>&yen; {{$order['freight']}}</td>
				<td>&yen; {{$order['money']}}</td>
			</tr>
		</tbody>
	</table>
	@endif

	@if($order['shipped'])
	<table class="table table-condensed star-table-text-left">
		<caption>物流信息</caption>
		<thead>
			<tr>
				<th>快递公司</th>
				<th>快递单号</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{$order['express_name']}}</td>
				<td>{{$order['express_no']}}</td>
			</tr>
		</tbody>
	</table>
	@endif
	
</div>
@include('backend.common.foot')
</body>
</html>