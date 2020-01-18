<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>新增修改帮助</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">

	<form id="form" class="star-mt-20">
		{{csrf_field()}}
		<div class="form-group">
			<label for="category_id">分类：</label>
			<select class="form-control" id="category_id" name="category_id" autocomplete="off">
				<option value="">请选择</option>
				@foreach($categories as $item)
				<option value="{{$item['id']}}" {{$help['category_id'] == $item['id']?'selected':''}}>{{$item['name']}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="title">标题：</label>
			<input class="form-control" type="text" id="title" name="title" value="{{$help['title']}}" placeholder="标题" autocomplete="off">
		</div>
		<div class="form-group">
			<label for="content">内容：</label>
			<textarea class="textarea" name="content" id="content"/>{{$help['content']}}</textarea>
		</div>
		<div class="form-group">
			<label for="author">排序：</label>
			<input class="form-control" type="text" id="position" name="position" value="{{$help['position']}}" placeholder="排序" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="seo_title">SEO标题：</label>
			<input class="form-control" type="text" id="seo_title" name="seo_title" value="{{$help['seo_title']}}" placeholder="SEO标题" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="seo_description">SEO描述：</label>
			<input class="form-control" type="text" id="seo_description" name="seo_description" value="{{$help['seo_description']}}" placeholder="SEO描述" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="seo_keywords">SEO关键字：</label>
			<input class="form-control" type="text" id="seo_keywords" name="seo_keywords" value="{{$help['seo_keywords']}}" placeholder="SEO关键字" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label>状态：</label>
			<div class="radio">
				<label class="radio-inline">
					<input type="radio" name="state" value="1" {{isset($help['state']) && $help['state']==1?'checked':''}}>启用
				</label>
				<label class="radio-inline">
					<input type="radio" name="state" value="0" {{isset($help['state']) && $help['state']==0?'checked':''}}>禁用
				</label>
			</div>
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-secondary" onclick="starCancelJump();">取消</button>
			<button type="button" class="btn btn-primary" onclick="starHelpStore();">保存</button>
		</div>
		<input type="hidden" id="id" name="id" value="{{$help['id']}}">
	</form>
</div>
@include('backend.common.foot')
<script src="/packages/ckeditor/ckeditor.js"></script>
<script>
	CKEDITOR.replace('content', {height: 500, filebrowserUploadUrl: '{{url('/admin/upload/index')}}?upload_place=editor&_token={{csrf_token()}}',});
</script>
</body>
</html>