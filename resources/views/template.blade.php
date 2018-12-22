<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pre-Own Orders</title>
        <!-- Latest compiled and minified CSS -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" rel="stylesheet">
        <style>
            .collapsible-header i{
                font-size: 3rem;
                margin-right: 30px;
            }
            
            .search-container{
                display:block;
                width:30%;
                margin:0 auto;
            }

            
            .form-container{
                display:block;
                margin:auto;
                width:50%;
                transform: translateY(30%);
            }
            
            .order_and_name{
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            

            .order-intro{
                display: flex;
                align-items: flex-start;
            }
            .order-detail-container{
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            

            .confirm-order{
                display: flex;
                justify-content: space-between;
                align-items: flex-end;
            }
            
          /*  .reward-status-text{
                padding: 30px;
            }*/
        </style>

    </head>
    <body>

        <div class="container">
            @yield('content')
        </div>


    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js
"></script>
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