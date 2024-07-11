<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><h4>Categories</h4></title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
    <style>
        .category-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .category-box {
            flex: 1 1 calc(33.333% - 20px);
            background-color: #628efc;
            padding: 20px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            height: calc(33.333% - 20px); /* Make height equal to width to make it square */
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s;
        }
        .category-box a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }
        .category-box:hover {
            background-color: #5278e2;
        }
        .category-box a:hover {
            color: #fff; /* Ensures the link color remains white on hover */
        }
        @media (max-width: 768px) {
            .category-box {
                flex: 1 1 calc(50% - 20px);
                height: calc(50% - 20px); /* Adjust height for responsiveness */
            }
        }
        @media (max-width: 480px) {
            .category-box {
                flex: 1 1 calc(100% - 20px);
                height: calc(100% - 20px); /* Adjust height for responsiveness */
            }
        }
    </style>
</head>
<x-app-layout>

<body>
    <!-- Other content of the user page -->

    <section class="category-section">
        <div class="container">
            <h1>Categories</h1>
            <div class="category-container">
                <!-- Sample category boxes -->
                <div class="category-box"><a href="#"><u>Category 1</u></a></div>
                <div class="category-box"><a href="#"><u>Category 2</u></a></div>
                <div class="category-box"><a href="#"><u>Category 3</u></a></div>
                <div class="category-box"><a href="#"><u>Category 4</u></a></div>
                <div class="category-box"><a href="#"><u>Category 5</u></a></div>
                <div class="category-box"><a href="#"><u>Category 6</u></a></div>
            </div>
        </div>
    </section>

    <!-- Other content of the user page -->
</body>
</x-app-layout>

</html>
