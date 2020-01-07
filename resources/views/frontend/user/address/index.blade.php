@extends('frontend.common.index')

@section('style')
@endsection

@section('body')
<div class="container star-user star-mb-25">
    <ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li><a href="/user">用户中心</a></li>
        <li class="active">收货地址</li>
    </ol>
    <div class="row">

        <div class="col-md-3 star-side">
            @include('frontend.user.center')
        </div>

        <div class="col-md-9 star-main">

            <div class="star-trade"> 
                <div class="star-address">
                    <div class="star-bd">
                        <dt>地址列表</dt>
                        @if($address)
                        <dl>
                            @foreach($address as $item)
                            <dd>
                                <div class="star-text"{!!request()->get('redirect_url')?' style="cursor:pointer;" onclick="starCheckoutAddress('.$item['id'].')"':''!!}>
                                    <p><span class="star-name">{{$item['name']}}</span><span class="phone">{{$item['phone']}}</span></p>
                                    <p>{{$item['content']}}</p>
                                </div>
                                <div class="star-icon">
                                    <a href="javascript:void(0);" onclick="starAddressCreate({{$item['id']}});">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    </a>
                                </div>
                            </dd>
                            @endforeach
                        </dl>
                        @else
                        <dl class="star-list-no">
                            <dd>暂无记录诶～</dd>
                        </dl>
                        @endif
                    </div>
                </div>
                <div class="star-actions text-center">
                    <button type="button" class="btn btn-primary" onclick="starAddressCreate(0);">新增收货地址</button>
                    {{csrf_field()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
function starAddressCreate(id){
    if( redirect_url !=null && redirect_url.toString().length>1 ) {
        window.location.href = '/user/address/'+id+'?redirect_url='+redirect_url;
    }else{
        window.location.href = '/user/address/'+id;
    }
}
function starCheckoutAddress(id){
    starToast('loading', '请稍后...', 0);
    var data = new Object();
    data._token = $('input[name="_token"]').val();
    data.id = id;

    $.post('/checkout/address',data,function(res){
        if(res.code === 200){
            bootbox.hideAll();
            if( redirect_url !=null && redirect_url.toString().length>1 ) {
                window.location.href = decodeURI(redirect_url);
            }else{
                window.location.href = '/user/address';
            }
            return;
        }else{
            bootbox.hideAll();
            starToast('fail', res.text);
        }
    },'json');
}
</script>
@endsection