@extends('layout')
@section('title', 'Главная страница')
@if ($cart && $cart->getSum() !== 0)
    @section('quantitySum', $cart->getSum())
    @section('total', $cart->getTotal())
@else
    @section('quantitySum', '')
    @section('total', '')
@endif
@section('content')
<script
        src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
        crossorigin="anonymous">
</script>
<div class="menu">
    <div class="container menu__container">

        <div class="catalog">
            <div class="catalog__wrapper">
                <div class="catalog__header"><span>Категории</span><i class="catalog__header-icon"></i></div>
                <ul class="catalog__list">
                    @foreach ($categories as $category)
                    <li class="catalog__item">
                        <a href="/category/{{ $category->id }}" class="catalog__link">
                            <img src="{{ $category->icon_pass }}" alt="Desktops" class="catalog__link-img">
                            {{ $category->name }}  ({{ $category->products->count() }})
                        </a>
                        <div class="catalog__subCatalog">
                            @foreach($category->products as $product)
                                 @if ($category->id === $product->category_id )
                                    <div class="catalog__subCatalog__item">
                                        <div class="product catalog__product">
                                            <img src="{{ $product->image_pass }}" alt="" class="product__img">
                                            <div class="product__content">
                                                <h3 class="product__title">{{ $product->name }}</h3>
                                                <p class="product__description">{{ $product->weight }} грамм </p>
                                            </div>
                                            <div class="product__footer">
                                                <div class="product__bottom">
                                                    <div class="product__price">
                                                        <span class="product__price-value">{{ $product->price }}</span>
                                                        <span class="product__currency">&#8381;</span>
                                                    </div>
                                                    <form class="add-form" action="{{ route('add') }}" method="POST" id="add{{ $product->id }}">
                                                        @csrf
                                                        <input type="hidden" name="productId" value={{ $product->id }}>
                                                        <button class="btn product__btn" type="submit" form="add{{ $product->id }}" value={{ $product->id }}>В корзину</button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <nav class="menu__nav">
            <a href="/" class="menu__nav-link">Продуктов в корзине:</a>
            <a href="/" class="menu__nav-link" id="quantitySum">@if($cart && $cart->getSum() !== 0)
                    {{ $cart->getSum() }} @else 0 @endif</a>
            <a href="/" class="menu__nav-link" id="total">Общая сумма : @if($cart && $cart->getSum() !== 0)
                    {{ $cart->getTotal() }} @else 0 @endif &#8381</a>
        </nav>
        <a href="tel:+99999999999" class="menu__phone"><i class="fa fa-phone menu__phone-icon"></i>
            <span class="menu__phone-span">Call us: </span> +9 999 99 999 99</a>

    </div>
</div>

<div class="slider">
    <div class="container">
        <div class="slider__wrapper">
            <div class="slider__carousel">

                <div class="slider__carousel_item">
                    <div class="slider__carousel_desc">
                        <p class="slider__carousel_desc-title">Мороженое</p>
                        <p class="slider__carousel_desc-text">Очень вкусное</p>
                        <p class="slider__carousel_desc-text">Любят все</p>
                        <a href="/home" class="slider__carousel_button">More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.add-form button').click(function (){
            var productId = $(this).parent().find("[name='productId']").attr('value');
            $.ajax({
                url: "{{ route('add') }}",
                data: {productId: productId},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                success: (data) => {
                    console.log(data);
                    let inputData = JSON.parse(data);
                    document.getElementById("total").innerHTML='Общая сумма : ' + inputData.totalSum +' &#8381';
                    document.getElementById("quantitySum").innerHTML=inputData.quantitySum;
                }
            });
            return false;
        });
    });
</script>



<style>
    .menu {
        height: 60px;
    }
    .menu__container {
        position: relative;
    }
    .menu__nav {
        padding-left: 300px;
        height: 100%;
        display: flex;
        align-items: center;
    }
    .menu__nav-link {
        font-weight: bold;
        font-size: 14px;
        padding-right: 20px;
        transition: all .3s;
    }
    .menu__phone {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        color: #cb2d41;
        font-size: 14px;
        font-weight: bold;
        margin-left: auto;
        border-left: 1px solid #e0e0e0;
        padding-left: 40px;
        height: 60px;
    }
    .menu__phone-icon {
        font-size: 18px;
    }
    .menu__phone-span {
        padding-left: 10px;
        padding-right: 5px;
        color: #111;
        transition: all .3s;
    }
    .menu__phone:hover .menu__phone-span {
        color: #cb2d41;
    }
    .catalog {
        position: absolute;
        width: 260px;
        top: 0;
        background-color: #fff;
    }
    .catalog__header {
        height: 60px;
        font-weight: bold;
        padding-left: 20px;
        padding-right: 20px;
        border: 1px solid #e0e0e0;
        border-bottom: none;
        border-top: none;
        justify-content: space-between;
        align-items: center;
        display: flex;
    }
    .catalog__header-icon {
        font-size: 21px;
    }
    .catalog__list {
        position: relative;
        z-index: 2;
        visibility: hidden;
    }
    .catalog__link {
        height: 60px;
        font-size: 14px;
        padding-left: 20px;
        padding-right: 20px;
        border: 1px solid #e0e0e0;
        border-bottom: none;
        align-items: center;
        display: flex;
    }
    .catalog__link-img {
        margin-right: 10px;
        margin-top: -3px;
    }
    .catalog__subCatalog {
        width: 867px;
        display: flex;
        flex-wrap: wrap;
        background-color: white;
        position: absolute;
        opacity: 0;
        visibility: hidden;
        left: 280px;
        top: 0;
        height: 501px;
        overflow: scroll;
        padding: 20px;
        transition: all .3s;
    }
    .catalog__subCatalog__item {
        width: calc(100% / 3);
        margin-bottom: 90px;
        padding: 0 35px;
        position: relative;
    }
    .catalog__subCatalog__item::before {
        content: '';
        background: #f7f7f7;
        position: absolute;
        left: 0;
        top: 0;
        width: 3px;
        height: 100%;
        transform: translateX(-50%);
    }
    .catalog__subCatalog__item:nth-of-type(2n + 1)::before {
        content: none;
    }
    .catalog__product {
        width: 270px;
        max-width: 100%;
        margin: 0 auto;
        border-bottom: 2px solid #f7f7f7;
        padding-bottom: 50px;
    }
    .product {
        display: flex;
        flex-direction: column;
    }
    .btn {
        background: #ff5441;
        color: #fff;
        display: inline-block;
        padding: 18px 20px;
        width: 240px;
        max-width: 100%;
        border-radius: 28px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 18px;
        border: 0;
        cursor: pointer;
        text-align: center;
        letter-spacing: .02em;
        box-shadow: 0 0 38px 0 rgba(212, 66, 50, 0.8);
        transition: color .2s, background .2s, opacity .2s;
    }
    .product img{
        max-width: 250px;
        width: auto;
        height: 200px;
    }
    .product__img {
        display: block;
        margin: 0 auto 15px;
    }

    .product__title {
        margin: 0 0 10px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 22px;
        height: 60px;
    }

    .product__description {
        margin: 0;
        color: #9f9f9f;
    }

    .product__content {
        margin-bottom: 25px;
        flex-grow: 1;
        height: 80px;
    }


    .product__footer{
        background: gold;
        border-bottom-left-radius: 25px;
        border-bottom-right-radius: 25px;
    }

    .product__price {
        padding-left: 15px;
        font-family: 'Montserrat', sans-serif;
        font-size: 22px;
        font-weight: 900;
    }
    .product__bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .product__btn {
        box-shadow: none;
        background: crimson;
        width: 150px;
        margin-right: 10px;
    }

    .product__btn:hover {
        background: red;
    }

    .catalog__item:hover .catalog__subCatalog {
        opacity: 1;
        visibility: visible;
        left: 260px;
    }
    .catalog:hover .catalog__list{
        opacity: 1;
        visibility: visible;
    }

    .slider {
        background-image: url(https://media.istockphoto.com/id/1222009180/ru/%D1%84%D0%BE%D1%82%D0%BE/%D0%BC%D0%BE%D1%80%D0%BE%D0%B6%D0%B5%D0%BD%D0%BE%D0%B5-%D0%BC%D0%B5%D1%80%D0%BD%D1%8B%D0%B5-%D0%BB%D0%BE%D0%B6%D0%BA%D0%B8-%D0%B2-%D0%BA%D0%BE%D0%BD%D1%83%D1%81%D0%B0%D1%85-%D1%81-%D0%BA%D0%BE%D0%BF%D0%B8%D0%B5%D0%B9-%D0%BF%D1%80%D0%BE%D1%81%D1%82%D1%80%D0%B0%D0%BD%D1%81%D1%82%D0%B2%D0%B0-%D0%BD%D0%B0-%D1%81%D0%B8%D0%BD%D0%B8%D0%B9.jpg?s=612x612&w=0&k=20&c=32Ojv36cb5WfnSOr9C3eklQcFUDfjbNivSHyAwpbVz8=);
        background-repeat: no-repeat;
        background-position: center center;
        background-attachment: fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        height: 541px;
    }
    .slider__wrapper {
        width: 600px;
        margin-left: 400px;
        height: 541px;
    }
    .slider__carousel_desc {
        position: absolute;
        top: 110px;
        color: #fff;
    }
    .slider__carousel_desc-title {
        font-size: 90px;
        color: crimson;
    }
    .slider__carousel_desc-text {
        font-size: 35px;
        padding-top: 5px;
    }
    .slider__carousel_desc-text {
        font-size: 35px;
        padding-top: 5px;
    }
    .slider__carousel_button {
        color: #fff;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        background-color: #cb2d41;
        width: 160px;
        height: 50px;
        margin-top: 20px;
        transition: all .3s;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .slider__carousel_button:hover {
        background-color: #111;
        color: #fff;
    }
    .slider__carousel{
        width: 100%;
        position: relative;
        z-index: 1;
    }
</style>
@endsection
