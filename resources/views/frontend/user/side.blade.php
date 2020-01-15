<div class="star-side">
    <div class="star-hd">
        <a href="/user/setting">
            <img src="{{$user['avatar']}}"/>
            <span>{{$user['username']}}</span>
            <span class="star-arrow hidden-md hidden-lg"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>
        </a>
    </div>
    <div class="star-bd hidden-xs hidden-sm">
        <ul class="list-unstyled">
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