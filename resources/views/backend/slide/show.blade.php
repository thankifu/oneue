<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>增改轮播</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">
	<form id="upload_form" target="upload_iframe" enctype="multipart/form-data" action="/admin/upload/index" method="post" style="display:none;">
		{{csrf_field()}}
		<input type="file" name="upload_file" id="upload_file" onchange="starUpload()">
		<input type="hidden" name="upload_place" id="upload_place" value="">
		<input type="hidden" name="upload_object" id="upload_object" value="">
		<iframe name="upload_iframe" id="upload_iframe" style="display: none;"></iframe>
	</form>

	<form id="form">
		{{csrf_field()}}

		<div class="form-group">
			<label for="title">标题：</label>
			<input class="form-control" type="text" id="title" name="title" value="{{$slide['title']}}" placeholder="标题" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="subtitle">副标题：</label>
			<input class="form-control" type="text" id="subtitle" name="subtitle" value="{{$slide['subtitle']}}" placeholder="副标题" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="picture">图片：</label>
			<div class="form-inline">
				<div class="form-group">
					<span class="star-picture star-picture-rectangle star-mr-10" style="background-image:url({{isset($slide['picture'])?$slide['picture']:'/images/star-upload-image.png'}});">
						<i class="star-picture-bd" onclick="starPicture('slide' ,'picture');"></i>
						<i class="star-picture-ft"></i>
						<input class="form-control" type="hidden" id="picture" name="picture" value="{{isset($slide['picture'])?$slide['picture']:''}}"/>
					</span>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="url">链接地址：</label>
			<input class="form-control" type="text" id="url" name="url" value="{{$slide['url']}}" placeholder="链接地址" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="position">排序：</label>
			<input class="form-control" type="text" id="position" name="position" value="{{$slide['position']}}" placeholder="排序" autocomplete="off">
		</div>

		<div class="form-group">
			<label>状态：</label>
			<div class="checkbox">
				<label class="checkbox-inline">
					<input type="checkbox" id="state" value="" {{isset($slide['state']) && $slide['state']==0?'checked':''}}/>禁用
				</label>
			</div>
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-secondary" onclick="starCancel();">取消</button>
			<button type="button" class="btn btn-primary" onclick="starSlideStore();">保存</button>
		</div>
		<input type="hidden" id="id" name="id" value="{{$slide['id']}}">
	</form>

</div>
@include('backend.common.foot')
</body>
</html>