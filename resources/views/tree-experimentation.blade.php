<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h1>Tree experiment</h1>
        <div class="content">
            <div>
                <h2>Traversed</h2>
                <pre>{{ print_r(json_decode($traversed)) }}</pre>
            </div>
        </div>
    </body>
</html>
