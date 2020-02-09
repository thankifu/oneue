<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>文章分类</title>
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
			<button type="button" class="btn btn-sm btn-default" onclick="starGoto('article/category', {{$back}});">返回上一级</button>
			@endif
			<button type="button" class="btn btn-sm btn-primary" onclick="starShow('article/category', 0, {{$parent}});">新增</button>
		</div>
	</div>

	{{csrf_field()}}
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th width="50" class="star-text-center">ID</th>
				<th width="50" class="star-text-center">排序</th>
				<th width="200">名称</th>
				<th width="200">SEO标题</th>
				<th width="300">SEO关键词</th>
				<th width="180">创建时间</th>
				<th width="180">修改时间</th>
				<th width="100" class="star-text-center">状态</th>
				<th width="340">操作</th>
			</tr>
		</thead>
		@if($lists)
		<tbody>
			@foreach($lists as $item)
			<tr>
				<td class="star-text-center">{{$item['id']}}</td>
				<td class="star-text-center">{{$item['position']}}</td>
				<td>{{$item['name']}}</td>
				<td>{{$item['seo_title']?$item['seo_title']:'-'}}</td>
				<td>{{$item['seo_keywords']?$item['seo_keywords']:'-'}}</td>
				<td>{{$item['created']?date('Y-m-d H:i:s',$item['created']):'-'}}</td>
				<td>{{$item['modified']?date('Y-m-d H:i:s',$item['modified']):'-'}}</td>
				<td class="star-text-center">{!!$item['state']==1?'<span class="label label-success">启用</span>':'<span class="label label-danger">禁用</span>'!!}</td>
				<td>
					<button type="button" class="btn btn-sm btn-default" onclick="starGoto('article/category', {{$item['id']}});">子分类</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="starShow('article/category', {{$item['id']}}, {{$parent}});">编辑</button>
					<button type="button" class="btn btn-sm btn-secondary" onclick="starDelete('article/category', {{$item['id']}});">删除</button>
				</td>
			</tr>
			@endforeach
		</tbody>
		@endif
		@if(!$lists)
		<tbody>
			<tr>
				<td class="text-center" colspan="9">没有数据</td>
			</tr>
		</tbody>
		@endif
		<tfoot>
			<td colspan="9">
				<div class="pull-left">
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