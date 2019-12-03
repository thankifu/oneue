<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>管理员</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid">
	<form class="star-mt-20">
		{{csrf_field()}}
		<div class="form-group">
			<label for="name">网站名称：</label>
			<input class="form-control" type="text" id="name" name="name" value="{{isset($value['name'])?$value['name']:''}}" placeholder="网站名称" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="domain">网站域名：</label>
			<input class="form-control" type="text" id="domain" name="domain" value="{{isset($value['domain'])?$value['domain']:''}}" placeholder="网站域名" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="seo_title">网站SEO标题：</label>
			<input class="form-control" type="text" id="seo_title" name="seo_title" value="{{isset($value['seo_title'])?$value['seo_title']:''}}" placeholder="网站SEO标题" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="seo_description">网站SEO描述：</label>
			<input class="form-control" type="text" id="seo_description" name="seo_description" value="{{isset($value['seo_description'])?$value['seo_description']:''}}" placeholder="网站SEO描述" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="seo_keywords">网站SEO关键词：</label>
			<input class="form-control" type="text" id="seo_keywords" name="seo_keywords" value="{{isset($value['seo_keywords'])?$value['seo_keywords']:''}}" placeholder="网站SEO关键词" autocomplete="off"/>
		</div>

		<div class="form-group">
			<label>状态：</label>
			<div class="radio">
				<label class="radio-inline">
					<input type="radio" name="state" value="1" {{isset($value['state']) && $value['state']==1?'checked':''}}>开
				</label>
				<label class="radio-inline">
					<input type="radio" name="state" value="0" {{isset($value['state']) && $value['state']==0?'checked':''}}>关
				</label>
			</div>
		</div>

		<div class="form-group text-center">
			<button type="button" class="btn btn-primary" onclick="starSettingSave();">保存</button>
		</div>
		<input type="hidden" name="key" value="site">
	</form>

</div>
@include('backend.common.foot')
</body>
</html>