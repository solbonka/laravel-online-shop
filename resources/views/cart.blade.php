@extends('layout')
@section('title', 'Корзина')
@if ($cart && $cart->getSum() !== 0)
        @section('quantitySum', $cart->getSum())
        @section('total', $cart->getTotal())
@else
    @section('quantitySum', '')
    @section('total', '')
@endif
@section('content')

    <div class="shopping-cart">
        <!-- Title -->
        @if(empty($cart) || empty($cart->products()->first()->id))
            <div class="title" id="title">
                Корзина пуста
            </div>

        @else
        <div class="title" id="title">
            Корзина
        </div>

        @foreach($cart->products as $product)
        <div class="item" id="item{{ $product->id }}">
            <div class="buttons">
                <span class="delete-btn"></span>
                <span class="like-btn"></span>
            </div>

            <div class="image">
                <img src="{{ $product->image }}" alt="" />
            </div>

            <div class="description">
                <span>{{ $product->name }}</span>
                <span>{{ $product->weight }} грамм</span>
                <span>{{ $product->price }} &#8381</span>
            </div>

            <div class="quantity">
                <form class="add-form" action="{{ route('add') }}" method="POST" id="add{{ $product->id }}">
                    <input type="hidden" name="productId" value={{ $product->id }}>
                    <button class="plus-btn" type="submit" name="button" form="add{{ $product->id }}" >+</button>
                    @csrf
                </form>
                <label>
                    <span id="qty{{ $product->id }}">{{ $product->pivot->quantity }}</span>
                </label>
                <form class="remove-form" action="{{ route('remove') }}" method="POST" id="remove{{ $product->id }}">
                    <input type="hidden" name="productId" value={{ $product->id }}>
                    <button class="minus-btn" type="submit" name="button" form="remove{{ $product->id }}" >-</button>
                    @csrf
                </form>
            </div>
            <div class="priceSum">
                <span id="{{ $product->id }}">
                Стоимость {{ $product->getPriceSum() }} &#8381
                </span>
            </div>
        </div>
        @endforeach
            <div class="total" id="total">
                <span id="totalSpan">
                Общая сумма : {{ $cart->getTotal() }} &#8381
                </span>
            </div>
        @endif
    </div>
<script
        src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
        crossorigin="anonymous">
</script>
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
                    document.getElementById("totalSpan").innerHTML='Общая сумма : ' + inputData.totalSum +' &#8381';
                    document.getElementById(productId).innerHTML='Стоимость :' + inputData.priceSum +' &#8381';
                    document.getElementById('qty' + productId).innerHTML=inputData.quantity;
                }
            });
            return false;
        });
    });
    $(document).ready(function () {
        $('.remove-form button').click(function (){
            var productId = $(this).parent().find("[name='productId']").attr('value');
            $.ajax({
                url: "{{ route('remove') }}",
                data: {productId: productId},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                success: (data) => {
                    console.log(data);
                    let inputData = JSON.parse(data);
                    document.getElementById("totalSpan").innerHTML='Общая сумма : ' + inputData.totalSum +' &#8381';
                    document.getElementById(productId).innerHTML='Стоимость :' + inputData.priceSum + ' &#8381';
                    document.getElementById('qty' + productId).innerHTML=inputData.quantity;
                    if (inputData.quantity == 0) {
                        document.getElementById('item' + productId).remove();
                    }
                    if (inputData.quantitySum == 0) {
                        document.getElementById('total').remove();
                        document.getElementById('title').innerHTML = 'Корзина пуста';
                    }
                }
            });
            return false;
        });
    });
</script>
<style>
    * {
        box-sizing: border-box;
    }

    html,
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        background-color: #cb2d41;
        font-family: 'Roboto', sans-serif;
    }

    .shopping-cart {
        width: 750px;
        max-height: 450px;
        margin: auto;
        background: #FFFFFF;
        box-shadow: 1px 2px 3px 0 rgba(0, 0, 0, 0.10);
        border-radius: 6px;
        overflow: auto;
        display: flex;
        flex-direction: column;
    }
    .title {
        height: 60px;
        border-bottom: 1px solid #E1E8EE;
        padding: 20px 30px;
        color: #5E6977;
        font-size: 18px;
        font-weight: 400;
    }
    .total {
        padding: 20px 30px;
        font-size: 18px;
        border-top: 1px solid #E1E8EE;
        text-align: right;
    }

    .item {
        padding: 20px 30px;
        height: 120px;
        display: flex;
    }

    .item:nth-child(3) {
        border-top:  1px solid #E1E8EE;
        border-bottom:  1px solid #E1E8EE;
    }
    .buttons {
        position: relative;
        padding-top: 30px;
        margin-right: 60px;
    }


    @keyframes animate {
        0%   { background-position: left;  }
        50%  { background-position: right; }
        100% { background-position: right; }
    }
    .image {
        margin-right: 50px;
    }
    .image img{
        max-width: 80px;
    }

    .description {
        padding-top: 10px;
        margin-right: 60px;
        width: 115px;
    }

    .description span {
        display: block;
        font-size: 14px;
        color: #43484D;
        font-weight: 400;
    }

    .description span:first-child {
        margin-bottom: 5px;
    }
    .description span:last-child {
        font-weight: 300;
        margin-top: 8px;
        color: #86939E;
    }
    .quantity {
        padding-top: 20px;
        margin-right: 60px;
    }
    .quantity span {
        -webkit-appearance: none;
        border: none;
        text-align: center;
        width: 50px;
        font-size: 16px;
        color: #43484D;
        font-weight: 300;
        display: inline-block;
    }
    .quantity form {

        display: inline-block;
    }


    .plus-btn{
        width: 30px;
        height: 30px;
        background-color: greenyellow;
        border-radius: 6px;
        cursor: pointer;
        border: none;
    }
    .minus-btn{
        width: 30px;
        height: 30px;
        background-color: red;
        border-radius: 6px;
        border: none;
        cursor: pointer;
    }
    .minus-btn img {
        margin-bottom: 3px;
    }
    .plus-btn img {
        margin-right: 5px;
        align-items: center;
        height: 90%;
        width: auto;
    }
    .priceSum {
        padding-top: 25px;
    }

    button:focus,
    input:focus {
        outline:0;
    }
</style>
@endsection
