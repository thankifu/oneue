<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>商品管理</title>
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
					<label for="username">名称：</label>
					<input type="text" class="form-control" name="name" value="{{request()->get('name')}}" placeholder="请输入商品名称">
				</div>
				<div class="form-group form-group-sm star-mr-10">
					<label for="category_id">分类：</label>
					<select class="form-control" id="category_id" name="category_id" autocomplete="off">
						<option value="0">请选择</option>
						@foreach($categories as $item)
						<option value="{{$item['id']}}" {{request()->get('category_id') == $item['id']?'selected':''}}>{{$item['name']}}</option>
						@endforeach
					</select>
				</div>
				<button type="submit" class="btn btn-sm btn-default">查询</button>
			</form>
		</div>
		<div class="pull-right">
			<button type="button" class="btn btn-sm btn-primary" onclick="starShowJump('product');">新增</button>
		</div>
	</div>

	{{csrf_field()}}
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th class="star-text-center">ID</th>
				<th>图片</th>
				<th>名称</th>
				<th>规格</th>
				<th>市场价</th>
				<th>销售价</th>
				<th>成本价</th>
				<th>库存数量</th>
				<th>分类</th>
				<th>时间</th>
				<th class="star-text-center">状态</th>
				<th>操作</th>
			</tr>
		</thead>
		@if($lists)
		<tbody>
			@foreach($lists as $item)
			<?php //echo '<pre>'; print_r($specifications);?>
			<tr>
				<td class="star-text-center">{{$item['id']}}</td>
				<td>
					<span class="star-picture-square" style="background-image:url({{$item['picture']}});"></span>
				</td>
				<td>{{$item['name']}}</td>
				<td>
					@if($item['specifications'])
					@foreach($item['specifications'] as $value)
						{{$value['name']}}<br/>
					@endforeach
					@endif
					@if(!$item['specifications'])
						-
					@endif
				</td>
				<td>
					@if($item['specifications'])
					@foreach($item['specifications'] as $value)
						{{$value['market']}}<br/>
					@endforeach
					@endif

					@if(!$item['specifications'])
						{{$item['market']}}
					@endif
				</td>
				<td>
					@if($item['specifications'])
					@foreach($item['specifications'] as $value)
						{{$value['selling']}}<br/>
					@endforeach
					@endif

					@if(!$item['specifications'])
						{{$item['selling']}}
					@endif
				</td>
				<td>
					@if($item['specifications'])
					@foreach($item['specifications'] as $value)
						{{$value['cost']}}<br/>
					@endforeach
					@endif

					@if(!$item['specifications'])
						{{$item['cost']}}
					@endif
				</td>
				<td>
					@if($item['specifications'])
					@foreach($item['specifications'] as $value)
						{{$value['quantity']}}<br/>
					@endforeach
					@endif

					@if(!$item['specifications'])
						{{$item['quantity']}}
					@endif
				</td>
				<td>{{isset($categories[$item['category_id']])?$categories[$item['category_id']]['name']:''}}</td>
				<td>
					创建 {{$item['created']?date('Y-m-d H:i:s',$item['created']):'-'}}<br/>
					修改 {{$item['modified']?date('Y-m-d H:i:s',$item['modified']):'-'}}
				</td>
				<td class="star-text-center">{!!$item['state']==1?'<span class="label label-success">启用</span>':'<span class="label label-danger">禁用</span>'!!}</td>
				<td width="160">
					<button type="button" class="btn btn-sm btn-primary" onclick="starShowJump('product', {{$item['id']}});">编辑</button>
					<button type="button" class="btn btn-sm btn-secondary" onclick="starDelete('product', {{$item['id']}});">删除</button>
				</td>
			</tr>
			@endforeach
		</tbody>
		@endif
		@if(!$lists)
		<tbody>
			<tr>
				<td class="text-center" colspan="12">没有数据</td>
			</tr>
		</tbody>
		@endif
		<tfoot>
			<td colspan="12">
				<div class="pull-left">
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