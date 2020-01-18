<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>欢迎</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
@include('backend.common.head')
</head>
<body>
<div class="container-fluid star-main-font">
    <div class="row star-mt-20">
        @if($order_prepaid)
        <div class="col-md-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="pull-left">订单</div>
                    <div class="pull-right"><span class="label label-warning">急</span></div>
                </div>
                <div class="panel-body">
                    <h2>{{$order_prepaid}}/{{$order_total}}</h2>
                    <div class="clearfix">
                        <div class="pull-left">待发货/总数</div>
                        <div class="pull-right"><a class="label label-warning" href="javascript:void(0);" onclick="parent.$('.star-main-iframe').attr('src','/admin/order/index?state=2');">立即处理</a></div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="pull-left">订单</div>
                    <div class="pull-right"><span class="label label-primary">总</span></div>
                </div>
                <div class="panel-body">
                    <h2>{{$order_total}}</h2>
                    <div class="clearfix">
                        <div class="pull-left">总数</div>
                        <div class="pull-right"><a class="label label-primary" href="javascript:void(0);" onclick="parent.$('.star-main-iframe').attr('src','/admin/order/index');">立即查看</a></div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="col-md-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="pull-left">用户</div>
                    <div class="pull-right"><span class="label label-primary">总</span></div>
                </div>
                <div class="panel-body">
                    <h2>{{$user_total}}</h2>
                    <div class="clearfix">
                        <div class="pull-left">总数</div>
                        <div class="pull-right"><a class="label label-primary" href="javascript:void(0);" onclick="parent.$('.star-main-iframe').attr('src','/admin/user/index');">立即查看</a></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="pull-left">商品</div>
                    <div class="pull-right"><span class="label label-primary">总</span></div>
                </div>
                <div class="panel-body">
                    <h2>{{$product_total}}</h2>
                    <div class="clearfix">
                        <div class="pull-left">总数</div>
                        <div class="pull-right"><a class="label label-primary" href="javascript:void(0);" onclick="starShowJump('product');">发布商品</a></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="pull-left">文章</div>
                    <div class="pull-right"><span class="label label-primary">总</span></div>
                </div>
                <div class="panel-body">
                    <h2>{{$article_total}}</h2>
                    <div class="clearfix">
                        <div class="pull-left">总数</div>
                        <div class="pull-right"><a class="label label-primary" href="javascript:void(0);" onclick="starShowJump('article');">发布文章</a></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="pull-left">关于</div>
                    <div class="pull-right"></div>
                </div>
                <div class="panel-body">
                    ONEUE，一个简单的电商系统，更适合个体/小微商户使用的电商系统。
                </div>
                <ul class="list-group">
                    <li class="list-group-item">当前版本：v0.1.0</li>
                    <li class="list-group-item">授权许可：<a href="https://github.com/thankifu/oneue/blob/master/LICENSE" target="_blank">MIT License</a></li>
                    <li class="list-group-item">联系作者：<a href="mailto:i@thankifu.com">i@thankifu.com</a></li>
                    <li class="list-group-item">官方网站：<a href="https://www.oneue.com/" target="_blank">www.oneue.com</a></li>
                </ul>
            </div>
        </div>
    </div>

</div>
@include('backend.common.foot')
</body>
</html>