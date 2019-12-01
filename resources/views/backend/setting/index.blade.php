@extends('backend.common.index')

@section('body')
<div class="body-content">
	<div class="body-container">
		<div class="body-hd">
			<div class="body-hd-left">
				<div class="body-hd-title">网站设置</div>
			</div>
			<div class="body-hd-right">
			</div>
		</div>
		<div class="body-bd">
			<div class="body-form">
				<form id="" action="" method="post" accept-charset="utf-8">
					{{csrf_field()}}

					<div class="body-form-item">
						<label>网站名称：</label>
						<input class="text" type="text" name="name" value="{{isset($value['name'])?$value['name']:''}}" placeholder="请输入网站名称" autocomplete="off"/>
					</div>

					<div class="body-form-item">
						<label>网站域名：</label>
						<input class="text" type="text" name="domain" value="{{isset($value['domain'])?$value['domain']:''}}" placeholder="请输入网站域名" autocomplete="off"/>
					</div>

					<div class="body-form-item">
						<label>网站SEO标题：</label>
						<input class="text" type="text" name="seo_title" value="{{isset($value['seo_title'])?$value['seo_title']:''}}" placeholder="网站SEO标题" autocomplete="off"/>
					</div>

					<div class="body-form-item">
						<label>网站SEO描述：</label>
						<input class="text" type="text" name="seo_descriptions" value="{{isset($value['seo_descriptions'])?$value['seo_descriptions']:''}}" placeholder="网站SEO描述" autocomplete="off"/>
					</div>

					<div class="body-form-item">
						<label>网站SEO关键词：</label>
						<input class="text" type="text" name="seo_keywords" value="{{isset($value['seo_keywords'])?$value['seo_keywords']:''}}" placeholder="网站SEO关键词" autocomplete="off"/>
					</div>
					<div class="body-form-item">
						<label>网站开关：</label>
						<label class="radio">
							<input type="radio" name="state" value="1" {{isset($value['state']) && $value['state']==1?'checked':''}}/>开
						</label>
						<label class="radio">
							<input type="radio" name="state" value="0" {{isset($value['state']) && $value['state']==0?'checked':''}}/>关
						</label>
					</div>
					<button class="button body-form-button" type="button" onclick="settingSave();">保存</button>
					<input type="hidden" name="key" value="site">
				</form>
			</div>
		</div>
	</div>
</div>
@endsection