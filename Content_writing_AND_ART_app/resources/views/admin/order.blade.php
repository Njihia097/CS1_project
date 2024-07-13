

<x-admin-layout>
    
    

    @section('content')
    <div>
        @include('admin/partials.preloader')
        @include('admin/partials.header')
        
        <div class="main-panel">
            <div class="content-wrapper">


                <h1>Orders</h1>

                <style>
                    .table-responsive {
                        overflow-x: auto;
                        -webkit-overflow-scrolling: touch;
                        width: 100%;
                    }
                </style>
                <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>User ID</th>
                <th>Art Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Payment Status</th>
                <th>Delivery Status</th>
                <th>PDF</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ $order->user_id }}</td>
                <td>{{ $order->art_title }}</td>
                <td>{{ $order->price }}</td>
                <td><img src="{{ asset('storage/' . $order->image) }}" height="50" width="50"></td>
                <td>{{ $order->payment_status }}</td>
                <td>{{ $order->delivery_status }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
            </div>
        </div>
    </div>
    </div>
    @endsection
    
    </x-admin-layout>
    