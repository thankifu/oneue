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
            <div class="star-side-hd">
                <a href="javascript:void(0);">
                    <img src=""/>
                </a>
                <span>用户名</span>
            </div>
            <div class="star-side-bd">
                <ul class="list-unstyled">
                    <li class="star-current">
                        <a href="">
                            <span class="star-text">用户中心</span>
                            <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="star-text">我的订单</span>
                            <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="star-text">账户设置</span>
                            <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>  
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-9 star-main">

            <div class="star-setting">
                <ul class="list-unstyled">
                    <li>
                        <a href="javascript:void(0)">
                            <span class="star-setting-hd">头像</span>
                            <span class="star-setting-bd">
                                <span class="star-avatar"><img src=""/></span>
                                <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>  
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="">
                            <span class="star-setting-hd">用户名</span>
                            <span class="star-setting-bd">
                                <span class="star-text"></span>
                                <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>  
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="">
                            <span class="star-setting-hd">收货地址</span>
                            <span class="star-setting-bd">
                                <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>  
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="">
                            <span class="star-setting-hd">手机</span>
                            <span class="star-setting-bd">
                                <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>  
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="">
                            <span class="star-setting-hd">邮箱</span>
                            <span class="star-setting-bd">
                                <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>  
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="">
                            <span class="star-setting-hd">密码</span>
                            <span class="star-setting-bd">
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