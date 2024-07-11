<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fashi Template">
    <meta name="keywords" content="Fashi, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fashi | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="home/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="home/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="home/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="home/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/style.css" type="text/css">
</head>

<x-app-layout>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    @include('home.header')
    <!-- Header End -->

    <!-- Hero Section Begin -->
   @include('home.hero')
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    @include('home.banner')
    <!-- Banner Section End -->

    <!-- Women Banner Section Begin -->
    @include('home.banner2')
    <!-- Women Banner Section End -->

    <!-- Deal Of The Week Section Begin-->
   @include('home.deal')
    <!-- Deal Of The Week Section End -->

    <!-- Man Banner Section Begin -->
    @include('home.banner1')
    <!-- Man Banner Section End -->

    <!-- Instagram Section Begin -->
   @include('home.insta')
    <!-- Instagram Section End -->

    <!-- Latest Blog Section Begin -->
   @include('home.blog')
    <!-- Latest Blog Section End -->

    <!-- Partner Logo Section Begin -->
    @include('home.logo')
    <!-- Partner Logo Section End -->

    <!-- Footer Section Begin -->
   @include('home.footer')
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="home/js/jquery-3.3.1.min.js"></script>
    <script src="home/js/bootstrap.min.js"></script>
    <script src="home/js/jquery-ui.min.js"></script>
    <script src="home/js/jquery.countdown.min.js"></script>
    <script src="home/js/jquery.nice-select.min.js"></script>
    <script src="home/js/jquery.zoom.min.js"></script>
    <script src="home/js/jquery.dd.min.js"></script>
    <script src="home/js/jquery.slicknav.js"></script>
    <script src="home/js/owl.carousel.min.js"></script>
    <script src="home/js/main.js"></script>
</body>
</x-app-layout>

</html>