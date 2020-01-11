@extends('frontend.common.index')

@section('style')
@endsection

@section('body')

<div class="container star-user star-mb-25">
    <ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li><a href="/user">用户中心</a></li>
        <li class="active">账户设置</li>
    </ol>
    <div class="row">

        <div class="col-md-3 star-side hidden-sm hidden-xs">
            @include('frontend.user.side')
        </div>

        <div class="col-md-9 star-main">

            <div class="star-setting">
                <ul class="list-unstyled">
                    <!--
                    
                    <li>
                        <a href="">
                            <span class="star-hd">手机</span>
                            <span class="star-bd">
                                <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>  
                            </span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="">
                            <span class="star-hd">邮箱</span>
                            <span class="star-bd">
                                <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>  
                            </span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="">
                            <span class="star-hd">密码</span>
                            <span class="star-bd">
                                <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>  
                            </span>
                        </a>
                    </li> -->

                    <li>
                        <a href="javascript:void(0);" onclick="starSex();">
                            <span class="star-hd">性别</span>
                            <span class="star-bd">
                                <span class="star-text">
                                    @if($user['sex'] == 1)
                                    男
                                    @elseif($user['sex'] == 2)
                                    女
                                    @else
                                    未知
                                    @endif
                                </span>
                                <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" onclick="starAge();">
                            <span class="star-hd">年龄</span>
                            <span class="star-bd">
                                <span class="star-text hidden-sm hidden-xs">{{$user['age']}}</span>
                                <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="/user/address">
                            <span class="star-hd">收货地址</span>
                            <span class="star-bd">
                                <span class="star-text hidden-sm hidden-xs">修改</span>
                                <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>  
                            </span>
                        </a>
                    </li>

                </ul>
            </div>

        </div>



    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
/*性别*/
function starSex(){
    bootbox.prompt({
        size: 'small',
        title: '修改性别',
        required: true,
        value: '{{$user['sex']}}', //默认值
        inputType: 'radio',
        inputOptions: [
            {
                text: '男',
                value: '1',

            },
            {
                text: '女',
                value: '2',
                checked: true,
            },
        ],
        buttons: {
            cancel: {
                label: '取消',
                className: 'btn-secondary'
            },
            confirm: {
                label: '确认'
            }
        },
        callback: function (result) {
            if(result){
                $.post('/user/sex/store',{sex:result,_token:$('input[name="_token"]').val()},function(res){
                    if(res.code === 200){
                        starToast('success', res.text);
                        setTimeout(function(){
                            parent.window.location.reload();
                        },1000);

                    }else{
                        starToast('fail', res.text);
                    }
                },'json');
            }
            //console.log(result);
        }
    });
};

/*年龄*/
function starAge(){
    bootbox.prompt({
        size: 'small',
        title: '修改年龄',
        required: true,
        value: '{{$user['sex']}}', //默认值
        inputType: 'number',
        buttons: {
            cancel: {
                label: '取消',
                className: 'btn-secondary'
            },
            confirm: {
                label: '确认'
            }
        },
        callback: function (result) {
            if(result){
                $.post('/user/age/store',{age:result,_token:$('input[name="_token"]').val()},function(res){
                    if(res.code === 200){
                        starToast('success', res.text);
                        setTimeout(function(){
                            parent.window.location.reload();
                        },1000);

                    }else{
                        starToast('fail', res.text);
                    }
                },'json');
            }
            console.log(result);
        }
    });
};
</script>
@endsection