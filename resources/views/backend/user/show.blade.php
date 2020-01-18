<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>添加修改用户</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">
	<form>
		{{csrf_field()}}
		<div class="form-group">
			<label for="username">用户名：</label>
			<input class="form-control" type="text" id="username" name="username" value="{{$user['username']}}" {{$user['id']>0?'readonly':''}} placeholder="用户名" autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">密码：</label>
			<input class="form-control" type="password" id="password" name="password" value="" placeholder="密码" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="email">邮箱：</label>
			<input class="form-control" type="text" id="email" name="email" value="{{$user['email']}}" placeholder="邮箱" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="phone">手机：</label>
			<input class="form-control" type="text" id="phone" name="phone" value="{{$user['phone']}}" placeholder="手机" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="level">等级：</label>
			<select class="form-control" id="level" name="level" autocomplete="off">
				<option value="">请选择</option>
				@foreach($levels as $item)
				<option value="{{$item['id']}}" {{$user['level'] == $item['id']?'selected':''}}>{{$item['name']}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="state">状态：</label>
			<div class="checkbox">
				<label>
					<input type="checkbox" id="state" name="state" value="" {{$user['state']===0?'checked':''}}>
					禁用
				</label>
			</div>
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-secondary" onclick="starCancel();">取消</button>
			<button type="button" class="btn btn-primary" onclick="starUserStore();">保存</button>
		</div>
		<input type="hidden" id="id" name="id" value="{{$user['id']}}">
	</form>
</div>
@include('backend.common.foot')
</body>
</html>