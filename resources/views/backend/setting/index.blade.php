<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>网站设置</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">
	<form class="star-mt-20">
		<div class="form-group">
			<label for="name">网站名称：</label>
			<input class="form-control" type="text" id="name" name="name" value="{{isset($value['name'])?$value['name']:''}}" placeholder="网站名称" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="domain">网站域名：</label>
			<input class="form-control" type="text" id="domain" name="domain" value="{{isset($value['domain'])?$value['domain']:''}}" placeholder="网站域名" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="name">网站标题：</label>
			<input class="form-control" type="text" id="title" name="title" value="{{isset($value['title'])?$value['title']:''}}" placeholder="网站标题" autocomplete="off"/>
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
			<label for="copyright">网站版权信息：</label>
			<input class="form-control" type="text" id="copyright" name="copyright" value="{{isset($value['copyright'])?$value['copyright']:''}}" placeholder="网站版权信息" autocomplete="off"/>
			<span class="help-block">网站的版权信息设置，在网站底部显示。</span>
		</div>
		<div class="form-group">
			<label for="miitbeian">网站备案号码：</label>
			<input class="form-control" type="text" id="miitbeian" name="miitbeian" value="{{isset($value['miitbeian'])?$value['miitbeian']:''}}" placeholder="网站备案号码" autocomplete="off"/>
			<span class="help-block">网站备案号，可以在<a target="_blank" href="http://www.miitbeian.gov.cn">备案管理中心</a>查询获取。</span>
		</div>
		<div class="form-group">
			<label>默认注册：</label>
			<div class="radio">
				<label class="radio-inline">
					<input type="radio" name="auth_register" value="1" {{isset($value['auth_register']) && $value['auth_register']==1?'checked':''}}>开
				</label>
				<label class="radio-inline">
					<input type="radio" name="auth_register" value="0" {{isset($value['auth_register']) && $value['auth_register']==0?'checked':''}}>关
				</label>
			</div>
			<span class="help-block">用户名、密码的注册方式。</span>
		</div>
		<div class="form-group">
			<label>微信注册：</label>
			<div class="radio">
				<label class="radio-inline">
					<input type="radio" name="auth_wechat" value="1" {{isset($value['auth_wechat']) && $value['auth_wechat']==1?'checked':''}}>开
				</label>
				<label class="radio-inline">
					<input type="radio" name="auth_wechat" value="0" {{isset($value['auth_wechat']) && $value['auth_wechat']==0?'checked':''}}>关
				</label>
			</div>
			<span class="help-block">微信中使用微信帐号快速注册登录方式。</span>
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-primary" onclick="starSettingSave();">保存</button>
		</div>
		<input type="hidden" name="key" value="site">
		{{csrf_field()}}
	</form>
</div>
@include('backend.common.foot')
</body>
</html>