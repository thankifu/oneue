<div class="col-md-3 star-side">
    <div class="star-module">
        <div class="star-hd">推荐</div>
        <div class="star-bd">
            <ul class="list-unstyled star-list-product">
                @foreach($_product as $item)
                <li>
                    <a href="{{$item['id']}}" title="{{$item['name']}}">
                        <p class="star-image">
                            <img src="{{$item['picture']}}?x-oss-process=image/resize,m_fill,w_80,h_80" alt="{{$item['name']}}"/>
                        </p>
                        <p class="star-title">{{$item['name']}}</p>
                        <p class="star-price">
                            <span class="star-normal"><i>¥</i><em>{{$item['price']}}</em></span>
                            <span class="star-line-through"><i>¥</i><em>{{$item['market']}}</em></span>
                        </p>
                    </a>
                </li>
                @endforeach
                
            </ul>
        </div>
    </div>
    <!-- <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">推荐</h3>
        </div>
        <div class="panel-body">
            <div class="media">
                <a href="">
                    <div class="media-left">
                        <img class="media-object img-rounded" src="https://img.starslabs.com/uploads/4b7250bd61c3fff3/a22b3a0adaaa1291.jpg?x-oss-process=image/resize,m_fill,w_80,h_80" alt="...">
                    </div>
                    <div class="media-body">
                        <p>1111</p>
                        <p>¥ 55.00</p>
                    </div>
                </a>
            </div>
        </div>
    </div> -->
</div>