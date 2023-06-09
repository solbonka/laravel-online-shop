<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Интернет магазин: @yield('title')</title>
</head>

<body>
<header class="header">
    <div class="container">
        <a href="{{ route('home') }}" class="logo" title="Магаз">
            <img src="https://sun9-73.userapi.com/impg/LlFhCCrFlSL8QcXqaRntpXbQX62ACsGZs67_xA/f3DVgs-F0FE.jpg?size=219x99&quality=96&sign=daf3d997d0003d7fc156922d9d3f19c1&type=album" alt="Logo">
        </a>
        <div class="header-right">
            <form class="search-form">
                <label>
                    <input type="text" name="search" value="" placeholder="Search" class="search-input">
                </label>
                <button><i class="fa fa-search search-i"></i></button>
            </form>
            <div class="cart-informer">
                <button onclick="document.location='/cart'" class="cart-informer__button">
                    <span class="cart-informer__count" id="smallQty">@yield('quantitySum')</span>
                    <span class="cart-informer__icon"></span>
                    <span class="cart-informer__value">@yield('total')</span>
                    <i class="fa fa-chevron-down cart-informer__i"></i>
                </button>
            </div>
        </div>
    </div>
</header>


<!-- NEW -->
@yield('content')
<!-- END -->

<footer>
    Мой магазин мороженого
</footer>

</body>

<style>
    footer{
        text-align: center;
        padding: 5px;
        background-color: #abbaba;
        color: #004;
        position:fixed;
        bottom: 0;
        height:30px;
        width:100%;
    }
    /* NEW */

    {
        box-sizing: border-box;
    }



    html, body{
        margin: 0;


        /* NEW */
        font-size: 16px;
        font-family: Roboto,serif;
        /* END */



    }
    .header{
        background: #cb2d41;
        padding: 35px 0;
    }
    .container{
        width: 1140px;
        display: flex;
        align-items: center;
        padding-left: 15px;
        padding-right: 15px;
        margin: 0 auto;
    }
    .header-right{
        display: flex;
        align-items: center;
        margin-left: auto;
    }
    .search-form {
        display: flex;
        align-items: center;
        margin: 0 auto;
        width: 270px;
        height: 50px;
        border: 1px solid rgba(255,255,255,.2);
        padding-left: 5px;
        padding-right: 10px;
    }
    input {
        outline: 0;
        border: none;
        background: none;
    }
    .search-input {
        color: #fff;
        width: 90%;
        height: 100%;
        font-size: 12px;
    }
    ::-webkit-input-placeholder {
        color: #fff
    }

    :-moz-placeholder {
        color: #fff
    }

    ::-moz-placeholder {
        color: #fff
    }

    :-ms-input-placeholder {
        color: #fff
    }
    button {
        outline: 0;
        border: none;
        background: none;
        cursor: pointer;
    }
    .search-i {
        color: #fff;
    }
    .cart-informer {
        color: #fff;
        padding-top: 0;
        padding-left: 20px;
    }
    .cart-informer__button {
        margin-left: auto;
        margin-right: auto;
        display: flex;
        align-items: center;
    }
    .cart-informer__count {
        color: #111;
        font-size: 10px;
        background-color: #fff;
        width: 23px;
        height: 23px;
        margin-right: -4px;
        margin-left: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cart-informer__icon {
        background-image: url(https://sun9-8.userapi.com/impg/Ek_VPiJ1NModML-Ne2L_c0V4KgrMO_RinkJ9LA/q-s-UCVvzMY.jpg?size=45x45&quality=96&sign=74b32c6c16462c8a47cb62a2bb0cc9ef&type=album);
        width: 45px;
        height: 45px;
        border: 1px solid rgba(255,255,255,.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cart-informer__i, .cart-informer__value {
        color: #fff;
        font-weight: 700;
        font-size: 12px;
        padding-left: 10px;
    }
    .cart-informer__i {
        font-size: 11px;
        margin-top: -2px;
    }



    /* NEW */

    ul {
        padding: 0;
        margin: 0;
    }
    li {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    p {
        margin: 0;
        padding: 0;
    }
    img {
        border-style: none;
    }
    a {
        color: #111;
        text-decoration: none;
    }
    a:hover {
        color: #cb2d41;
    }
    /* END */
</style>
</html>
