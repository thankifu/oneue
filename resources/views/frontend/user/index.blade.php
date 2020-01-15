@extends('frontend.common.index')

@section('style')
@endsection

@section('body')

<div class="container star-user star-mb-25">
	
    <ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li class="active">用户中心</li>
    </ol>
    <div class="row">

        <div class="col-md-3 star-side">
            @include('frontend.user.side')
        </div>

        <div class="col-md-9 star-main">
            <div class="star-panel">
                <ul class="list-unstyled">
                    <li class="col-xs-3">
                        <a href="/user/like">
                            <i class="glyphicon glyphicon-heart" aria-hidden="true"></i><span>喜欢的</span>
                        </a>
                    </li>
                    <li class="col-xs-3">
                        <a href="/user/order?state=1">
                            <i class="glyphicon glyphicon-credit-card" aria-hidden="true"></i><span>待付款</span>
                        </a>
                    </li>
                    <li class="col-xs-3">
                        <a href="/user/order?state=2">
                            <i class="glyphicon glyphicon-gift" aria-hidden="true"></i><span>待发货</span>
                        </a>
                    </li>
                    <li class="col-xs-3">
                        <a href="/user/order?state=3">
                            <i class="glyphicon glyphicon-plane" aria-hidden="true"></i><span>待收货</span>
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