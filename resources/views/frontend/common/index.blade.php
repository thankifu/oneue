<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>{{$page_title}}</title>
<meta name="keywords" content="{{$page_keywords}}" />
<meta name="description" content="{{$page_description}}" />
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
                <h1 class="title hidden-xs">{{$_site['name']}}</h1>
                <h2 class="subtitle hidden-xs">{{$_site['title']}}</h2>
                <span>ONEUE</span>
            </a>
        </div>
        <div class="navbar-collapse collapse" id="star-header-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/">首页</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">文章 <span class="caret"></span></a>
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
                        <li><a href="javascript:void(0);" onclick="starLogout();">退出</a>{{csrf_field()}}</li>
                    </ul>
                </li>
                @else
                <li><a href="javascript:void(0);" onclick="starGotoLogin();">登录</a></li>
                @endif
            </ul>
            <form class="navbar-form" action="/search">
                <div class="form-group">
                    <input type="text" class="form-control" name="keyword" value="{{request()->get('keyword')}}" placeholder="请输入关键字">
                </div>
                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search hidden-xs" aria-hidden="true"></i><span class="hidden-sm hidden-md hidden-lg">搜索</span></button>
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
        @if($_help)
        <div class="star-help row">
            @foreach($_help as $item)
            <div class="col-md-3 col-xs-6">
                <dl>
                    <dt>{{$item['name']}}</dt>
                    @if($item['list'])
                    @foreach($item['list'] as $value)
                    <dd><a href="/help/{{$value['id']}}"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>{{$value['title']}}</a></dd>
                    @endforeach
                    @endif
                </dl>
            </div>
            @endforeach
        </div>
        @endif
        <div class="star-copy"><p>{{$_site['copyright']}}</p><p><a rel="nofollow" target="_blank" href="http://www.miitbeian.gov.cn/">{{$_site['miitbeian']}}</a></p></div>
        
        <div class="navbar navbar-default navbar-fixed-bottom hidden-lg hidden-md hidden-sm star-nav">
            <ul class="list-unstyled">
                <li{!!request()->path()=='/'?' class="star-current"':''!!}>
                    <a href="/">
                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                        <span class="text">首页</span>
                    </a>
                </li>
                <li{!!strstr(request()->path(),'article')?' class="star-current"':''!!}>
                    <a href="/article">
                        <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                        <span class="text">文章</span>
                    </a>
                </li>
                <li{!!strstr(request()->path(),'product')?' class="star-current"':''!!}>
                    <a href="/product">
                        <span class="glyphicon glyphicon-gift" aria-hidden="true"></span>
                        <span class="text">商品</span>
                    </a>
                </li>
                <li{!!request()->path()=='cart'?' class="star-current"':''!!}>
                    <a href="/cart">
                        <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                        <span class="text">购物车</span>
                    </a>
                </li>
                <li{!!strstr(request()->path(),'user')?' class="star-current"':''!!}>
                    <a href="/user">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                        <span class="text">我的</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

@include('frontend.common.foot')
@section('script')
@show
</body>
</html>