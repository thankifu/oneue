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
<div class="container-fluid star-main-font">
	<div class="clearfix star-mt-20 star-mb-20">
		<div class="pull-left">
			<form class="form-inline" method="get">
				<div class="form-group form-group-sm star-mr-10">
					<label for="username">文章标题：</label>
					<input type="text" class="form-control" name="title" value="{{request()->get('title')}}" placeholder="请输入标题">
				</div>
				<div class="form-group form-group-sm star-mr-10">
					<label for="category_id">文章分类：</label>
					<select class="form-control" id="category_id" name="category_id" autocomplete="off">
						<option value="0">请选择</option>
						@foreach($categories as $item)
						<option value="{{$item['id']}}" {{request()->get('category_id') == $item['id']?'selected':''}}>{{$item['name']}}</option>
						@endforeach
					</select>
				</div>
				<button type="submit" class="btn btn-sm btn-default">查询</button>
			</form>
		</div>
		<div class="pull-right">
			<button type="button" class="btn btn-sm btn-primary" onclick="starShowJump('article');">新增</button>
		</div>
	</div>

	{{csrf_field()}}
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th width="50" class="star-text-center">ID</th>
				<th width="220">图片</th>
				<th width="300">标题</th>
				<th width="100">作者</th>
				<th width="100">分类</th>
				<th width="180">时间</th>
				<th width="100">访问量</th>
				<th width="100" class="star-text-center">状态</th>
				<th width="200">操作</th>
			</tr>
		</thead>
		@if($lists)
		<tbody>
			@foreach($lists as $item)
			<tr>
				<td class="star-text-center">{{$item['id']}}</td>
				<td>
					<span class="star-picture-rectangle" style="background-image:url({{$item['picture']}});"></span>
				</td>
				<td class="star-text-left">{{$item['title']}}</td>
				<td class="star-text-left">{{$item['author']?$item['author']:'-'}}</td>
				<td>{{isset($categories[$item['category_id']])?$categories[$item['category_id']]['name']:'-'}}</td>
				<td class="star-text-left">
					创建 {{$item['created']?date('Y-m-d H:i:s',$item['created']):'-'}}<br/>
					修改 {{$item['modified']?date('Y-m-d H:i:s',$item['modified']):'-'}}
				</td>
				<td>{{$item['visit']}}</td>
				<td class="star-text-center">{!!$item['state']==1?'<span class="label label-success">启用</span>':'<span class="label label-danger">禁用</span>'!!}</td>
				<td>
					<button type="button" class="btn btn-sm btn-primary" onclick="starShowJump('article', {{$item['id']}});">编辑</button>
					<button type="button" class="btn btn-sm btn-secondary" onclick="starDelete('article', {{$item['id']}});">删除</button>
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
					{{$links}}
				</div>
			</td>
		</tfoot>
	</table>

</div>
@include('backend.common.foot')
</body>
</html>