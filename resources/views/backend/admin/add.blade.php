<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>添加修改管理员</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid">
	<form>
		{{csrf_field()}}
		<div class="form-group">
			<label for="group_id">管理组：</label>
			<select class="form-control" id="group_id" name="group_id" autocomplete="off">
				<option value="">请选择</option>
				@foreach($groups as $group)
				<option value="{{$group['id']}}" {{$admin['group_id'] == $group['id']?'selected':''}}>{{$group['name']}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="username">用户名：</label>
			<input class="form-control" type="text" id="username" name="username" value="{{$admin['username']}}" {{$admin['id']>0?'readonly':''}} placeholder="用户名" autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">密码：</label>
			<input class="form-control" type="password" id="password" name="password" value="" placeholder="密码" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="name">真实姓名：</label>
			<input class="form-control" type="text" id="name" name="name" value="{{$admin['name']}}" placeholder="真实姓名" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="phone">手机号码：</label>
			<input class="form-control" type="text" id="phone" name="phone" value="{{$admin['phone']}}" placeholder="手机号码" autocomplete="off"/>
		</div>
		<div class="form-group">
			<div class="checkbox">
				<label>
					<input type="checkbox" id="state" name="state" value="" {{$admin['state']===0?'checked':''}}>
					禁用
				</label>
			</div>
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-secondary" onclick="starCancel();">取消</button>
			<button type="button" class="btn btn-primary" onclick="starAdminSave();">保存</button>
		</div>
		<input type="hidden" id="id" name="id" value="{{$admin['id']}}">
	</form>
</div>
@include('backend.common.foot')
</body>
</html>