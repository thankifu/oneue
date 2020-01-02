<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>管理员</title>
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
					<label for="username">用户名：</label>
					<input type="text" class="form-control" name="username" value="{{request()->get('username')}}" placeholder="请输入用户名">
				</div>
				<div class="form-group form-group-sm star-mr-10">
					<label for="name">真实姓名：</label>
					<input type="text" class="form-control" name="name" value="{{request()->get('name')}}" placeholder="请输入真实姓名">
				</div>
				<div class="form-group form-group-sm star-mr-10">
					<label for="group_id">管理组：</label>
					<select class="form-control" id="group_id" name="group_id" autocomplete="off">
						<option value="0">请选择</option>
						@foreach($groups as $item)
						<option value="{{$item['id']}}" {{request()->get('group_id') == $item['id']?'selected':''}}>{{$item['name']}}</option>
						@endforeach
					</select>
				</div>
				<button type="submit" class="btn btn-sm btn-default">查询</button>
			</form>
		</div>
		<div class="pull-right">
			<button type="button" class="btn btn-sm btn-primary" onclick="starItem('admin');">新增</button>
		</div>
	</div>
	
	{{csrf_field()}}
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th width="10"><input type="checkbox"/></th>
				<th>ID</th>
				<th>用户名</th>
				<th>真实姓名</th>
				<th>分组</th>
				<th>最后登录时间</th>
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
				<td>{{$item['username']}}</td>
				<td>{{$item['name']}}</td>
				<td>{{isset($groups[$item['group_id']])?$groups[$item['group_id']]['name']:''}}</td>
				<td>{{$item['logined']?date('Y-m-d H:i:s',$item['logined']):'-'}}</td>
				<td>{!!$item['state']==1?'<span class="label label-success">启用</span>':'<span class="label label-danger">禁用</span>'!!}</td>
				<td>
					<button type="button" class="btn btn-sm btn-primary" onclick="starItem('admin', {{$item['id']}});">编辑</button>
					<button type="button" class="btn btn-sm btn-danger" onclick="starDelete('admin', {{$item['id']}});">删除</button>
				</td>
			</tr>
			@endforeach
		</tbody>
		@endif
		@if(!$lists)
		<tbody>
			<tr>
				<td class="text-center" colspan="8">啊~没有诶！</td>
			</tr>
		</tbody>
		@endif
		<tfoot>
			<td width="10"><input type="checkbox"/></td>
			<td colspan="7">
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