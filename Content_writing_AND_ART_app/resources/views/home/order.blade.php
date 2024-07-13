<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <
        <meta charset="UTF-8">
        <meta name="description" content="Fashi Template">
        <meta name="keywords" content="Fashi, unica, creative, html">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Creative Hub</title>
    
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    
        <!-- Css Styles -->
        <link rel="stylesheet" href="{{ asset('home/css/bootstrap.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('home/css/font-awesome.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('home/css/themify-icons.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('home/css/elegant-icons.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('home/css/owl.carousel.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('home/css/nice-select.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('home/css/jquery-ui.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('home/css/slicknav.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('home/css/style.css') }}" type="text/css">
    
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }

        .img_deg{
            height: 90px;
            width: 90px;
        }
    </style>
</head>
<body>
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{ url('/view_userpage') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Order</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h2>Order Details</h2>
    <table>
        <tr>
            <th>Art</th>
        <th>Image</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Action</th>
        </tr>

        @foreach($order as $order)
        <tr>
            <td>{{$order->art_title}}</td>
        <td><img class="img_deg" src="/storage/{{$order->image}}"></td>
        <td>{{$order->quantity}}</td>
        <td>{{$order->price}}</td>
        </tr>
        @endforeach
    </table>


    <script src="{{ asset('home/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('home/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('home/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('home/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('home/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('home/js/jquery.dd.min.js') }}"></script>
    <script src="{{ asset('home/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('home/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('home/js/main.js') }}"></script>
</body>
</html>
