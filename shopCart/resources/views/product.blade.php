@extends('layout.app')

@section('title','Product')

@section('css')

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link>
<style>
    h1 {
        text-align: center;
    }

    .badge-notify {
        background: red;
        position: relative;
        top: -20px;
        right: 10px;
    }

    .my-cart-icon-affix {
        position: fixed;
        z-index: 999;
    }
</style>
@endsection('css')

@section('js')
<!-- 自製時間格式化套件 -->
<script src="/js/dateFormat.js"></script>

<!-- ref https://codepen.io/minwt/embed/ZEYYoXv?height=424&theme-id=default&default-tab=result -->
<script src="https://mwt.tw/lib/js/jquery-2.2.3.min.js"></script>
<script src="https://mwt.tw/lib/js/bootstrap.min.js"></script>
<script src="https://mwt.tw/lib/js/jquery.mycart.js"></script>

<script>
    $(function() {
        

        var goToCartIcon = function($addTocartBtn) {
            var $cartIcon = $(".my-cart-icon");
            var $image = $('<img width="30px" height="30px" src="' + $addTocartBtn.data("image") + '"/>').css({
                "position": "fixed",
                "z-index": "999"
            });
            $addTocartBtn.prepend($image);
            var position = $cartIcon.position();
            $image.animate({
                top: position.top,
                left: position.left
            }, 500, "linear", function() {
                $image.remove();
            });
        }

        $('.my-cart-btn').myCart({
            currencySymbol: '$',
            classCartIcon: 'my-cart-icon',
            classCartBadge: 'my-cart-badge',
            classProductQuantity: 'my-product-quantity',
            classProductRemove: 'my-product-remove',
            classCheckoutCart: 'my-cart-checkout',
            affixCartIcon: true,
            showCheckoutModal: true,
            numberOfDecimals: 2,
            clickOnAddToCart: function($addTocart) {
                goToCartIcon($addTocart);
            },
            afterAddOnCart: function(products, totalPrice, totalQuantity) {
                console.log("afterAddOnCart", products, totalPrice, totalQuantity);
            },
            clickOnCartIcon: function($cartIcon, products, totalPrice, totalQuantity) {
                console.log("cart icon clicked", $cartIcon, products, totalPrice, totalQuantity);
            },
            checkoutCart: function(products, totalPrice, totalQuantity) {
                var checkoutString = "Total Price: " + totalPrice + "\nTotal Quantity: " + totalQuantity;
                checkoutString += "\n\n id \t name \t summary \t price \t quantity \t image path";
                $.each(products, function() {
                    checkoutString += ("\n " + this.id + " \t " + this.name + " \t " + this.summary + " \t " + this.price + " \t " + this.quantity + " \t " + this.image);
                });
                // alert(checkoutString)
                // console.log("checking out", products, totalPrice, totalQuantity);
                //products : 結帳資料在這
                console.log(products);
                let userDetail = $("#userDetail").text();
                if(userDetail!=''){
                    console.log('有登入');
                    let nowDate = (new Date()).format("yyyy-MM-dd hh:mm:ss");
                    
                    for(i=0;i<products.length;i++){
                        let obj={
                            'date':nowDate,
                            'user_id':JSON.parse(userDetail)['id'],
                            'product_id':products[i]['id'],
                            'qty':products[i]['quantity']
                        };
                        products[i]
                        axios.post("/api/order",obj);
                    }
                    
                }else{
                    console.log('沒登入');
                    window.location.href="http://127.0.0.1:8000/login";
                }
            }
            // ,getDiscountPrice: function(products, totalPrice, totalQuantity) {
            //     console.log("calculating discount", products, totalPrice, totalQuantity);
            //     return totalPrice * 0.5;
            // }
        });

        $("#addNewProduct").click(function(event) {
            var currentElementNo = $(".row").children().length + 1;
            $(".row").append('<div class="col-md-3 text-center"><img src="images/img_empty.png" width="150px" height="150px"><br>product ' + currentElementNo + ' - <strong>$' + currentElementNo + '</strong><br><button class="btn btn-danger my-cart-btn" data-id="' + currentElementNo + '" data-name="product ' + currentElementNo + '" data-summary="summary ' + currentElementNo + '" data-price="' + currentElementNo + '" data-quantity="1" data-image="images/img_empty.png">Add to Cart</button><a href="#" class="btn btn-info">Details</a></div>')
        });
    });
</script>
@endsection('js')

@section('content')
<div id='userDetail' class="d-none">{{Auth::user()}}</div>
<div class="page-header">
    <h1>產品目錄
    
        <div style="float: right; cursor: pointer;">
            <span class="glyphicon glyphicon-shopping-cart my-cart-icon"><span class="badge badge-notify my-cart-badge"></span></span>
        </div>
    </h1>
</div>
<div class="row">
    @foreach($data as $product)
    <div class="col-sm-6 col-md-3 text-center">
        <img src="/images/{{$product->imgUrl}}" width="150px" height="150px">
        <br>
        {{$product->name}} - <strong>${{$product->price}}</strong>
        <br>
        <button class="btn btn-danger my-cart-btn" data-id="{{$product->id}}" data-name="{{$product->name}}" data-summary="summary {{$product->id}}" data-price="{{$product->price}}" data-quantity="1" data-image="/images/{{$product->imgUrl}}">加入購物車</button>
        <!-- <a href="#" class="btn btn-info">產品內容</a> -->
    </div>
    @endforeach


    <!-- //範例資料
    <div class="col-sm-6 col-md-3 text-center">
        <img src="https://www.jqueryscript.net/demo/Simple-Shopping-Cart-Plugin-With-jQuery-Bootstrap-mycart/images/img_2.png" width="150px" height="150px">
        <br>
        產品 2 - <strong>$20</strong>
        <br>
        <button class="btn btn-danger my-cart-btn" data-id="2" data-name="product 2" data-summary="summary 2" data-price="20" data-quantity="1" data-image="https://www.jqueryscript.net/demo/Simple-Shopping-Cart-Plugin-With-jQuery-Bootstrap-mycart/images/img_2.png">加入購物車</button>
        <a href="#" class="btn btn-info">產品內容</a>
    </div> -->

</div>

@endsection