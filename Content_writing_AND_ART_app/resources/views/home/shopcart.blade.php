<!DOCTYPE html>
<html lang="zxx">

<head>
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

        th,
        td {
            padding: 10px;
            text-align: left;
            border-left: 1px solid #ccc;
            border-right: 1px solid #ccc;
        }

        thead th {
            border-bottom: 2px solid #000;
        }

        tbody tr {
            border-bottom: 1px solid #ccc;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr td {
            border-top: 1px solid #ccc;
        }

        .img_deg {
            height: 90px;
            width: 90px;
        }
    </style>
</head>
<x-app-layout>

    <body>

        <!-- Page Preloder -->
        <div id="preloder">
            <div class="loader"></div>
        </div>
        <div>
            <!-- Header Section Begin -->
            @include('home.header')
            <!-- Header End -->
        </div>

        @if (session()->has('message'))

            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>

                {{session()->get('message')}}
            </div>
        @endif

        <div class="gap-2 px-6 py-4 mb-4">
            <table>
                <thead>
                    <tr>
                        <th>Art</th>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    <?php $totalprice = 0; ?>
                </thead>

                @foreach($cart as $cart)
                    <tbody>
                        <tr>
                            <td>{{$cart->art_title}}</td>
                            <td><img class="img_deg" src="/storage/{{$cart->image}}"></td>
                            <td>{{$cart->quantity}}</td>
                            <td>{{$cart->price}}</td>
                            <td><a class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to remove this art?')"
                                    href="{{url('/remove_cart', $cart->id)}}">Delete</a></td>
                        </tr>

                        <?php    $totalprice = $totalprice + $cart->price ?>
                    </tbody>
                @endforeach

                

            </table>
        </div>

        <div class="left-0 flex flex-col justify-end col-span-1 gap-2 px-4 pt-2">
        <div class="inline-block px-4">
            <p class="items-center text-xl font-bold text-gray-800 uppercase">Total: <span class="ml-1 text-lg text-gray-800">{{$totalprice}}</span></p>
        </div>
        <div>
        <a href="{{url('cash_order')}}" class="btn btn-info">Cash payment</a>

        <a href="" class="btn btn-info">M-Pesa payment</a>
        </div>


        </div>


    </body>


    <!-- Footer Section End -->

    <!-- Js Plugins -->
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

    <!-- Add Bootstrap's JS and Popper.js for dropdown functionality -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    </body>
</x-app-layout>

</html>