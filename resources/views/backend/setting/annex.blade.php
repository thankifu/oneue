<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>附件设置</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid">
	<form class="star-mt-20">
		<div class="form-group">
			<label for="upload_size">允许上传大小：</label>
			<input class="form-control" type="text" id="size" name="size" value="{{isset($value['size'])?$value['size']:''}}" placeholder="请输入上传大小" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label>允许上传类型：</label>
			<div class="checkbox">
				<label class="checkbox-inline">
					<input type="checkbox" name="type[]" value=".jpg" {{isset($value['type']) && in_array('.jpg', $value['type'])?'checked':''}}>.jpg
				</label>
				<label class="checkbox-inline">
					<input type="checkbox" name="type[]" value=".gif" {{isset($value['type']) && in_array('.gif', $value['type'])?'checked':''}}>.gif
				</label>
				<label class="checkbox-inline">
					<input type="checkbox" name="type[]" value=".png" {{isset($value['type']) && in_array('.png', $value['type'])?'checked':''}}>.png
				</label>
			</div>
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-primary" onclick="starSettingSave();">保存</button>
		</div>
		<input type="hidden" name="key" value="annex">
		{{csrf_field()}}
	</form>
</div>
@include('backend.common.foot')
</body>
</html>