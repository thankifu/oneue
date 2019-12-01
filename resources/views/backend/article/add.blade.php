@extends('backend.common.index')

@section('body')
<div class="body-content">
	<div class="body-container">
		<div class="body-hd">
			<div class="body-hd-left">
				<div class="body-hd-title">{{$article['id']>0?'编辑文章':'新增文章'}}</div>
			</div>
			<div class="body-hd-right"></div>
		</div>
		<div class="body-bd">
			<div class="body-form">
				<form target="frame_upload" enctype="multipart/form-data" action="/admins/image/index" method="post" style="display:none;">
					{{csrf_field()}}
			        <input type="file" name="upload" id="upload" onchange="upload_img(this)">
			    </form>
				<form id="" action="" method="post" accept-charset="utf-8">
					{{csrf_field()}}
					<div class="body-form-item">
						<label>文章分类：</label>
						<select name="category_id" autocomplete="off">
							<option value="">请选择</option>
							@foreach($categories as $item)
							<option value="{{$item['id']}}" {{$article['category_id'] == $item['id']?'selected':''}}>{{$item['name']}}</option>
							@endforeach
						</select>
					</div>
					<div class="body-form-item">
						<label>文章标题：</label>
						<input class="text" type="text" name="title" value="{{$article['title']}}" placeholder="文章标题" autocomplete="off"/>
					</div>

					<div class="body-form-item">
						<label>文章图片：</label>
						<img onclick="$('#upload').click();" class="image" src="{{$article['picture']}}"/>
						<input class="text" type="text" id="picture" name="picture" value="{{isset($article['picture'])?$article['picture']:''}}" placeholder="文章图片"/>
					</div>

					<div class="body-form-item mb-20">
						<textarea class="textarea" name="content" id="content"/>{{$article['content']}}</textarea>
					</div>

					<div class="body-form-item">
						<label>用户：</label>
						<select name="user_id" autocomplete="off">
							<option value="">请选择</option>
							@foreach($users as $item)
							<option value="{{$item['id']}}" {{$article['user_id'] == $item['id']?'selected':''}}>{{$item['username']}}</option>
							@endforeach
						</select>
					</div>

					<div class="body-form-item">
						<label>作者：</label>
						<input class="text" type="text" name="author" value="{{$article['author']}}" placeholder="文章作者" autocomplete="off"/>
					</div>

					<div class="body-form-item">
						<label>SEO标题：</label>
						<input class="text" type="text" name="seo_title" value="{{$article['seo_title']}}" placeholder="SEO标题" autocomplete="off"/>
					</div>

					<div class="body-form-item">
						<label>SEO描述：</label>
						<input class="text" type="text" name="seo_description" value="{{$article['seo_description']}}" placeholder="SEO描述" autocomplete="off"/>
					</div>

					<div class="body-form-item">
						<label>SEO关键字：</label>
						<input class="text" type="text" name="seo_keywords" value="{{$article['seo_keywords']}}" placeholder="SEO关键字" autocomplete="off"/>
					</div>
					
					<div class="body-form-item">
						<label>状态</label>
						<label class="checkbox">
							<input type="checkbox" name="state" value="" {{$article['state']===0?'checked':''}}/>禁用
						</label>
					</div>
					<button class="button body-form-button" type="button" onclick="articleSave();">保存</button>
					<input type="hidden" name="id" value="{{$article['id']}}">
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="/packages/ckeditor/ckeditor.js"></script>
<script>
	CKEDITOR.replace('content', {height: 500});
</script>
@endsection