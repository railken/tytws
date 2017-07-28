<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Track your timey wimey stuff</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,600" rel="stylesheet" type="text/css">
    </head>
    <body>
        <main  id='app' class='container full-height'><router-view></router-view></main>
        <script src="/nut/app.js?v={{ microtime(true) }}"></script>
    </body>
</html>
