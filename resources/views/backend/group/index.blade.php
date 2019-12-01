<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>管理组</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid">
	<div class="clearfix sl-mt-20 sl-mb-20">
		<div class="pull-left">
			<form class="form-inline" method="get">
				<div class="form-group sl-mr-20">
					<label for="name">管理组名：</label>
					<input type="text" class="form-control" name="name" value="{{request()->get('name')}}" placeholder="请输入管理组名">
				</div>
				
				<button type="submit" class="btn btn-default">查询</button>
			</form>
		</div>
		<div class="pull-right">
			<button type="button" class="btn sl-button-primary" onclick="slAdd('group', 0);">新增</button>
		</div>
	</div>

	{{csrf_field()}}
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th width="10"><input type="checkbox"/></th>
				<th>ID</th>
				<th>管理组名</th>
				<th>创建时间</th>
				<th>修改时间</th>
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
				<td>{{$item['name']}}</td>
				<td>{{$item['created']?date('Y-m-d H:i:s',$item['created']):'-'}}</td>
				<td>{{$item['modified']?date('Y-m-d H:i:s',$item['modified']):'-'}}</td>
				<td>{!!$item['state']==1?'<span class="sl-green">启用</span>':'<span class="sl-red">禁用</span>'!!}</td>
				<td>
					<button type="button" class="btn btn-sm sl-button-primary" onclick="slAdd('group', {{$item['id']}});">修改</button>
				</td>
			</tr>
			@endforeach
		</tbody>
		@endif
		@if(!$lists)
		<tbody>
			<tr>
				<td class="text-center" colspan="7">啊~没有诶！</td>
			</tr>
		</tbody>
		@endif
		<tfoot>
			<td width="10"><input type="checkbox"/></td>
			<td colspan="7">
				<div class="pull-left">
					<button class="btn btn-sm" disabled="disabled">禁用</button>
					<button class="btn btn-sm">启用</button>
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