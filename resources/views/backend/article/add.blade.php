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

	<form id="upload_form" target="upload_iframe" enctype="multipart/form-data" action="/admin/upload/native" method="post" style="display:none;">
		{{csrf_field()}}
		<input type="file" name="upload_file" id="upload_file" onchange="starUploadNative()">
		<input type="hidden" name="upload_place" id="upload_place" value="">
		<iframe name="upload_iframe" id="upload_iframe" style="display: none;"></iframe>
	</form>

	<form class="star-mt-20">
		{{csrf_field()}}
		<div class="form-group">
			<label for="category_id">文章分类：</label>
			<select class="form-control" id="category_id" name="category_id" autocomplete="off">
				<option value="">请选择</option>
				@foreach($categories as $item)
				<option value="{{$item['id']}}" {{$article['category_id'] == $item['id']?'selected':''}}>{{$item['name']}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="title">文章标题：</label>
			<input class="form-control" type="text" id="title" name="title" value="{{$article['title']}}" placeholder="文章标题" autocomplete="off">
		</div>
		<div class="form-group">
			<label for="picture">文章图片：</label>
			<div class="form-inline">
				<div class="form-group">
					<span class="star-picture star-picture-rectangle star-mr-10" style="background-image:url({{isset($article['picture'])?$article['picture']:''}});">
						<i class="star-picture-hd">首图</i>
						<i class="star-picture-bd" onclick="starPicture('picture');"></i>
						<i class="star-picture-ft"></i>
						<input class="form-control" type="hidden" id="picture" name="picture" value="{{isset($article['picture'])?$article['picture']:''}}"/>
					</span>
				</div>
				<!-- <div class="form-group">
					<span class="star-picture star-picture-rectangle star-mr-10" style="background-image:url();">
						<i class="star-picture-bd" onclick="starPicture('pictures[0]');"></i>
						<input class="form-control" type="hidden" name="pictures[0]" value="" />
					</span>
					<span class="star-picture star-picture-rectangle star-mr-10" style="background-image:url();">
						<i class="star-picture-bd" onclick="starPicture('pictures[1]');"></i>
						<input class="form-control" type="hidden" name="pictures[1]" value="" />
					</span>
					<span class="star-picture star-picture-rectangle star-mr-10" style="background-image:url();">
						<i class="star-picture-bd" onclick="starPicture('pictures[2]');"></i>
						<input class="form-control" type="hidden" name="pictures[2]" value="" />
					</span>
					<span class="star-picture star-picture-rectangle star-mr-10" style="background-image:url();">
						<i class="star-picture-bd" onclick="starPicture('pictures[3]');"></i>
						<input class="form-control" type="hidden" name="pictures[3]" value="" />
					</span>
				</div> -->
			</div>
			
		</div>


		<div class="form-group">
			<label for="content">文章内容：</label>
			<textarea class="textarea" name="content" id="content"/>{{$article['content']}}</textarea>
		</div>
		<div class="form-group">
			<label for="author">文章作者：</label>
			<input class="form-control" type="text" id="author" name="author" value="{{$article['author']}}" placeholder="文章作者" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="seo_title">SEO标题：</label>
			<input class="form-control" type="text" id="seo_title" name="seo_title" value="{{$article['seo_title']}}" placeholder="SEO标题" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="seo_description">SEO描述：</label>
			<input class="form-control" type="text" id="seo_description" name="seo_description" value="{{$article['seo_description']}}" placeholder="SEO描述" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="seo_keywords">SEO关键字：</label>
			<input class="form-control" type="text" id="seo_keywords" name="seo_keywords" value="{{$article['seo_keywords']}}" placeholder="SEO关键字" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label>文章状态：</label>
			<div class="checkbox">
				<label>
					<input type="checkbox" id="state" name="state" value="" {{$article['state']===0?'checked':''}}>
					禁用
				</label>
			</div>
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-secondary" onclick="starCancelJump();">取消</button>
			<button type="button" class="btn btn-primary" onclick="starArticleSave();">保存</button>
		</div>
		<input type="hidden" id="id" name="id" value="{{$article['id']}}">
	</form>



</div>
@include('backend.common.foot')
<script src="/packages/ckeditor/ckeditor.js"></script>
<script>
	CKEDITOR.replace('content', {height: 500, filebrowserUploadUrl: '{{url('/admin/upload/native')}}?upload_place=editor&_token={{csrf_token()}}',});
</script>
</body>
</html>