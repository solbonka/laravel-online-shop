@extends('layout')
@section('title', 'Корзина')
@if ($cart)
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
            <div class="title">
                Корзина пуста
            </div>

        @else
        <div class="title">
            Корзина
        </div>

        @foreach($cart->products as $product)
        <div class="item">
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
                <form action="{{ route('add') }}" method="POST" id="add{{ $product->id }}">
                    <input type="hidden" name="productId" value={{ $product->id }}>
                    <button class="plus-btn" type="submit" name="button" form="add{{ $product->id }}" >+</button>
                    @csrf
                </form>
                <label>
                    <input type="text" name="name" value={{ $product->pivot->quantity }}>
                </label>
                <form action="{{ route('remove') }}" method="POST" id="remove{{ $product->id }}">
                    <input type="hidden" name="productId" value={{ $product->id }}>
                    <button class="minus-btn" type="submit" name="button" form="remove{{ $product->id }}" >-</button>
                    @csrf
                </form>
            </div>
            <div class="sum">
                Стоимость {{ $product->price * $product->pivot->quantity }} &#8381
            </div>
        </div>
        @endforeach
            <div class="total">
                Общая сумма : {{ $cart->getTotal() }} &#8381
            </div>
        @endif
    </div>

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
    .quantity input {
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
    .sum {
        padding-top: 25px;
    }

    button:focus,
    input:focus {
        outline:0;
    }
</style>
@endsection
