@extends('frontend.common.index')

@section('style')
@endsection

@section('body')
<div class="container star-user star-mb-25">
    <ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li><a href="/user">用户中心</a></li>
        
    </ol>
    <div class="row">

        <div class="col-md-3 star-side">
            @include('frontend.user.center')
        </div>

        <div class="col-md-9 star-main">
        	<form class="row">
				<div class="form-group col-md-6">
					<label for="name">收货姓名：</label>
					<input class="form-control" type="text" id="name" name="name" value="{{$address['name']}}" placeholder="请输入收货姓名" autocomplete="off">
				</div>
				<div class="form-group col-md-6">
					<label for="phone">收货电话：</label>
					<input class="form-control" type="tel" id="phone" name="phone" value="{{$address['phone']}}" placeholder="请输入收货电话" autocomplete="off">
				</div>
				<div class="form-group col-md-12">
					<label for="content">详细地址：</label>
					<textarea class="form-control" id="content" name="content" placeholder="请输入详细地址" rows="3" style="resize:none">{{$address['content']}}</textarea>
				</div>
				<div class="form-group col-md-12">
				<div class="checkbox">
	                <label>
	                    <input type="checkbox" id="default" name="default"{{$address['default']===1 || !isset($address['default'])?' checked':''}}> 默认地址
	                </label>
	            </div>
	            </div>
	            <div class="form-group col-md-12 text-center">
					<button type="button" class="btn btn-primary" onclick="starAddressStore();">保存</button>
					<input type="hidden" value="{{$address['id']}}" id="id" name="id"/>
					{{csrf_field()}}
				</div>
			</form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">

    function starAddressStore(){
    	var id = $.trim($('input[name="id"]').val());
		var name = $.trim($('input[name="name"]').val());
		var phone = $.trim($('input[name="phone"]').val());
		var content = $.trim($('textarea[name="content"]').val());
    	if(name == ''){
			starToast('fail', '请输入收货姓名');
			return;
		}
		if(phone==''){
			starToast('fail', '请输入收货电话');
			return;
		}
		if(content==''){
			starToast('fail', '请输入详细地址');
			return;
		}

        var data = $('form').serialize();
        var defaulted = $('input[name="default"]').is(':checked')?1:0;
		data += '&default=' + defaulted;
		$.post('/user/address/store',data,function(res){
			if(res.code === 200){
				starToast('success', res.text);
				setTimeout(function(){
					if( redirect_url !=null && redirect_url.toString().length>1 ) {
				        window.location.href = '/user/address?redirect_url='+redirect_url;
				    }else{
				        window.location.href = '/user/address';
				    }
				},1000);
			}else{
				starToast('fail', res.text);
			}
		},'json');

    };

</script>
@endsection