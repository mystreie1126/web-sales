<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Pre-Own Orders</title>
        <!-- Latest compiled and minified CSS -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
         <link rel="stylesheet" href="{{URL::asset('css/style/main.css')}}">

        <style>
           .main-header {
            background: #fff;
            background-size: cover;
            background-position: center;
            min-height: 100px;
            color: #000;
          }

          .main-header .showcase {
            padding-top: 20px;
            width:70%;
            border:1px solid red;
          }

          .active-link {
            color: yellow;
            font-weight: bold;
          }

          .coming-orders{
            width:70%;
            border:1px solid red;
          }

          .bold{
            font-weight: bolder;
          }

      
          #order-info th{
            width:20%;
          }
          #new-order td{
            width:20%;
          }


        #order .tabs .indicator {
            background-color: black;
          }

        #order .tabs .tab a{
          color:black;
          font-weight: bolder;
        }

        .voucher-management{
          height: 50vh;
        }

        .pull-voucher{
          /* display: flex;
          justify-content: space-around;
          align-items: center;
          flex-wrap: wrap; */
        }

        .voucher-result{
          display: flex;
          justify-content: space-between;
          flex-wrap: wrap;
          align-items:center;
        }

        @media only screen and (max-width: 900px){
            .voucher-result{
              display: flex;
              flex-direction: column;
            }
        }


        .order-basic-info{
          display: flex;
          justify-content: space-around;
        }
        </style>

    </head>
    <body>

        <div class="container">
            @yield('content')
        </div>


    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js
"></script>
    <script type="text/javascript" src="{{URL::asset('js/jquery.js')}}"></script>
    <script type="text/javascript">

    $(document).ready(function() {
      $("select").material_select();
        $(".button-collapse").sideNav();

    });
    $('.datepicker').pickadate({
        selectMonths:true,
        selectYear:15,
        closeOnSelect:true
    });

    </script>
    </body>
</html>
