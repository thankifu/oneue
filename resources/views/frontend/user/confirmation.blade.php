@extends('frontend.common.index')

@section('style')
@endsection

@section('body')

<div class="container star-user star-mb-25">
    <ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li><a href="/user">用户中心</a></li>
        <li class="active">安全验证</li>
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
                        <label class="sr-only" for="password">密码</label>
                        <input class="form-control" type="password" id="password" name="password" value="" placeholder="请输入登录密码" autocomplete="off">
                    </div>
                    <div class="form-group col-md-12 text-center">
                        <button type="button" class="btn btn-primary" onclick="starConfirmation();">验证</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')
@endsection