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

        <div class="col-md-3 star-side">
            @include('frontend.user.center')
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
                        <a href="/user/address">
                            <span class="star-hd">收货地址</span>
                            <span class="star-bd">
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
@endsection