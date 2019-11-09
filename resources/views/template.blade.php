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
        <link href="https://fonts.googleapis.com/css?family=Russo+One&display=swap" rel="stylesheet">
        <link href="https://unpkg.com/tabulator-tables@4.2.7/dist/css/tabulator.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
         <link rel="stylesheet" href="{{URL::asset('css/style/main.css')}}">

        <style>

          .stockTake_page{
              font-family:  'Russo One', sans-serif;
          }

          .pre-loader{
  position: absolute;
  margin: auto;
  top: 50vh;
  bottom: 50vh;
  left: 0;
  right: 0;

}
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



        .countStock div{
          width: 100%;
          height:50vh;
          overflow: auto;
          margin:0;
        }

        .updateToStock{
          padding: 10px;
          border-radius: 2px;
          transition: .2s ease;
          cursor: pointer;
          width:50%;
          margin:auto;
          display: block;
          font-size: 2rem;
          background: orange;
          color:#fff;
        }

      /*  .updateToStock:hover{
          background-color: green;
          color:#fff;
        }*/

        #myInput::placeholder{
          font-style: italic;
          font-weight: bold;
        }

        .stockinfo_row{
          margin-bottom: 5px;
          border:2px solid green;
        }

        .countStock{
          height:100vh;
          overflow: auto;
        }


        </style>

    </head>
    <body>

        <div>
            @yield('content')
        </div>
    <script type="text/javascript">
    //const api = 'http://localhost/project/laravel/reward-test/public/api/';
    //const api = 'http://web-sales.funtech.ie/api/';
    //const stockMan_api = 'http://localhost:3000/';
    const stockMan_api = 'https://stockmananger-api.herokuapp.com/'
    </script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js
"></script>
   {{--  <script type="text/javascript" src="{{URL::asset('js/jquery.js')}}"></script> --}}
    <script type="text/javascript" src="{{URL::asset('js/plugin/fancyTable.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/plugin/notify.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/plugin/csvExport.min.js')}}"></script>

    <script type="text/javascript" src="{{URL::asset('js/script.js')}}"></script>
    @stack('stockTake')
    @stack('myStockTake')
    @stack('preown')
    @stack('updateRecord')
    @stack('parts_stockTake')
    </body>
</html>
