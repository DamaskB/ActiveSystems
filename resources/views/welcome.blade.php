<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>My Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Styles -->
    </head>
    <body>
        <style type="text/css">
            #app {
                width: 1000px;
                margin: auto;
                padding-top: 50px;
            }
            .list_area {
                max-height: 390px;
                overflow-y: overlay;
            }
        </style>

        <div id="app" class="row">

            <newform-component></newform-component>

            <list-component></list-component>

        </div>

                
    </body>

    <script src="{!! asset('js/app.js') !!}"></script>
</html>
