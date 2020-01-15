<div class="star-center">
    <div class="star-hd">
        <a href="/user/avatar">
            <img src="{{$user['avatar']}}"/>
        </a>
        <span>{{$user['username']}}</span>
    </div>
    <div class="star-bd">
        <ul class="list-unstyled">
            <!-- <li class="star-current">
                <a href="">
                    <span class="star-text">用户中心</span>
                    <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>
                </a>
            </li> -->
            <li{!!strstr(request()->path(),'user/like')?' class="star-current"':''!!}>
                <a href="/user/like">
                    <span class="star-text">我喜欢的</span>
                    <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>
                </a>
            </li>
            <li{!!strstr(request()->path(),'user/order')?' class="star-current"':''!!}>
                <a href="/user/order">
                    <span class="star-text">我购买的</span>
                    <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>
                </a>
            </li>
            <li{!!request()->path()=='user/setting' || strstr(request()->path(),'user/address')?' class="star-current"':''!!}>
                <a href="/user/setting">
                    <span class="star-text">账户设置</span>
                    <span class="star-arrow"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>  
                </a>
            </li>
        </ul>
    </div>
</div>