<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>操作日志</title>
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
					<label for="ip">IP：</label>
					<input type="text" class="form-control" name="ip" value="{{request()->get('ip')}}" placeholder="请输入IP">
				</div>
				<div class="form-group form-group-sm star-mr-10">
					<label for="abstract">摘要：</label>
					<input type="text" class="form-control" name="abstract" value="{{request()->get('abstract')}}" placeholder="请输入摘要">
				</div>
				<div class="form-group form-group-sm star-mr-10">
					<label for="admin_id">管理员：</label>
					<select class="form-control" id="admin_id" name="admin_id" autocomplete="off">
						<option value="">请选择</option>
						@foreach($admins as $item)
						<option value="{{$item['id']}}" {{request()->get('admin_id') == $item['id']?'selected':''}}>{{$item['username']}}</option>
						@endforeach
					</select>
				</div>
				<button type="submit" class="btn btn-sm btn-default">查询</button>
			</form>
		</div>
	</div>

	{{csrf_field()}}
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th class="star-text-left">管理员</th>
				<th class="star-text-left">摘要</th>
				<th class="star-text-left">IP</th>				
				<th>时间</th>
			</tr>
		</thead>
		@if($lists)
		<tbody>
			@foreach($lists as $item)
			<tr>
				<td>{{$item['id']}}</td>
				<td class="star-text-left">{{isset($admins[$item['admin_id']])?$admins[$item['admin_id']]['username']:'-'}}</td>
				<td class="star-text-left">{{$item['abstract']}}</td>
				<td class="star-text-left">{{$item['ip']}}</td>
				<td>{{$item['created']?date('Y-m-d H:i:s',$item['created']):'-'}}</td>
			</tr>
			@endforeach
		</tbody>
		@endif
		@if(!$lists)
		<tbody>
			<tr>
				<td class="text-center" colspan="5">啊~没有诶！</td>
			</tr>
		</tbody>
		@endif
		<tfoot>
			<td colspan="5">
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