<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>添加修改商品</title>
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
			<label for="category_id">商品分类：</label>
			<select class="form-control" id="category_id" name="category_id" autocomplete="off">
				<option value="">请选择</option>
				@foreach($categories as $item)
				<option value="{{$item['id']}}" {{$product['category_id'] == $item['id']?'selected':''}}>{{$item['name']}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="name">商品标题：</label>
			<input class="form-control" type="text" id="name" name="name" value="{{$product['name']}}" placeholder="文章标题" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="sku">商品SKU：</label>
			<input class="form-control" type="text" id="sku" name="sku" value="{{$product['sku']}}" placeholder="商品SKU" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="market">商品市场价：</label>
			<input class="form-control" type="text" id="market" name="market" value="{{$product['market']}}" placeholder="商品市场价" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="selling">商品销售价：</label>
			<input class="form-control" type="text" id="selling" name="selling" value="{{$product['selling']}}" placeholder="商品销售价" autocomplete="off">
		</div>
		<div class="form-group">
			<label for="cost">商品成本价：</label>
			<input class="form-control" type="text" id="cost" name="cost" value="{{$product['cost']}}" placeholder="商品成本价" autocomplete="off">
		</div>
		<div class="form-group">
			<label for="quantity">商品库存数量：</label>
			<input class="form-control" type="text" id="quantity" name="quantity" value="{{$product['quantity']}}" placeholder="商品库存数量" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="picture">商品图片：</label>
			<div class="form-inline">
				<div class="form-group">
					<span class="star-picture star-picture-square star-mr-10" style="background-image:url({{isset($product['picture'])?$product['picture']:''}});">
						<i class="star-picture-hd">首图</i>
						<i class="star-picture-bd" onclick="starPicture('picture');"></i>
						<i class="star-picture-ft"></i>
						<input class="form-control" type="hidden" id="picture" name="picture" value="{{isset($product['picture'])?$product['picture']:''}}"/>
					</span>
				</div>
				<div class="form-group">
					@for($i = 0; $i < 4; $i++)
					<span class="star-picture star-picture-square star-mr-10" style="background-image:url({{isset($pictures[$i]['picture'])?$pictures[$i]['picture']:''}});">
						<i class="star-picture-bd" onclick="starPicture('pictures[{{$i}}]');"></i>
						<input class="form-control" type="hidden" name="pictures[{{$i}}]" value="{{isset($pictures[$i]['picture'])?$pictures[$i]['picture']:''}}" />
					</span>
					@endfor
				</div>
			</div>
		</div>
		<div class="form-group">
			<label>商品规格：</label>
			<table class="table table-condensed table-hover">
				<thead>
					<tr>
						<th>名称</th>
						<th>SKU</th>
						<th>市场价</th>
						<th>销售价</th>
						<th>成本价</th>
						<th>图片</th>
						<th>数量</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><input class="form-control" type="text" id="specification_name" name="specification_name" value="" placeholder="" autocomplete="off"></td>
						<td><input class="form-control" type="text" id="specification_sku" name="specification_sku" value="" placeholder="" autocomplete="off"></td>
						<td><input class="form-control" type="text" id="specification_market" name="specification_market" value="" placeholder="" autocomplete="off"></td>
						<td><input class="form-control" type="text" id="specification_selling" name="specification_selling" value="" placeholder="" autocomplete="off"></td>
						<td><input class="form-control" type="text" id="specification_cost" name="specification_cost" value="" placeholder="" autocomplete="off"></td>
						<td>
							
							<span class="star-picture star-picture-square star-mr-10" style="background-image:url();">
								<i class="star-picture-bd" onclick="starPicture('picture');"></i>
								<i class="star-picture-ft"></i>
								<input class="form-control" type="text" id="specification_picture" name="specification_picture" value="" placeholder="" autocomplete="off">
							</span>
						</td>
						<td><input class="form-control" type="text" id="specification_position" name="specification_position" value="" placeholder="" autocomplete="off"></td>
						<td>
							
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="form-group">
			<label for="content">商品详情：</label>
			<textarea class="textarea" name="description" id="description"/>{{$product['description']}}</textarea>
		</div>
		<div class="form-group">
			<label for="seo_title">SEO标题：</label>
			<input class="form-control" type="text" id="seo_title" name="seo_title" value="{{$product['seo_title']}}" placeholder="SEO标题" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="seo_description">SEO描述：</label>
			<input class="form-control" type="text" id="seo_description" name="seo_description" value="{{$product['seo_description']}}" placeholder="SEO描述" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label for="seo_keywords">SEO关键字：</label>
			<input class="form-control" type="text" id="seo_keywords" name="seo_keywords" value="{{$product['seo_keywords']}}" placeholder="SEO关键字" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label>商品状态：</label>
			<div class="radio">
				<label class="radio-inline">
					<input type="radio" name="state" value="1" {{isset($value['state']) && $value['state']==1?'checked':''}}>启用
				</label>
				<label class="radio-inline">
					<input type="radio" name="state" value="0" {{isset($value['state']) && $value['state']==0?'checked':''}}>禁用
				</label>
			</div>
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-secondary" onclick="starCancelJump();">取消</button>
			<button type="button" class="btn btn-primary" onclick="starProductSave();">保存</button>
		</div>
		<input type="hidden" id="id" name="id" value="{{$product['id']}}">
	</form>
</div>
@include('backend.common.foot')
<script src="/packages/ckeditor/ckeditor.js"></script>
<script>
	CKEDITOR.replace('description', {height: 500, filebrowserUploadUrl: '{{url('/admin/upload/native')}}?upload_place=editor&_token={{csrf_token()}}',});
</script>
</body>
</html>