<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>订单管理</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">
	<div class="clearfix star-mt-20 star-mb-20">
		<div class="pull-left">
			<form class="form-inline" method="get">
				<div class="form-group form-group-sm star-mr-10">
					<label for="no">订单号：</label>
					<input type="text" class="form-control" name="no" value="{{request()->get('no')}}" placeholder="请输入订单号">
				</div>
				<div class="form-group form-group-sm star-mr-10">
					<label for="state">状态：</label>
					<select class="form-control" id="state" name="state" autocomplete="off">
						<option value="">请选择</option>
						<option value="1" {{request()->get('state') == 1?'selected':''}}>待支付</option>
						<option value="2" {{request()->get('state') == 2?'selected':''}}>待发货</option>
						<option value="3" {{request()->get('state') == 3?'selected':''}}>待收货</option>
						<option value="4" {{request()->get('state') == 4?'selected':''}}>待评价</option>
						<option value="5" {{request()->get('state') == 5?'selected':''}}>完结</option>
					</select>
				</div>
				<button type="submit" class="btn btn-sm btn-default">查询</button>
			</form>
		</div>
		<div class="pull-right">
			
		</div>
	</div>

	{{csrf_field()}}
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th width="10"><input type="checkbox"/></th>
				<th>ID</th>
				<th>订单号</th>
				<th>用户</th>
				<th>数量</th>
				<th>售价</th>
				<th>优惠</th>
				<th>总价</th>
				<th>运费</th>
				<th>实付金额</th>
				<th>时间</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>
		@if($lists)
		<tbody>
			@foreach($lists as $item)
			<tr>
				<td width="10"><input type="checkbox"/></td>
				<td>{{$item['id']}}</td>
				<td>{{$item['no']}}</td>
				<td>{{isset($users[$item['user_id']])?$users[$item['user_id']]['username']:'-'}}</td>
				<td>{{$item['quantity']}}</td>
				<td>&yen; {{$item['selling']}}</td>
				<td>- &yen; {{$item['vip_offer']}}</td>
				<td>&yen; {{$item['total']}}</td>
				<td>&yen; {{$item['freight']}}</td>
				<td>&yen; {{$item['money']}}</td>
				<td>
					下单 {{$item['created']?date('Y-m-d H:i:s',$item['created']):'-'}}<br/>
					付款 {{$item['prepaid']?date('Y-m-d H:i:s',$item['prepaid']):'-'}}
				</td>
				<td>
					@if($item['state'] == 1)
					待支付
					@endif

					@if($item['state'] == 2)
					待发货
					@endif

					@if($item['state'] == 3)
					待收货
					@endif

					@if($item['state'] == 4)
					待评价
					@endif

					@if($item['state'] == 5)
					完结
					@endif
				</td>
				<td>
					<button type="button" class="btn btn-sm btn-primary" onclick="starItem('order', {{$item['id']}});">查看</button>
				</td>
			</tr>
			@endforeach
		</tbody>
		@endif
		@if(!$lists)
		<tbody>
			<tr>
				<td class="text-center" colspan="13">啊~没有诶！</td>
			</tr>
		</tbody>
		@endif
		<tfoot>
			<td width="10"><input type="checkbox"/></td>
			<td colspan="12">
				<div class="pull-left">
					<button class="btn btn-sm btn-default" disabled="disabled">禁用</button>
					<button class="btn btn-sm btn-default">启用</button>
				</div>
				<div class="pull-right">
					{{$links}}
				</div>
			</td>
		</tfoot>
	</table>

</div>
@include('backend.common.foot')
</body>
</html>