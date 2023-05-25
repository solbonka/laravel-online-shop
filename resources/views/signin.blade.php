<head>
    <meta charset="UTF-8">
    <title>Аутентификация</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css'>
    <style>
        @import 'https://fonts.googleapis.com/css?family=Open+Sans|Quicksand:400,700';

        /*--------------------
        General Style
        ---------------------*/
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body,
        html {
            height: 100%;
            font-family: 'Quicksand', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            background: rgba(30,29,31,1);
            background: -moz-linear-gradient(-45deg, rgba(30,29,31,1) 0%, rgba(223,64,90,1) 100%);
            background: -webkit-linear-gradient(-45deg, rgba(30,29,31,1) 0%, rgba(223,64,90,1) 100%);
            background: -o-linear-gradient(-45deg, rgba(30,29,31,1) 0%, rgba(223,64,90,1) 100%);
            background: -ms-linear-gradient(-45deg, rgba(30,29,31,1) 0%, rgba(223,64,90,1) 100%);
            background: linear-gradient(135deg, rgba(30,29,31,1) 0%, rgba(223,64,90,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e1d1f', endColorstr='#df405a', GradientType=1 );
        }

        /*--------------------
        Text
        ---------------------*/

        h2, h3 {
            font-size: 16px;
            letter-spacing: -1px;
            line-height: 20px;
        }

        h2 {
            color: #747474;
            text-align: center;
        }

        h3 {
            color: #032942;
            text-align: right;
        }

        /*--------------------
        Icons
        ---------------------*/
        .i {
            width: 20px;
            height: 20px;
        }

        .i-login {
            margin: 13px 0 0 15px;
            position: relative;
            float: left;
            background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCIgdmlld0JveD0iMCAwIDQxNi4yMjkgNDE2LjIyOSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDE2LjIyOSA0MTYuMjI5OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTQwMy43MjksMjkuNjVINzEuODAyYy02LjkwMywwLTEyLjUsNS41OTctMTIuNSwxMi41djg2LjM2M2MwLDYuOTAzLDUuNTk3LDEyLjUsMTIuNSwxMi41czEyLjUtNS41OTcsMTIuNS0xMi41VjU0LjY1ICAgIGgzMDYuOTI3djMwNi45MjhIODQuMzAydi03My44NjFjMC02LjkwMy01LjU5Ny0xMi41LTEyLjUtMTIuNXMtMTIuNSw1LjU5Ny0xMi41LDEyLjV2ODYuMzYxYzAsNi45MDMsNS41OTcsMTIuNSwxMi41LDEyLjUgICAgaDMzMS45MjdjNi45MDIsMCwxMi41LTUuNTk3LDEyLjUtMTIuNVY0Mi4xNUM0MTYuMjI5LDM1LjI0Nyw0MTAuNjMxLDI5LjY1LDQwMy43MjksMjkuNjV6IiBmaWxsPSIjODczMTRlIi8+CgkJPHBhdGggZD0iTTE4NS40MTcsMjg3LjgxMWMwLDUuMDU3LDMuMDQ1LDkuNjEzLDcuNzE2LDExLjU1YzEuNTQ3LDAuNjQyLDMuMTcsMC45NSw0Ljc4MSwwLjk1YzMuMjUzLDAsNi40NTEtMS4yNyw4Ljg0Mi0zLjY2ICAgIGw3OS42OTctNzkuNjk3YzIuMzQ0LTIuMzQ0LDMuNjYtNS41MjMsMy42Ni04LjgzOWMwLTMuMzE2LTEuMzE2LTYuNDk1LTMuNjYtOC44MzlsLTc5LjY5Ny03OS42OTcgICAgYy0zLjU3NS0zLjU3NS04Ljk1MS00LjY0Ni0xMy42MjMtMi43MWMtNC42NzEsMS45MzYtNy43MTYsNi40OTMtNy43MTYsMTEuNTQ5djY3LjE5N0gxMi41Yy02LjkwMywwLTEyLjUsNS41OTctMTIuNSwxMi41ICAgIGMwLDYuOTAzLDUuNTk3LDEyLjUsMTIuNSwxMi41aDE3Mi45MTdWMjg3LjgxMUwxODUuNDE3LDI4Ny44MTF6IE0yMTAuNDE3LDE1OC41OTRsNDkuNTIxLDQ5LjUybC00OS41MjEsNDkuNTIxVjE1OC41OTR6IiBmaWxsPSIjODczMTRlIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==);
            background-size: 18px 18px;
            background-repeat: no-repeat;
            background-position: center;
        }

        .i-more {
            background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCIgdmlld0JveD0iMCAwIDYxMiA2MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDYxMiA2MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8ZyBpZD0ibW9yZSI+CgkJPGc+CgkJCTxwYXRoIGQ9Ik03Ni41LDIyOS41QzM0LjMsMjI5LjUsMCwyNjMuOCwwLDMwNnMzNC4zLDc2LjUsNzYuNSw3Ni41UzE1MywzNDguMiwxNTMsMzA2UzExOC43LDIyOS41LDc2LjUsMjI5LjV6IE03Ni41LDM0NC4yICAgICBjLTIxLjEsMC0zOC4yLTE3LjEwMS0zOC4yLTM4LjJjMC0yMS4xLDE3LjEtMzguMiwzOC4yLTM4LjJzMzguMiwxNy4xLDM4LjIsMzguMkMxMTQuNywzMjcuMSw5Ny42LDM0NC4yLDc2LjUsMzQ0LjJ6ICAgICAgTTUzNS41LDIyOS41Yy00Mi4yLDAtNzYuNSwzNC4zLTc2LjUsNzYuNXMzNC4zLDc2LjUsNzYuNSw3Ni41UzYxMiwzNDguMiw2MTIsMzA2UzU3Ny43LDIyOS41LDUzNS41LDIyOS41eiBNNTM1LjUsMzQ0LjIgICAgIGMtMjEuMSwwLTM4LjItMTcuMTAxLTM4LjItMzguMmMwLTIxLjEsMTcuMTAxLTM4LjIsMzguMi0zOC4yczM4LjIsMTcuMSwzOC4yLDM4LjJDNTczLjcsMzI3LjEsNTU2LjYsMzQ0LjIsNTM1LjUsMzQ0LjJ6ICAgICAgTTMwNiwyMjkuNWMtNDIuMiwwLTc2LjUsMzQuMy03Ni41LDc2LjVzMzQuMyw3Ni41LDc2LjUsNzYuNXM3Ni41LTM0LjMsNzYuNS03Ni41UzM0OC4yLDIyOS41LDMwNiwyMjkuNXogTTMwNiwzNDQuMiAgICAgYy0yMS4xLDAtMzguMi0xNy4xMDEtMzguMi0zOC4yYzAtMjEuMSwxNy4xLTM4LjIsMzguMi0zOC4yYzIxLjEsMCwzOC4yLDE3LjEsMzguMiwzOC4yQzM0NC4yLDMyNy4xLDMyNy4xLDM0NC4yLDMwNiwzNDQuMnoiIGZpbGw9IiNkZjQwNWEiLz4KCQk8L2c+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==);
            background-size: 20px 20px;
            background-repeat: no-repeat;
            background-position: center;
        }


        /*--------------------
        Login Box
        ---------------------*/

        .box {
            width: 330px;
            position: absolute;
            top: 50%;
            left: 50%;

            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .box-form {
            width: 320px;
            position: relative;
            z-index: 1;
        }

        .box-login-tab {
            width: 50%;
            height: 40px;
            background: #fdfdfd;
            position: relative;
            float: left;
            z-index: 1;

            -webkit-border-radius: 6px 6px 0 0;
            -moz-border-radius: 6px 6px 0 0;
            border-radius: 6px 6px 0 0;

            -webkit-transform: perspective(5px) rotateX(0.93deg) translateZ(-1px);
            transform: perspective(5px) rotateX(0.93deg) translateZ(-1px);
            -webkit-transform-origin: 0 0;
            transform-origin: 0 0;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;

            -webkit-box-shadow: 15px -15px 30px rgba(0,0,0,0.32);
            -moz-box-shadow: 15px -15px 30px rgba(0,0,0,0.32);
            box-shadow: 15px -15px 30px rgba(0,0,0,0.32);
        }

        .box-login-title {
            width: 35%;
            height: 40px;
            position: absolute;
            float: left;
            z-index: 2;
        }

        .box-login {
            position: relative;
            top: -4px;
            width: 320px;
            background: #fdfdfd;
            text-align: center;
            overflow: hidden;
            z-index: 2;

            -webkit-border-top-right-radius: 6px;
            -webkit-border-bottom-left-radius: 6px;
            -webkit-border-bottom-right-radius: 6px;
            -moz-border-radius-topright: 6px;
            -moz-border-radius-bottomleft: 6px;
            -moz-border-radius-bottomright: 6px;
            border-top-right-radius: 6px;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;

            -webkit-box-shadow: 15px 30px 30px rgba(0,0,0,0.32);
            -moz-box-shadow: 15px 30px 30px rgba(0,0,0,0.32);
            box-shadow: 15px 30px 30px rgba(0,0,0,0.32);
        }

        /*--------------------
        Form
        ---------------------*/

        a { text-decoration: none; }

        button:focus { outline:0; }

        .b {
            height: 24px;
            line-height: 24px;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .b-form {
            opacity: 0.5;
            margin: 10px 20px;
            float: right;
        }


        .b-form:hover{
            opacity: 1;
        }

        .fieldset-body {
            display: table;
        }

        .fieldset-body p {
            width: 100%;
            display: inline-table;
            padding: 5px 20px;
            margin-bottom:2px;
        }

        label {
            float: left;
            width: 100%;
            top: 0;
            color: #032942;
            font-size: 13px;
            font-weight: 700;
            text-align: left;
            line-height: 1.5;
        }


        input[type=text],
        input[type=password] {
            width: 100%;
            height: 32px;
            padding: 0 10px;
            background-color: rgba(0,0,0,0.03);
            border: none;
            display: inline;
            color: #303030;
            font-size: 16px;
            font-weight: 400;
            float: left;

            -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,0.05), 1px 1px 0 rgba(255,255,255,1);
            -moz-box-shadow: inset 1px 1px 0 rgba(0,0,0,0.05), 1px 1px 0 rgba(255,255,255,1);
            box-shadow: inset 1px 1px 0 rgba(0,0,0,0.05), 1px 1px 0 rgba(255,255,255,1);
        }

        input[type=text]:focus,
        input[type=password]:focus {
            background-color: #f8f8c6;
            outline: none;
        }

        input[type=submit]  {
            width: 100%;
            height: 48px;
            margin-top: 24px;
            padding: 0 20px;
            font-family: 'Quicksand', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: #fff;
            line-height: 40px;
            text-align: center;
            background-color: #87314e;
            border: 1px #87314e solid;
            opacity: 1;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #df405a;
            border: 1px #df405a solid;
        }

        input[type=submit]:focus {
            outline: none;
        }
        p.field span.label-text{
            display: block;
            font-size: 0.5em;
            font-weight: bold;
            padding-left: 0.5em;
            text-transform: uppercase;
            -webkit-transition: all 0.25s;
            transition: all 0.25s;
            color: #df405a;
        }
        p.field span.i {
            width: 24px;
            height: 24px;
            float: right;
            position: relative;
            margin-top: -26px;
            right: 2px;
            z-index: 2;
            display: none;

            -webkit-animation: bounceIn 0.6s linear;
            -moz-animation: bounceIn 0.6s linear;
            -o-animation: bounceIn 0.6s linear;
            animation: bounceIn 0.6s linear;
        }

        /*--------------------
        Transitions
        ---------------------*/

        .box-form,  .b,
        input[type=submit], p.field span.i {

            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            -ms-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        .icon-credits a {
            text-decoration: none;
            color: rgba(255,255,255,0.2);
        }
    </style>



</head>

<form action="{{ route('signin') }}" method="POST">
<div class='box'>
    <div class='box-form'>
        <div class='box-login-tab'></div>
        <div class='box-login-title'>
            <div class='i i-login'></div><h2>Вход</h2>
        </div>
        <div class='box-login'>
            <div class='fieldset-body' id='login_form'>
                <button class='b b-form i i-more' title='Что делать?'></button>
                @csrf
                <p class='field'>
                    <label for='user'>Email</label>
                    <input type='text' id='user' name='email' title='Email'/>
                    @error('email')
                    <span class='label-text'>{{ $message }}</span>
                    @enderror
                </p>
                <p class='field'>
                    <label for='pass'>Пароль</label>
                    <input type='password' id='pass' name='password' title='Password' />
                    @error('password')
                    <span class='label-text'>{{ $message }}</span>
                    @enderror
                </p>
                <input type='submit' id='do_login' value='Войти' title='Get Started' />
            </div>
        </div>
    </div>
</div>
</form>
