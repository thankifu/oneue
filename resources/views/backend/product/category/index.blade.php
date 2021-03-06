<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>商品分类</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">
	<div class="clearfix star-mt-20 star-mb-20">
		<div class="pull-left">
			<form class="form-inline" method="get">
				<div class="form-group form-group-sm star-mr-10">
					<label for="name">名称：</label>
					<input type="text" class="form-control" name="name" value="{{request()->get('name')}}" placeholder="请输入名称" autocomplete="off">
				</div>
				<div class="form-group form-group-sm star-mr-10">
					<label for="state">状态：</label>
					<select class="form-control" id="state" name="state" autocomplete="off">
						<option value="">请选择</option>
						<option value="0" {{request()->get('state') == 0 && request()->get('state') != ''?'selected':''}}>禁用</option>
						<option value="1" {{request()->get('state') == 1?'selected':''}}>正常</option>
					</select>
				</div>
				<button type="submit" class="btn btn-sm btn-default">查询</button>
			</form>
		</div>
		<div class="pull-right">
			@if($parent)
			<button type="button" class="btn btn-sm btn-default" onclick="starGoto('product/category', {{$back}});">返回上一级</button>
			@endif
			<button type="button" class="btn btn-sm btn-primary" onclick="starShow('product/category', 0, {{$parent}});">新增</button>
		</div>
	</div>

	{{csrf_field()}}
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th width="10"><input type="checkbox"/></th>
				<th>ID</th>
				<th>排序</th>
				<th>名称</th>
				<th>SEO标题</th>
				<th>SEO关键词</th>
				<th>修改时间</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>
		@if($lists)
		<tbody>
			@foreach($lists as $item)
			<tr>
				<td width="10"><input type="checkbox"/></td>
				<td>{{$item['id']}}</td>
				<td>{{$item['position']}}</td>
				<td>{{$item['name']}}</td>
				<td>{{$item['seo_title']?$item['seo_title']:'-'}}</td>
				<td>{{$item['seo_keywords']?$item['seo_keywords']:'-'}}</td>
				<td>{{$item['modified']?date('Y-m-d H:i:s',$item['modified']):'-'}}</td>
				<td>{!!$item['state']==1?'<span class="label label-success">启用</span>':'<span class="label label-danger">禁用</span>'!!}</td>
				<td>
					<button type="button" class="btn btn-sm btn-default" onclick="starGoto('product/category', {{$item['id']}});">子分类</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="starShow('product/category', {{$item['id']}}, {{$parent}});">编辑</button>
					<button type="button" class="btn btn-sm btn-secondary" onclick="starDelete('product/category', {{$item['id']}});">删除</button>
				</td>
			</tr>
			@endforeach
		</tbody>
		@endif
		@if(!$lists)
		<tbody>
			<tr>
				<td class="text-center" colspan="9">啊~没有诶！</td>
			</tr>
		</tbody>
		@endif
		<tfoot>
			<td width="10"><input type="checkbox"/></td>
			<td colspan="8">
				<div class="pull-left">
					<button class="btn btn-sm btn-default" disabled="disabled">禁用</button>
					<button class="btn btn-sm btn-default">启用</button>
				</div>
				<div class="pull-right">
					
				</div>
			</td>
		</tfoot>
	</table>
</div>
@include('backend.common.foot')
</body>
</html>