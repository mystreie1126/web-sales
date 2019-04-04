<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Web-Sales</title>
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
            border:1px solid grey;
          }

     /*   #order{
          height:100vh;
        }*/
        #order .tabs .indicator {
            background-color: black;
          }

        #order .tabs .tab a{
          color:black;
          font-weight: bolder;
        }
      #order .tabs-content.carousel .carousel-item { height: 100%; }

      #order{
        border:1px solid grey;
        border-radius:4px;
      }

        .order-basic-info,.order-results-header{
          display: flex;
          justify-content: space-around;
          align-items: center;
        }
    /*
      .collect-order_items_detail{
        display: flex;

      }*/
      .collect-order_items_detail span{
        padding-right: 10px
      }



        .card .card-content .card-title {
          display: flex;
          justify-content: space-around;
        }

        .total-sale{
          height:15vh;
        }

        .order-dialog div button{
          margin-right: 10px;
        }

        #check_btn_lol button{
         margin-right: 20px;
        }

        .total-sale{
          height:30vh;
          overflow: scroll;
        }

        .bbbbbb{
          display: flex;
          justify-content: space-between;
          align-items: center;
        }

        .shop_name_logo{
          font-size: 2rem;
        }

       .stockinfo_row{
        width:100%;
       }
        
        .stockinfo_row th{
          width:25%;
         }

         .updateToStock{
           padding: 25px;
           background-color: #f4c242;
           border-radius: 5px;
           transition: .5s ease;
           cursor: pointer;
           
         }

         .updateToStock:hover{
            background: red;
         }
          
           .updateToStock:active{
              transform: translateY(15px);
            }




        </style>

    </head>
    <body>

        <div class="container">
            @yield('content')
        </div>
      
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js
"></script>
   {{--  <script type="text/javascript" src="{{URL::asset('js/jquery.js')}}"></script> --}}
    <script type="text/javascript" src="{{URL::asset('js/plugin/fancyTable.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/plugin/notify.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/script.js')}}"></script>
    @stack('countStock')


    </body>
</html>
