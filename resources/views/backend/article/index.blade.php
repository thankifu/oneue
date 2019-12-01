@extends('backend.common.index')

@section('body')
<div class="body-content">
	<div class="body-container">
		<div class="body-hd">
			<div class="body-hd-left">
				<div class="body-hd-title">文章管理</div>
			</div>
			<div class="body-hd-right">
				<a class="body-hd-btn" href="javascript:void(0);" onclick="articleAdd();">新增</a>
			</div>
		</div>
		<div class="body-bd">
			<div class="body-filter">
				<form method="get" action="">
					<div class="body-filter-item mr-20">
						<label>文章标题：</label>
						<input type="text" name="title" value="{{request()->get('title')}}" placeholder="请输入文章标题进行模糊搜索"/>
					</div>
					<div class="body-filter-item mr-20">
						<label>文章分类：</label>
						<select id="category_id" name="category_id" autocomplete="off">
							<option value="">请选择</option>
							@foreach($categories as $item)
							<option value="{{$item['id']}}" {{request()->get('category_id') == $item['id']?'selected':''}}>{{$item['name']}}</option>
							@endforeach
						</select>
					</div>
					<input class="button body-filter-btn" type="submit" value="查询"/>
				</form>
			</div>
			<div class="body-list">
				{{csrf_field()}}
				<table class="table">
					<thead>
						<tr>
							<th width="10"><input type="checkbox"/></th>
							<th>ID</th>
							<th>图片</th>
							<th class="text-left">标题</th>
							<th>分类</th>
							<th>发布时间</th>
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
							<td><img src="{{$item['picture']}}" height="70"></td>
							<td class="text-left">{{$item['title']}}</td>
							<td>{{isset($categories[$item['category_id']])?$categories[$item['category_id']]['name']:''}}</td>
							<td>{{$item['created']?date('Y-m-d H:i:s',$item['created']):'-'}}</td>
							<td>{!!$item['state']==1?'<span class="green">正常</span>':'<span class="red">禁用</span>'!!}</td>
							<td>
								<a class="btn" href="javascript:void(0);" onclick="articleAdd({{$item['id']}});">修改</a>
								<a class="btn" href="javascript:void(0);" onclick="articleDelete({{$item['id']}});">删除</a>
							</td>
						</tr>
						@endforeach
					</tbody>
					@endif
					@if(!$lists)
					<tbody>
						<tr>
							<td colspan="8">啊~没有诶！</td>
						</tr>
					</tbody>
					@endif
				</table>
				
					
				<table class="table table-fixed">
					<tfoot>
						<td width="10"><input type="checkbox"/></td>
						<td colspan="7">
							<div class="left">
								<button class="button" disabled="disabled">禁用</button>
								<button class="button">启用</button>
							</div>
							<div class="right">
								{{$links}}
							</div>
						</td>
					</tfoot>
				</table>
				
			</div>
		</div>
	</div>
</div>
@endsection