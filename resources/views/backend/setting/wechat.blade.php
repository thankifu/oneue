<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>微信设置</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">
	<form class="star-mt-20">
		<div class="form-group">
			<label for="name">公众号APP ID：</label>
			<input class="form-control" type="text" id="official_account_app_id" name="official_account_app_id" value="{{isset($value['official_account_app_id'])?$value['official_account_app_id']:''}}" placeholder="公众号APP ID" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="domain">公众号APP Secret：</label>
			<input class="form-control" type="text" id="official_account_app_secret" name="official_account_app_secret" value="{{isset($value['official_account_app_secret'])?$value['official_account_app_secret']:''}}" placeholder="公众号APP Secret" autocomplete="off"/>
		</div>

		<div class="form-group">
			<label for="name">开放平台APP ID：</label>
			<input class="form-control" type="text" id="open_platform_app_id" name="open_platform_app_id" value="{{isset($value['open_platform_app_id'])?$value['open_platform_app_id']:''}}" placeholder="开放平台APP ID" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="domain">开放平台APP Secret：</label>
			<input class="form-control" type="text" id="open_platform_app_secret" name="open_platform_app_secret" value="{{isset($value['open_platform_app_secret'])?$value['open_platform_app_secret']:''}}" placeholder="开放平台APP Secret" autocomplete="off"/>
		</div>

		<div class="form-group">
			<label for="name">微信支付商户号：</label>
			<input class="form-control" type="text" id="payment_mch_id" name="payment_mch_id" value="{{isset($value['payment_mch_id'])?$value['payment_mch_id']:''}}" placeholder="微信支付商户号" autocomplete="off"/>
			<span class="help-block">帐户中心-帐户设置-商户信息</span>
		</div>
		<div class="form-group">
			<label for="domain">微信支付API密钥：</label>
			<input class="form-control" type="text" id="payment_api_secret_key" name="payment_api_secret_key" value="{{isset($value['payment_api_secret_key'])?$value['payment_api_secret_key']:''}}" placeholder="微信支付API密钥" autocomplete="off"/>
			<span class="help-block">帐户中心-帐户设置-安全设置-API安全-API密钥-设置API密钥</span>
		</div>
		<div class="form-group">
			<label for="domain">微信支付证书公钥路径：</label>
			<input class="form-control" type="text" id="payment_path_cert" name="payment_path_cert" value="{{isset($value['payment_path_cert'])?$value['payment_path_cert']:''}}" placeholder="微信支付证书公钥路径" autocomplete="off"/>
			<span class="help-block">例如：path/to/cert/apiclient_cert.pem</span>
		</div>
		<div class="form-group">
			<label for="domain">微信支付证书私钥路径：</label>
			<input class="form-control" type="text" id="payment_path_key" name="payment_path_key" value="{{isset($value['payment_path_key'])?$value['payment_path_key']:''}}" placeholder="微信支付证书私钥路径" autocomplete="off"/>
			<span class="help-block">例如：path/to/cert/apiclient_key.pem</span>
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-primary" onclick="starSettingSave();">保存</button>
		</div>
		<input type="hidden" name="key" value="wechat">
		{{csrf_field()}}
	</form>
</div>
@include('backend.common.foot')
</body>
</html>