<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>添加修改商品分类</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">
	<form>
		{{csrf_field()}}

		@if($parent)
		<div class="form-group">
			<label for="">上级：</label>
			<input class="form-control" type="text" value="{{$parent['name']}}" placeholder="上级" autocomplete="off" disabled="true">
		</div>
		@endif

		<div class="form-group">
			<label for="name">名称：</label>
			<input class="form-control" type="text" id="name" name="name" value="{{$category['name']}}" placeholder="名称" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="position">排序：</label>
			<input class="form-control" type="text" id="position" name="position" value="{{$category['position']}}" placeholder="排序" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="seo_title">SEO标题：</label>
			<input class="form-control" type="text" id="seo_title" name="seo_title" value="{{$category['seo_title']}}" placeholder="SEO标题" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="seo_description">SEO描述：</label>
			<input class="form-control" type="text" id="seo_description" name="seo_description" value="{{$category['seo_description']}}" placeholder="SEO描述" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="seo_keywords">SEO关键词：</label>
			<input class="form-control" type="text" id="seo_keywords" name="seo_keywords" value="{{$category['seo_keywords']}}" placeholder="SEO关键词" autocomplete="off">
		</div>

		<div class="form-group">
			<label>状态：</label>
			<div class="checkbox">
				<label class="checkbox-inline">
					<input type="checkbox" id="state" value="" {{isset($category['state']) && $category['state']==0?'checked':''}}/>禁用
				</label>
			</div>
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-secondary" onclick="starCancel();">取消</button>
			<button type="button" class="btn btn-primary" onclick="starCategorySave('product');">保存</button>
		</div>
		<input type="hidden" id="parent" name="parent" value="{{isset($parent['id'])?$parent['id']:0}}">
		<input type="hidden" id="id" name="id" value="{{$category['id']}}">
	</form>

</div>
@include('backend.common.foot')
</body>
</html>