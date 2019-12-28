@extends('frontend.common.index')

@section('body')

<div class="container star-cart star-mb-25">
	<ol class="breadcrumb">
		<li><a href="/">首页</a></li>
		<li class="active">购物车</li>
	</ol>

    <div class="row star-trade">
        <div class="col-md-12">
            
            <div class="star-products">
                <div class="star-bd">
                    @if($cart)
                    <dl>
                        <dt class="hidden-sm hidden-xs">
                            <span>商品信息</span>
                            <span>价格</span>
                            <span>数量</span>
                            <span>小计</span>
                            <span>操作</span>
                        </dt>
                        @foreach($cart as $item)
                        <dd data-product="{{$item['product_id']}}" data-specification="{{$item['specification_id']}}">
                            <div class="star-image">
                                <img src="{{$products[$item['product_id']]['picture']}}"/>
                            </div>
                            <div class="star-title">{{$products[$item['product_id']]['name']}}{{$specifications?' - '.$specifications[$item['specification_id']]['name']:''}}</div>
                            <div class="star-price"><i>¥</i><span>{{$specifications?$specifications[$item['specification_id']]['price']:$products[$item['product_id']]['price']}}</span></div>
                            <div class="star-quantity" data="{{$item['quantity']}}">
                                <span class="star-del" onclick="starCartDecrement(this);"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                <input class="star-num" type="text" value="{{$item['quantity']}}" readonly/>
                                <span class="star-add" onclick="starCartIncrement(this);"><i class="fa fa-plus" aria-hidden="true"></i></span>
                            </div>
                            <div class="star-subtotal"><i>¥</i><span></span></div>
                            <div class="star-operation">
                                <a class="star-delete" href="javascript:void(0);" onclick="starCartDelete(this);">删除</a>
                            </div>
                            @if ($products[$item['product_id']]['state'] == 0)
                            <div class="star-mask">该商品已失效，请 <a class="star-red" href="javascript:void(0);" onclick="starCartDelete(this);">删除</a>！</div>
                            @endif
                        </dd>
                        @endforeach
                    </dl>
                    @else
                    <dl class="star-list-no">
                        <dd>您米有商品哦~<br/><a href="/product" class="btn btn-xs btn-primary">去逛逛</a></dd>
                    </dl>
                    @endif
                </div>
            </div>
        </div>
        @if($cart)
        <div class="col-md-3 col-md-offset-9">
            <div class="star-details">
                <div class="star-bd">
                    <dl>
                        <dt>总计</dt>
                        <dd class="star-total">¥ <span></span></dd>
                    </dl>
                    
                </div>
            </div>
            
            <div class="actions">
                <button type="button" class="btn btn-lg btn-block btn-primary" onclick="starCheckout();">结　算</button>
                {{csrf_field()}}
            </div>

        </div>
        @endif
	</div>

</div>

@endsection

@section('script')
<script type="text/javascript">
    function starCartTotal(){
        var total = 0;
        var subtotal = 0;
        $(".star-products .star-bd dd").each(function(){
            subtotal = $(this).find(".star-subtotal span").text();
            total += Number(subtotal);
            $(".star-total span").text(total.toFixed(2));
        });
        
    }

    $(window).load(function(){
        $(".star-products .star-bd dd").each(function(){
            var num = parseInt($(this).find(".star-num").val());
            var price= Number($(this).find(".star-price span").text());
            
            var subtotal = numMulti(num, price);
            if ( $(this).find(".star-num").val() > 1 ) {
                $(this).find(".star-del").removeClass("star-disabled");
            }else{
                $(this).find(".star-del").addClass("star-disabled");
            }
            $(this).find(".star-subtotal span").text(subtotal);
        });
        starCartTotal();
    });
    
    function starCheckout(){
        starToast('loading', '请稍后...', 0);
        var data = new Object();
        data._token = $('input[name="_token"]').val();

        $.post('/checkout/create',data,function(res){
            if(res.code === 200){
                bootbox.hideAll();
                window.location.href = '/checkout';
                return false;
            }else{
                bootbox.hideAll();
                starToast('fail', res.text);
            }
        },'json');

    };

    function starCartDelete(object){
        bootbox.confirm({
            size: "small", 
            message: "确认要删除吗？",
            buttons: {
                cancel: {
                    label: '取消',
                    className: 'btn-secondary'
                },
                confirm: {
                    label: '确认'
                }
            },
            callback: function (result) {
                if(result){
                    starToast('loading', '请稍后...', 0);
                    var thisLi = $(object).parents("dd:eq(0)");
                    var data = new Object();
                    data._token = $('input[name="_token"]').val();
                    data.product = $(object).parent().parent().attr("data-product");
                    data.specification = $(object).parent().parent().attr("data-specification");

                    $.post('/cart/delete',data,function(res){
                        if(res.code === 200){
                            bootbox.hideAll();
                            thisLi.remove();
                            starToast('success', res.text);
                            return false;
                        }else{
                            bootbox.hideAll();
                            starToast('fail', res.text);
                        }
                    },'json');
                }
            }
        });
        
    };

    function starCartIncrement(object){
        starToast('loading', '请稍后...', 0);
        var n=$(object).prev().val();
        var num=parseInt(n)+1;
        //var isThis = $(object);
        var data = new Object();
        data._token = $('input[name="_token"]').val();
        data.product = $(object).parent().parent().attr("data-product");
        data.specification = $(object).parent().parent().attr("data-specification");
        $.post('/cart/increment',data,function(res){
            if(res.code === 200){
                $(object).prev().val(num);
                if ( num > 1 ) {
                    $(object).prev().prev().removeClass("star-disabled");
                }
                var price= Number($(object).parent().parent().find('.star-price span').text());
                var subtotal = numMulti(num, price);
                $(object).parent().parent().find('.star-subtotal span').text(subtotal);
                starCartTotal();
                bootbox.hideAll();
                return false;
            }else{
                bootbox.hideAll();
                starToast('fail', res.text);
            }
        },'json');
    };

    function starCartDecrement(object){
        starToast('loading', '请稍后...', 0);
        var n=$(object).next().val();
        if(n==2){
            $(object).addClass("star-disabled");
        }
        var num=parseInt(n)-1;
        if (num==0) {
            bootbox.hideAll();
            starToast('fail', '不能再减了');
            $(object).addClass("star-disabled");
            return;
        }
        var data = new Object();
        data._token = $('input[name="_token"]').val();
        data.product = $(object).parent().parent().attr("data-product");
        data.specification = $(object).parent().parent().attr("data-specification");

        $.post('/cart/decrement',data,function(res){
            if(res.code === 200){
                if(res.data!=''){
                    num = res.data.quantity;
                }
                $(object).next().val(num);
                var price= Number($(object).parent().parent().find('.star-price span').text());
                var subtotal = numMulti(num, price);
                $(object).parent().parent().find('.star-subtotal span').text(subtotal);
                starCartTotal();
                bootbox.hideAll();
                return false;
            }else{
                bootbox.hideAll();
                starToast('fail', res.text);
            }
        },'json');
    };

    $(document).ready(function() {
        

        

        
    });
</script>
@endsection