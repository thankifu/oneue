<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>添加编辑后台菜单</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">

	<form>
		{{csrf_field()}}

		@if($parent_menu)
		<div class="form-group">
			<label for="">上级菜单：</label>
			<input class="form-control" type="text" id="" name="" value="{{$parent_menu['name']}}" placeholder="上级菜单" autocomplete="off" disabled="true">
		</div>
		@endif

		<div class="form-group">
			<label for="name">菜单名称：</label>
			<input class="form-control" type="text" id="name" name="name" value="{{$menu['name']}}" placeholder="菜单名称" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="position">排序：</label>
			<input class="form-control" type="text" id="position" name="position" value="{{$menu['position']}}" placeholder="排序" autocomplete="off">
		</div>
		<div class="form-group">
			<label for="controller">控制器：</label>
			<input class="form-control" type="text" id="controller" name="controller" value="{{$menu['controller']}}" placeholder="控制器" autocomplete="off">
		</div>
		<div class="form-group">
			<label for="action">方法：</label>
			<input class="form-control" type="text" id="action" name="action" value="{{$menu['action']}}" placeholder="控制器" autocomplete="off">
		</div>
		<div class="form-group">
			<label for="path">路径：</label>
			<input class="form-control" type="text" id="path" name="path" value="{{$menu['path']}}" placeholder="路径" autocomplete="off">
		</div>

		<div class="form-group">
			<label>状态：</label>
			<div class="checkbox">
				<label class="checkbox-inline">
					<input type="checkbox" id="hidden" name="hidden" value="" {{$menu['hidden']==1?'checked':''}}>隐藏
				</label>
				<label class="checkbox-inline">
					<input type="checkbox" id="state" name="state" value="" {{isset($menu['state']) && $menu['state']==0?'checked':''}}/>禁用
				</label>
			</div>

		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-secondary" onclick="starCancel();">取消</button>
			<button type="button" class="btn btn-primary" onclick="starMenuStore();">保存</button>
		</div>
		<input type="hidden" id="parent" name="parent" value="{{isset($parent_menu['id'])?$parent_menu['id']:0}}">
		<input type="hidden" id="id" name="id" value="{{$menu['id']}}">
	</form>

</div>
@include('backend.common.foot')
</body>
</html>