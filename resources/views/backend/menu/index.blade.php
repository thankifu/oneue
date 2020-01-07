<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>后台菜单</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">
	<div class="clearfix star-mt-20 star-mb-20">
		<div class="pull-left">
			
		</div>
		<div class="pull-right">
			@if($parent)
			<button type="button" class="btn btn-sm btn-default" onclick="starGoto('menu', {{$back_id}});">返回上一级</button>
			@endif
			<button type="button" class="btn btn-sm btn-primary" onclick="starItem('menu', 0, {{$parent}});">新增</button>
		</div>
	</div>
	{{csrf_field()}}
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th width="10"><input type="checkbox"/></th>
				<th>ID</th>
				<th>排序</th>
				<th>菜单名称</th>
				<th>控制器</th>
				<th>方法</th>
				<th>修改时间</th>
				<th>隐藏</th>
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
				<td>{{$item['position']}}</td>
				<td>{{$item['name']}}</td>
				<td>{{$item['controller']}}</td>
				<td>{{$item['action']}}</td>
				<td>{{$item['modified']?date('Y-m-d H:i:s',$item['modified']):'-'}}</td>
				<td>{{$item['hidden']?'是':'否'}}</td>
				<td>{!!$item['state']==1?'<span class="label label-success">启用</span>':'<span class="label label-danger">禁用</span>'!!}</td>
				<td>
					<button type="button" class="btn btn-sm btn-default" onclick="starGoto('menu', {{$item['id']}});">子菜单</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="starItem('menu', {{$item['id']}}, {{$parent}});">编辑</button>
					<button type="button" class="btn btn-sm btn-secondary" onclick="starDelete('menu', {{$item['id']}});">删除</button>
				</td>
			</tr>
			@endforeach
		</tbody>
		@endif
		@if(!$lists)
		<tbody>
			<tr>
				<td class="text-center" colspan="10">啊~没有诶！</td>
			</tr>
		</tbody>
		@endif
		<tfoot>
			<td width="10"><input type="checkbox"/></td>
			<td colspan="9">
				<div class="pull-left">
					<button class="btn btn-sm btn-default" disabled="disabled">禁用</button>
					<button class="btn btn-sm btn-default">启用</button>
				</div>
				<div class="pull-right">
					
				</div>
			</td>
		</tfoot>
	</table>

</div>
@include('backend.common.foot')
</body>
</html>