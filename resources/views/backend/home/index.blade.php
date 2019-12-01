<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>后台管理 - {{$_site['name']}}</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body class="{{$_side}}">

<header class="sl-header navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><span>ONEUE</span></a>
            <a class="sl-header-item sl-ml-10" href="javascript:void(0);" onclick="slSide();"><span class="glyphicon{{$_side?' glyphicon-indent-right':' glyphicon-indent-left'}} sl-side-state"></span></a>
            <a class="sl-header-item" href="javascript:void(0);"><span class="glyphicon glyphicon-home"></span></a>
        </div>
        <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">
            <!-- <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form> -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$_admin['username']}} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">资料修改</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/admin/logout">退出</a></li>
                    </ul>
                </li>
            </ul>
            
        </div>
    </div>
</header>
<div class="container-fluid row">
    <aside class="sl-side">
        <nav>
            <ul class="nav nav-stacked">
                @foreach($_menus as $menu)
                <li{!!isset($menu['children'])?' class="dropdown"':''!!}>
                    <a href="javascript:void(0);" data="{{$menu['url']}}" controller="{{$menu['controller']}}" action="{{$menu['action']}}" onclick="menuClick(this)"{!!isset($menu['children'])?' class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"':''!!}>
                        <i class="icon fa {{$menu['icon']}}"></i>
                        <span class="text">{{$menu['name']}}</span>
                        @if(isset($menu['children']))
                        <span class="caret"></span>
                        @endif
                    </a>

                    @if(isset($menu['children']))
                    <ul class="dropdown-menu">
                        @foreach($menu['children'] as $child)
                        <li><a href="javascript:void(0);" data="{{$child['url']}}" controller="{{$child['controller']}}" action="{{$child['action']}}" onclick="menuClick(this)"><span class="text">{{$child['name']}}</span></a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            </ul>
        </nav>
    </aside>
    <main class="sl-main embed-responsive ">
        <iframe class="sl-main-iframe" src="/admin/home/welcome" frameborder="0" scrolling="auto"></iframe>
    </main>
</div>
<footer class="sl-footer navbar navbar-default navbar-fixed-bottom">
    <div class="container-fluid row">
        <p class="navbar-text text-lowercase">© 2015-2019 福州星科创想网络科技有限公司 版权所有</p>
    </div>
</footer>
@include('backend.common.foot')
<script type="text/javascript">
    menuInit();
</script>
</body>
</html>