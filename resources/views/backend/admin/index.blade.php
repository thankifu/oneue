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
<div class="container-fluid">
	
	<div class="clearfix sl-mt-20 sl-mb-20">
		<div class="pull-left">
			<form class="form-inline" method="get">
				<div class="form-group sl-mr-20">
					<label for="username">用户名：</label>
					<input type="text" class="form-control" name="username" value="{{request()->get('username')}}" placeholder="请输入用户名">
				</div>
				<div class="form-group sl-mr-20">
					<label for="name">真实姓名：</label>
					<input type="text" class="form-control" name="name" value="{{request()->get('name')}}" placeholder="请输入真实姓名">
				</div>
				<div class="form-group sl-mr-20">
					<label for="group_id">管理组：</label>
					<select class="form-control" id="group_id" name="group_id" autocomplete="off">
						<option value="0">请选择</option>
						@foreach($groups as $group)
						<option value="{{$group['id']}}" {{request()->get('group_id') == $group['id']?'selected':''}}>{{$group['name']}}</option>
						@endforeach
					</select>
				</div>
				<button type="submit" class="btn btn-default">查询</button>
			</form>
		</div>
		<div class="pull-right">
			<button type="button" class="btn sl-button-primary" onclick="slAdd('admin', 0);">新增</button>
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
				<td>{!!$item['state']==1?'<span class="sl-green">启用</span>':'<span class="sl-red">禁用</span>'!!}</td>
				<td>
					<button type="button" class="btn btn-sm sl-button-primary" onclick="slAdd('admin', {{$item['id']}});">修改</button>
					<button type="button" class="btn btn-sm sl-button-danger" onclick="slDelete('admin', {{$item['id']}});">删除</button>
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