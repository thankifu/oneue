<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>添加编辑管理组</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid">
	<form>
		{{csrf_field()}}
		<div class="form-group">
			<label for="name">管理组名：</label>
			<input class="form-control" type="text" id="name" name="name" value="{{$group['name']}}" placeholder="管理组名" autocomplete="off">
		</div>
		
		@foreach($menus as $menu)
		<div class="form-group">
			<div class="checkbox">
				<label>
					<input type="checkbox" name="menu[{{$menu['id']}}]" value="" {{isset($group['permission']) && $group['permission'] && in_array($menu['id'],$group['permission'])?'checked':''}}>
					<strong>{{$menu['name']}}</strong>
				</label>
			</div>

			@if($menu['children'])
			<div class="checkbox star-ml-20">
				@foreach($menu['children'] as $child)
				<label class="checkbox-inline">
					<input type="checkbox" name="menu[{{$child['id']}}]" value="" {{isset($group['permission']) && $group['permission'] && in_array($child['id'],$group['permission'])?'checked':''}}> {{$child['name']}}
				</label>
				@endforeach
			</div>
			@endif

		</div>
		@endforeach					
		<div class="form-group text-center">
			<button type="button" class="btn btn-secondary" onclick="starCancel();">取消</button>
			<button type="button" class="btn btn-primary" onclick="starGroupSave();">保存</button>
		</div>
		<input type="hidden" id="id" name="id" value="{{$group['id']}}">
	</form>

</div>
@include('backend.common.foot')
</body>
</html>