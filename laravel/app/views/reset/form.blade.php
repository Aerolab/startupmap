<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:image" content="http://startupmap.la/images/landing/profile.jpg"/>

        <!-- Title -->
        <title>StartupMap</title>

        <!-- CSS -->
        <link rel="stylesheet" href="/css/normalize.min.css">
        
        <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
        <link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="/css/newlanding.css">

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-50916131-1', 'startupmap.com.ar');
            ga('send', 'pageview');
        </script>

    </head>
    <body>
        <div class="hero">
        	<h1 class="inside"></h1>
        </div>
        <div class="newsletter">
        <h2>Ingresa tu nueva contraseña</h2>
        	{{ Form::open(array('route' => array( 'reset_password', $token ))) }}
            @include('modules.alerts')
                {{ Form::password('password', array('placeholder'=>'Contraseña')) }}
                {{ Form::password('password_confirmation', array('placeholder'=>'Confirmar contraseña')) }}
                {{ Form::submit() }}
                {{ Form::token() }}
            {{ Form::close() }}
              
        </div>

        <script src="/js/vendor/modernizr-2.6.2.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
    </body>
</html>