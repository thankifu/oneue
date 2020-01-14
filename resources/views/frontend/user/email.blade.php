@extends('frontend.common.index')

@section('style')
@endsection

@section('body')

<div class="container star-user star-mb-25">
    <ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li><a href="/user">用户中心</a></li>
        <li class="active">邮箱修改</li>
    </ol>
    <div class="row">

        <div class="col-md-3 star-side hidden-sm hidden-xs">
            @include('frontend.user.side')
        </div>

        <div class="col-md-9 star-main">
            <div class="row">
                <form id="form" class="col-md-6 col-md-offset-3 col-md-offset-3">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="sr-only" for="email">邮箱</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="text" class="form-control" id="email" name="email" value="" placeholder="请输入新邮箱" autocomplete="off" onkeyup="starCheckEmail(this.value);">
                        </div>       
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-7">
                            <label class="sr-only" for="email_code">验证码</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span>
                                <input type="text" class="form-control" id="email_code" name="email_code" value="" placeholder="请输入验证码" autocomplete="off">
                            </div>       
                        </div>
                        <div class="form-group col-xs-5">
                            <button type="button" class="btn btn-block" name="email_send" disabled onclick="starSendEmail(this);">获取验证码</button>
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <button type="button" class="btn btn-primary" onclick="starEmailStore();">保存</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection