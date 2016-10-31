<?php
/**
 * Created by PhpStorm.
 * User: Abdelqader Osama
 * Date: 10/31/16
 * Time: 2:26 PM
 */
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="ShortLink">
    <meta name="author" content="Abdelqader Osama">
    <title>HM-Developer</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.9/datatables.min.js"></script>

    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
    <!--    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>-->
    <!--[endif]-->
    <!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>-->
    <!--    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.js"></script>-->
    <!--[if lte IE 8]>
    <script src="js/Chart.min.js"></script>
    <![endif]-->
    <script>
        $(document).ready(function(){
            var currentLocation = String(location.pathname).split('/');
            currentLocation = currentLocation[currentLocation.length-1];

            $('#sidebar-menu').find('li').removeClass('active').find('a').removeClass('active');
            $('#sidebar-menu').find('li a[href="'+currentLocation+'"]').addClass('active').parent().addClass('active');
        });

    </script>
</head>
