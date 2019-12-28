<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>{{$_site['name']}}</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('frontend.common.head')
@section('style')
@show
</head>
<body class="">

<div class="navbar navbar-default star-header">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#star-header-collapse" aria-expanded="false">
                <span class="sr-only">导航切换</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <h1 class="title hidden-xs">ONEUE</h1>
                <h2 class="subtitle hidden-xs">一个简单的购物网站</h2>
                <span>ONEUE</span>
            </a>
        </div>
        <div class="navbar-collapse collapse" id="star-header-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/">首页</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">图文 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach($_article_category as $item)
                        <li><a href="/article/category/{{$item['id']}}">{{$item['name']}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">商品 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach($_product_category as $item)
                        <li><a href="/product/category/{{$item['id']}}">{{$item['name']}}</a></li>
                        @endforeach
                    </ul>
                </li>
                @if(auth()->check()) 
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">我的 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/user/order">我的订单</a></li>
                        <li><a href="/user/setting">账户设置</a></li>
                        <li><a href="javascript:void(0);" onclick="logout();">退出</a>{{csrf_field()}}</li>
                    </ul>
                </li>
                @else
                <li><a href="javascript:void(0);" onclick="starGotoLogin();">登录</a></li>
                @endif
            </ul>
            <form class="navbar-form">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="请输入关键字">
                </div>
                <button type="submit" class="btn btn-default"><i class="fa fa-search hidden-xs" aria-hidden="true"></i><span class="hidden-sm hidden-md hidden-lg">搜索</span></button>
            </form>
            <div class="star-header-cart hidden-xs">
                <a href="javascript:void(0);" onclick="starGotoCart();">
                    <span class="star-count">{{$_cart['count']}}</span>
                    <span class="star-icon glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                </a>
            </div>
        </div>
    </div>
</div>

@section('body')
@show

<div class="star-footer">
    <div class="container">
        <div class="star-help row">
            <div class="col-md-3 col-xs-6">
                <dl>
                    <dt>购物</dt>
                    <dd><a href="/helps/1.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>会员注册</a></dd>
                    <dd><a href="/helps/2.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>购物流程</a></dd>
                    <dd><a href="/helps/3.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>支付方式</a></dd>
                    <dd><a href="/helps/4.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>物流配送</a></dd>
                </dl>
            </div>
            <div class="col-md-3 col-xs-6">
                <dl>
                    <dt>购物</dt>
                    <dd><a href="/helps/1.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>会员注册</a></dd>
                    <dd><a href="/helps/2.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>购物流程</a></dd>
                    <dd><a href="/helps/3.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>支付方式</a></dd>
                    <dd><a href="/helps/4.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>物流配送</a></dd>
                </dl>
            </div>
            <div class="col-md-3 col-xs-6">
                <dl>
                    <dt>购物</dt>
                    <dd><a href="/helps/1.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>会员注册</a></dd>
                    <dd><a href="/helps/2.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>购物流程</a></dd>
                    <dd><a href="/helps/3.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>支付方式</a></dd>
                    <dd><a href="/helps/4.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>物流配送</a></dd>
                </dl>
            </div>
            <div class="col-md-3 col-xs-6">
                <dl>
                    <dt>购物</dt>
                    <dd><a href="/helps/1.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>会员注册</a></dd>
                    <dd><a href="/helps/2.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>购物流程</a></dd>
                    <dd><a href="/helps/3.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>支付方式</a></dd>
                    <dd><a href="/helps/4.html"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>物流配送</a></dd>
                </dl>
            </div>
        </div>
        <div class="star-copy"><p>{{$_site['copyright']}}</p><p><a rel="nofollow" target="_blank" href="http://www.miitbeian.gov.cn/">{{$_site['miitbeian']}}</a></p></div>
    </div>
</div>

@include('frontend.common.foot')
@section('script')
@show
</body>
</html>