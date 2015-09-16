<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>404 error</title>
    <link type="text/css" href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .btn
        {
            background: transparent;
            color: #F2F2F2;
            /* CSS Transition */
            -webkit-transition: background .2s ease-in-out, border .2s ease-in-out;
            -moz-transition: background .2s ease-in-out, border .2s ease-in-out;
            -ms-transition: background .2s ease-in-out, border .2s ease-in-out;
            -o-transition: background .2s ease-in-out, border .2s ease-in-out;
            transition: background .2s ease-in-out, border .2s ease-in-out;
        }
        #buttonHolder
        {
            position: absolute;
            left: 42%;
            right: -50%;
        }
        #centrator
        {
            position: relative;
            top:20%;
        }
        #backBody
        {
            position: absolute;
            width:100%;
            height:100%;
            background-color: #000000;
            background-image:url(media/404.jpg);
            background-size: 100%;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>
<div id='backBody'>
    <div id='centrator'>
        <div class='col-md-4'></div>
        <div class='col-md-4'>
            <p style="color: #ffffff; text-align: center;">The page you are requesting does not exist! Proceed back or return to the
                <a href="/" style="color: #ffff00">main page!</a></p>
            <div id='buttonHolder'>
                <button type="button" class="btn btn-warning" onclick="window.history.back();">Return back</button>
            </div>
        </div>
        <div class='col-md-4'></div>
    </div>
</div>
</body>
</html>