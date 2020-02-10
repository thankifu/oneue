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
<div class="container-fluid star-main-font">

	<form id="upload_form" target="upload_iframe" enctype="multipart/form-data" action="/admin/upload/index" method="post" style="display:none;">
		{{csrf_field()}}
		<input type="file" name="upload_file" id="upload_file" onchange="starUpload()">
		<input type="hidden" name="upload_place" id="upload_place" value="">
		<input type="hidden" name="upload_object" id="upload_object" value="">
		<iframe name="upload_iframe" id="upload_iframe" style="display: none;"></iframe>
	</form>

	<form id="form" class="star-mt-20">
		{{csrf_field()}}
		<div class="form-group">
			<label for="category_id">分类：</label>
			<select class="form-control" id="category_id" name="category_id" autocomplete="off">
				<option value="">请选择</option>
				@foreach($categories as $item)
				<option value="{{$item['id']}}" {{$product['category_id'] == $item['id']?'selected':''}}>{{$item['name']}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="name">名称：</label>
			<input class="form-control" type="text" id="name" name="name" value="{{$product['name']}}" placeholder="商品名称" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="sku">SKU：</label>
			<input class="form-control" type="text" id="sku" name="sku" value="{{$product['sku']?$product['sku']:'0'}}" placeholder="商品SKU" autocomplete="off">
		</div>
		
		<div class="row">
			<div class="form-group col-sm-3 col-xs-12">
				<label for="market">市场价：</label>
				<div class="input-group">
					<div class="input-group-addon">&yen;</div>
					<input class="form-control" type="text" id="market" name="market" value="{{$product['market']?$product['market']:'0.00'}}" placeholder="商品市场价" autocomplete="off" data-type="price">
				</div>			
			</div>
			<div class="form-group col-sm-3 col-xs-12">
				<label for="selling">销售价：</label>
				<div class="input-group">
					<div class="input-group-addon">&yen;</div>
					<input class="form-control" type="text" id="selling" name="selling" value="{{$product['selling']?$product['selling']:'0.00'}}" placeholder="商品销售价" autocomplete="off" data-type="price">
				</div>
			</div>
			<div class="form-group col-sm-3 col-xs-12">
				<label for="cost">成本价：</label>
				<div class="input-group">
					<div class="input-group-addon">&yen;</div>
					<input class="form-control" type="text" id="cost" name="cost" value="{{$product['cost']?$product['cost']:'0.00'}}" placeholder="商品成本价" autocomplete="off" data-type="price">
				</div>
			</div>
			<div class="form-group col-sm-3 col-xs-12">
				<label for="quantity">库存数量：</label>
				<input class="form-control" type="text" id="quantity" name="quantity" value="{{$product['quantity']?$product['quantity']:'0'}}" placeholder="商品库存数量" autocomplete="off" data-type="number">
			</div>
		</div>

		<div class="form-group">
			<label for="picture">图片：</label>
			<div class="form-inline">
				<div class="form-group">
					<span class="star-picture star-picture-square star-mr-10" style="background-image:url({{isset($product['picture']) && $product['picture'] ? $product['picture'] : '/images/star-upload-image.png'}});">
						<i class="star-picture-hd">首图</i>
						<i class="star-picture-bd" onclick="starPicture('product', 'picture');"></i>
						<i class="star-picture-ft"></i>
						<input class="form-control" type="hidden" id="picture" name="picture" value="{{$product['picture']}}"/>
					</span>
				</div>
				<div class="form-group">
					@for($i = 0; $i < 4; $i++)
					<span class="star-picture star-picture-square star-mr-10" style="background-image:url({{isset($pictures[$i]['picture']) && $pictures[$i]['picture'] ? $pictures[$i]['picture'] : '/images/star-upload-image.png'}});">
						<i class="star-picture-bd" onclick="starPicture('product', 'pictures[{{$i}}][picture]');"></i>
						<input type="hidden" name="pictures[{{$i}}][id]" value="{{isset($pictures[$i]['id'])?$pictures[$i]['id']:''}}">
						<input type="hidden" name="pictures[{{$i}}][picture]" value="{{isset($pictures[$i]['picture'])?$pictures[$i]['picture']:''}}" />
						<input type="hidden" name="pictures[{{$i}}][position]" value="{{isset($pictures[$i]['position'])?$pictures[$i]['position']:$i}}" />
					</span>
					@endfor
				</div>
			</div>
		</div>
		<div class="form-group">
			<label>规格：</label>
			<div class="form-group star-mb-10">
				<button type="button" class="btn btn-secondary btn-sm" onclick="starSpecificationAdd();">添加规格</button>
			</div>
			<table class="table table-condensed table-hover star-table-specification">
				<thead>
					<tr>
						<th>图片</th>
						<th>名称</th>
						<th>SKU</th>
						<th>市场价</th>
						<th>销售价</th>
						<th>成本价</th>
						<th>库存数量</th>
						<th>排序</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					@if($specifications)
					<?php $i = 0;?>
					@foreach($specifications as $item)
					<tr>
						<td>
							<span class="star-picture star-picture-square star-mr-10" style="background-image:url({{isset($item['picture']) && $item['picture'] ? $item['picture'] : '/images/star-upload-image.png'}});">
								<i class="star-picture-bd" onclick="starPicture('product', 'specifications[{{$i}}][picture]');"></i>
								<i class="star-picture-ft"></i>
								<input class="form-control" type="hidden" name="specifications[{{$i}}][picture]" value="{{$item['picture']}}" autocomplete="off">
							</span>
						</td>
						<td><input class="form-control input-sm text-center" type="text" name="specifications[{{$i}}][name]" value="{{$item['name']}}" autocomplete="off"></td>
						<td><input class="form-control input-sm text-center" type="text" name="specifications[{{$i}}][sku]" value="{{$item['sku']}}" autocomplete="off"></td>
						<td><input class="form-control input-sm text-center" type="text" name="specifications[{{$i}}][market]" value="{{$item['market']}}" autocomplete="off" data-type="price"></td>
						<td><input class="form-control input-sm text-center" type="text" name="specifications[{{$i}}][selling]" value="{{$item['selling']}}" autocomplete="off" data-type="price"></td>
						<td><input class="form-control input-sm text-center" type="text" name="specifications[{{$i}}][cost]" value="{{$item['cost']}}" autocomplete="off" data-type="price"></td>
						<td><input class="form-control input-sm text-center" type="text" name="specifications[{{$i}}][quantity]" value="{{$item['quantity']}}" autocomplete="off" data-type="number"></td>
						<td><input class="form-control input-sm text-center" type="text" name="specifications[{{$i}}][position]" value="{{$item['position']}}" autocomplete="off" data-type="number"></td>
						<td>
							<button type="button" class="btn btn-secondary btn-sm" onclick="starSpecificationDelete(this, {{$item['id']}});">删除规格</button>
							<input type="hidden" name="specifications[{{$i}}][id]" value="{{$item['id']}}">
						</td>
					</tr>
					<?php $i++; ?>
					@endforeach
					@endif
				</tbody>
			</table>
		</div>
		<div class="form-group">
			<label for="content">详情：</label>
			<textarea class="textarea" id="description"/>{{isset($product['description'])?$product['description']:''}}</textarea>
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
			<label>状态：</label>
			<div class="radio">
				<label class="radio-inline">
					<input type="radio" name="state" value="1" {{!isset($product['state']) || $product['state']==1?'checked':''}}>启用
				</label>
				<label class="radio-inline">
					<input type="radio" name="state" value="0" {{isset($product['state']) && $product['state']==0?'checked':''}}>禁用
				</label>
			</div>
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-secondary" onclick="starCancelJump();">取消</button>
			<button type="button" class="btn btn-primary" onclick="starProductStore();">保存</button>
		</div>
		<input type="hidden" id="id" name="id" value="{{$product['id']}}">
	</form>
</div>
@include('backend.common.foot')
<script src="/packages/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	CKEDITOR.replace('description', {height: 500, filebrowserUploadUrl: '{{url('/admin/upload/index')}}?upload_place=product&upload_object=editor&_token={{csrf_token()}}',});
</script>
</body>
</html>