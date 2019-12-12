<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>用户管理</title>
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
					<label for="level">用户等级：</label>
					<select class="form-control" id="level" name="level" autocomplete="off">
						<option value="0">请选择</option>
						@foreach($levels as $item)
						<option value="{{$item['id']}}" {{request()->get('level') == $item['id']?'selected':''}}>{{$item['name']}}</option>
						@endforeach
					</select>
				</div>
				<button type="submit" class="btn btn-sm btn-default">查询</button>
			</form>
		</div>
		<div class="pull-right">
			<button type="button" class="btn btn-sm btn-primary" onclick="starAdd('user');">新增</button>
		</div>
	</div>
	
	{{csrf_field()}}
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th width="10"><input type="checkbox"/></th>
				<th>ID</th>
				<th>用户名</th>
				<th>邮箱</th>
				<th>手机</th>
				<th>性别</th>
				<th>年龄</th>
				<th>微信</th>
				<th>等级</th>
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
				<td>{{$item['email']?$item['email']:'-'}}</td>
				<td>{{$item['phone']?$item['phone']:'-'}}</td>
				<td>
					@if(!$item['sex'])
					-
					@endif
					@if($item['sex'] == 1)
					男
					@endif
					@if($item['sex'] == 2)
					女
					@endif
				</td>
				<td>{{$item['age']}}</td>
				<td>{!!!empty($item['wechat_openid'])?'<span class="text-success"><i class="fa fa-weixin" aria-hidden="true"></i></span>':'<span class="text-muted"><i class="fa fa-weixin" aria-hidden="true"></i></span>'!!}</td>
				<td>{{isset($levels[$item['level']])?$levels[$item['level']]['name']:'-'}}</td>
				<td>{{$item['logined']?date('Y-m-d H:i:s',$item['logined']):'-'}}</td>
				<td>{!!$item['state']==1?'<span class="label label-success">启用</span>':'<span class="label label-danger">禁用</span>'!!}</td>
				<td>
					<button type="button" class="btn btn-sm btn-primary" onclick="starAdd('user', {{$item['id']}});">编辑</button>
					<button type="button" class="btn btn-sm btn-danger" onclick="starDelete('user', {{$item['id']}});">删除</button>
				</td>
			</tr>
			@endforeach
		</tbody>
		@endif
		@if(!$lists)
		<tbody>
			<tr>
				<td class="text-center" colspan="12">啊~没有诶！</td>
			</tr>
		</tbody>
		@endif
		<tfoot>
			<td width="10"><input type="checkbox"/></td>
			<td colspan="11">
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