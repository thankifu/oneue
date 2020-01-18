<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>添加修改用户等级</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">
	<form>
		{{csrf_field()}}
		<div class="form-group">
			<label for="name">名称：</label>
			<input class="form-control" type="text" id="name" name="name" value="{{$level['name']}}" placeholder="名称" autocomplete="off">
		</div>
		<div class="form-group">
			<label for="discount">折扣：</label>
			<div class="input-group">
				<input class="form-control" type="text" id="discount" name="discount" value="{{$level['discount']?$level['discount']:'0.0'}}" placeholder="折扣" autocomplete="off" data-type="discount">
				<div class="input-group-addon">折</div>
			</div>
		</div>
		<div class="form-group">
			<label for="state">状态：</label>
			<div class="checkbox">
				<label class="checkbox-inline">
					<input type="checkbox" id="state" value="" {{isset($level['state']) && $level['state']==0?'checked':''}}/>禁用
				</label>
			</div>
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-secondary" onclick="starCancel();">取消</button>
			<button type="button" class="btn btn-primary" onclick="starUserLevelStore();">保存</button>
		</div>
		<input type="hidden" id="id" name="id" value="{{$level['id']}}">
	</form>
</div>
@include('backend.common.foot')
</body>
</html>