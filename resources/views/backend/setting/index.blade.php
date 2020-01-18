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
	<form id="upload_form" target="upload_iframe" enctype="multipart/form-data" action="/admin/upload/index" method="post" style="display:none;">
		{{csrf_field()}}
		<input type="file" name="upload_file" id="upload_file" onchange="starUpload()">
		<input type="hidden" name="upload_place" id="upload_place" value="">
		<iframe name="upload_iframe" id="upload_iframe" style="display: none;"></iframe>
	</form>
	<form id="form" class="star-mt-20">
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
			<span class="help-block">网站首页的标题参数，不设置标题为“网站标题 - 网站名称”，设置后标题为“网站SEO标题 - 网站名称”。</span>
		</div>
		<div class="form-group">
			<label for="seo_description">网站SEO描述：</label>
			<input class="form-control" type="text" id="seo_description" name="seo_description" value="{{isset($value['seo_description'])?$value['seo_description']:''}}" placeholder="网站SEO描述" autocomplete="off"/>
			<span class="help-block">网站首页的描述参数，不设置为空。</span>
		</div>
		<div class="form-group">
			<label for="seo_keywords">网站SEO关键词：</label>
			<input class="form-control" type="text" id="seo_keywords" name="seo_keywords" value="{{isset($value['seo_keywords'])?$value['seo_keywords']:''}}" placeholder="网站SEO关键词" autocomplete="off"/>
			<span class="help-block">网站首页的关键词参数，不设置为空。</span>
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
			<label for="phone">联系手机：</label>
			<input class="form-control" type="text" id="phone" name="phone" value="{{isset($value['phone'])?$value['phone']:''}}" placeholder="联系手机" autocomplete="off"/>
			<span class="help-block">关闭在线购物功能和订单退款时展示。</span>
		</div>
		<div class="form-group">
			<label for="wechat">联系微信：</label>
			<input class="form-control" type="text" id="wechat" name="wechat" value="{{isset($value['wechat'])?$value['wechat']:''}}" placeholder="联系微信" autocomplete="off"/>
			<span class="help-block">关闭在线购物功能和订单退款时展示。</span>
		</div>
		<div class="form-group">
			<label for="picture_qrcode">联系微信二维码：</label>
			<div class="form-inline">
				<div class="form-group">
					<span class="star-picture star-picture-square star-mr-10" style="background-image:url({{isset($value['picture_qrcode'])?$value['picture_qrcode']:'/images/star-upload-image.png'}});">
						<i class="star-picture-bd" onclick="starPicture('picture_qrcode');"></i>
						<i class="star-picture-ft"></i>
						<input class="form-control" type="hidden" id="picture_qrcode" name="picture_qrcode" value="{{isset($value['picture_qrcode'])?$value['picture_qrcode']:''}}"/>
					</span>
				</div>
			</div>
			<span class="help-block">关闭在线购物功能和订单退款时展示。</span>
		</div>
		<div class="form-group">
			<label>在线购物：</label>
			<div class="radio">
				<label class="radio-inline">
					<input type="radio" name="shopping" value="1" {{isset($value['shopping']) && $value['shopping']==1?'checked':''}}>开
				</label>
				<label class="radio-inline">
					<input type="radio" name="shopping" value="0" {{isset($value['shopping']) && $value['shopping']==0?'checked':''}}>关
				</label>
			</div>
			<span class="help-block">立即购买、加入购物车功能。<span class="text-danger">注意：“关闭”此功能请仔细填写上方手机和微信联系方式，否则用户无法联系。 </span></span>
		</div>
		<div class="form-group">
			<label>用户注册：</label>
			<div class="radio">
				<label class="radio-inline">
					<input type="radio" name="auth_register" value="1" {{isset($value['auth_register']) && $value['auth_register']==1?'checked':''}}>开
				</label>
				<label class="radio-inline">
					<input type="radio" name="auth_register" value="0" {{isset($value['auth_register']) && $value['auth_register']==0?'checked':''}}>关
				</label>
			</div>
			<span class="help-block">用户名、密码的注册方式。<span class="text-danger">注意：“邮箱验证”不开启用户需要输入2次密码确认。 </span></span>
		</div>
		<div class="form-group">
			<label>注册邮箱验证：</label>
			<div class="radio">
				<label class="radio-inline">
					<input type="radio" name="auth_email" value="1" {{isset($value['auth_email']) && $value['auth_email']==1?'checked':''}}>开
				</label>
				<label class="radio-inline">
					<input type="radio" name="auth_email" value="0" {{isset($value['auth_email']) && $value['auth_email']==0?'checked':''}}>关
				</label>
			</div>
			<span class="help-block">在用户名、密码的注册方式上增加邮箱真实性验证。<!-- <span class="text-danger">建议：“邮箱认证”和“手机认证”二选其一。 </span>--></span>
		</div>
		<div class="form-group sr-only">
			<label>注册手机验证：</label>
			<div class="radio">
				<label class="radio-inline">
					<input type="radio" name="auth_phone" value="1" {{isset($value['auth_phone']) && $value['auth_phone']==1?'checked':''}}>开
				</label>
				<label class="radio-inline">
					<input type="radio" name="auth_phone" value="0" {{isset($value['auth_phone']) && $value['auth_phone']==0?'checked':''}}>关
				</label>
			</div>
			<span class="help-block text-danger">未包含此功能，请勿开启。</span>
			<!-- <span class="help-block">在用户名、密码的注册方式上增加手机真实性验证。<span class="text-danger">建议：“邮箱认证”和“手机认证”二选其一。</span></span> -->
		</div>
		<div class="form-group">
			<label>微信注册登陆：</label>
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
			<button type="button" class="btn btn-primary" onclick="starSettingStore();">保存</button>
		</div>
		<input type="hidden" name="key" value="site">
		{{csrf_field()}}
	</form>
</div>
@include('backend.common.foot')
</body>
</html>