<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>订单发货</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">
	<form>
		{{csrf_field()}}
		<div class="form-group">
			<label for="express_id">快递公司：</label>
			<select class="form-control" id="express_id" name="express_id" autocomplete="off">
				<option value="">请选择</option>
				@foreach($expresses as $item)
				<option value="{{$item['id']}}" {{$order['express_id'] == $item['id']?'selected':''}}>{{$item['name']}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="express_no">快递单号：</label>
			<input class="form-control" type="text" id="express_no" name="express_no" value="{{$order['express_no']}}"  placeholder="快递单号" autocomplete="off">
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-secondary" onclick="starCancel();">取消</button>
			<button type="button" class="btn btn-primary" onclick="starShipmentStore();">保存</button>
		</div>
		<input type="hidden" id="id" name="id" value="{{$order['id']}}">
	</form>
</div>
@include('backend.common.foot')
</body>
</html>