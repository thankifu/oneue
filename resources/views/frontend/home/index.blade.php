<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>首页</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="/packages/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/packages/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="/packages/swiper/css/swiper.min.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link href="/css/frontend.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="star-header navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#star-header-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
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
                <li><a href="#">首页</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">图文 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">分类1</a></li>
                        <li><a href="#">分类2</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">商品 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">分类1</a></li>
                        <li><a href="#">分类2</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="请输入关键字">
                </div>
                <button type="submit" class="btn btn-default"><i class="fa fa-search hidden-xs" aria-hidden="true"></i><span class="hidden-sm hidden-md hidden-lg">搜索</span></button>
            </form>
            
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row star-slides">
        <div class="swiper-container">
            <ul class="list-unstyled swiper-wrapper">
                <li class="swiper-slide">
                    <a href="" style="background-image:url(https://www.oneue.com/images/slide-1.jpg);" title="">
                        <div class="star-title">欢迎光临</div>
                        <div class="star-content">精致生活、从ONEUE开始，给生活来一点不一样的色彩！</div>
                    </a>
                </li>
            </ul>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="container star-floor">
        <div class="clearfix star-hd">
            <div class="pull-left">
                <a href="/"><h2>新品上市</h2></a>
            </div>
            <div class="pull-right">
                <a href="/">查看更多<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
            </div>
        </div>
        <div class="row star-bd">
            <ul class="list-unstyled star-list-product">
                <li class="col-md-2">
                    <a href="products/386.html" title="PHP 用户注册登录功能源码程序">
                        <p class="star-image">
                            <img src="https://img.starslabs.com/uploads/ea05ba640939b653/9d9032ad7ca2bb9b.jpg" data-original="" alt="PHP 用户注册登录功能源码程序"/>
                            <span class="star-heart"><i class="fa fa-heart-o" aria-hidden="true"></i></span>
                        </p>
                        <p class="star-title">PHP 用户注册登录功能源码程序</p>
                        <p class="star-price">
                            <span class="star-normal"><i>¥</i><em>10.00</em></span>
                            <span class="star-line-through"><i>¥</i><em>0.00</em></span>
                        </p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container star-floor">
        <div class="clearfix star-hd">
            <div class="pull-left">
                <a href="/"><h2>新品上市</h2></a>
            </div>
            <div class="pull-right">
                <a href="/">查看更多<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
            </div>
        </div>
        <div class="row star-bd">
            <ul class="list-unstyled star-list-article">
                <li class="col-md-4">
                    <a href="articles/252.html" title="Prada x Midori 推出限量系列">
                        <p class="star-image">
                            <img src="https://img.starslabs.com/uploads/f5135aaf84b693b8/64651bf0a9776a1d.jpg?x-oss-process=image/resize,m_fill,w_600,h_320" data-original="" alt="Prada x Midori 推出限量系列" />
                            <span class="star-heart"><i class="fa fa-heart-o" aria-hidden="true"></i></span>
                            <span class="star-views"><i class="fa fa-eye" aria-hidden="true"></i>1</span>
                        </p>
                        <p class="star-title">Prada x Midori 推出限量系列</p>
                        <p class="star-conte">各种跨界联乘在现今的时尚圈已经屡见不鲜，不过 Prada 稍早所宣布，与来自日本的文具品牌 Midori（ミドリ）所推出的文具系…</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container star-floor">
        <div class="clearfix star-hd">
            <div class="pull-left">
                <a href="/"><h2>新品上市</h2></a>
            </div>
            <div class="pull-right">
                <a href="/">查看更多<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>
            </div>
        </div>
        <div class="row star-bd">
            <ul class="list-unstyled star-list-special">
                <li class="col-md-4">
                    <a href="specials/6.html" title="七夕">
                        <p class="star-image">
                            <img src="https://img.starslabs.com/uploads/0000000000000old/o_1cioho36gcmg6nv1v6acsu1ijrp.jpg?x-oss-process=image/resize,m_fill,w_600,h_243" data-original="" alt="七夕" />
                        </p>
                        <p class="star-title">七夕</p>
                        <p class="star-mask"></p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- <div class="star-main">
    <div class="floor container">
    </div>
</div> -->

<div class="star-footer">
    <div class="container">
        <div class="star-help row">
            <div class="col-md-3 col-xs-6">
                <dl>
                    <dt>购物</dt>
                    <dd><a href="/helps/1.html"><i class="fa fa-file-text" aria-hidden="true"></i>会员注册</a></dd>
                    <dd><a href="/helps/2.html"><i class="fa fa-file-text" aria-hidden="true"></i>购物流程</a></dd>
                    <dd><a href="/helps/3.html"><i class="fa fa-file-text" aria-hidden="true"></i>支付方式</a></dd>
                    <dd><a href="/helps/4.html"><i class="fa fa-file-text" aria-hidden="true"></i>物流配送</a></dd>
                </dl>
            </div>
            <div class="col-md-3 col-xs-6">
                <dl>
                    <dt>购物</dt>
                    <dd><a href="/helps/1.html"><i class="fa fa-file-text" aria-hidden="true"></i>会员注册</a></dd>
                    <dd><a href="/helps/2.html"><i class="fa fa-file-text" aria-hidden="true"></i>购物流程</a></dd>
                    <dd><a href="/helps/3.html"><i class="fa fa-file-text" aria-hidden="true"></i>支付方式</a></dd>
                    <dd><a href="/helps/4.html"><i class="fa fa-file-text" aria-hidden="true"></i>物流配送</a></dd>
                </dl>
            </div>
            <div class="col-md-3 col-xs-6">
                <dl>
                    <dt>购物</dt>
                    <dd><a href="/helps/1.html"><i class="fa fa-file-text" aria-hidden="true"></i>会员注册</a></dd>
                    <dd><a href="/helps/2.html"><i class="fa fa-file-text" aria-hidden="true"></i>购物流程</a></dd>
                    <dd><a href="/helps/3.html"><i class="fa fa-file-text" aria-hidden="true"></i>支付方式</a></dd>
                    <dd><a href="/helps/4.html"><i class="fa fa-file-text" aria-hidden="true"></i>物流配送</a></dd>
                </dl>
            </div>
            <div class="col-md-3 col-xs-6">
                <dl>
                    <dt>购物</dt>
                    <dd><a href="/helps/1.html"><i class="fa fa-file-text" aria-hidden="true"></i>会员注册</a></dd>
                    <dd><a href="/helps/2.html"><i class="fa fa-file-text" aria-hidden="true"></i>购物流程</a></dd>
                    <dd><a href="/helps/3.html"><i class="fa fa-file-text" aria-hidden="true"></i>支付方式</a></dd>
                    <dd><a href="/helps/4.html"><i class="fa fa-file-text" aria-hidden="true"></i>物流配送</a></dd>
                </dl>
            </div>
        </div>
        <div class="star-copy"><p>© ONEUE 2017 - 2019 ALL RIGHTS RESERVED.</p><p><a rel="nofollow" target="_blank" href="http://www.miitbeian.gov.cn/">闽ICP备15017742号</a></p></div>
    </div>
</div>

<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/packages/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/packages/bootbox/bootbox.min.js"></script>
<script type="text/javascript" src="/packages/swiper/js/swiper.min.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript">
    var mySwiper1 = new Swiper ('.star-slides .swiper-container', {
        direction: 'horizontal', // 垂直切换选项
        loop: true, // 循环模式选项
    
        // 如果需要分页器
        pagination: {
        el: '.swiper-pagination',
        },
    });
</script>
</body>
</html>