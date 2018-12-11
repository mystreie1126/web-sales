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
            .button-rewards{
                display:flex;
                justify-content: space-between;
                height:25vh;
            }

             @media only screen and (max-width: 600px){
                    .button-rewards{
                        flex-direction: column;
                        justify-content: space-between;
                    }
                }
        </style>

    </head>
    <body>
        <div class="container">
            <h4 class="cyan-text">Incoming Pre-Own Orders</h2>
            @yield('content')
        </div>


    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js
"></script>
    <script type="text/javascript">

    $(document).ready(function() {
      $("select").material_select();
    });
    $('.datepicker').pickadate({
        selectMonths:true,
        selectYear:15,
        closeOnSelect:true
    });

    </script>
    </body>
</html>