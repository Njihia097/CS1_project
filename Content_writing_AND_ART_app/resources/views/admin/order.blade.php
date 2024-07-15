<x-admin-layout : artistCount="$artistCount" contentCount="$contentCount">
    @section('content')

    <div>
        @include('admin/partials.preloader')
        @include('admin/partials.header')
        
        <div class="main-panel">
            <div class="content-wrapper">

               
                <h1><b><u>Orders</u></b></h1>
               
                <style>
                    .table-responsive {
                        overflow-x: auto;
                        -webkit-overflow-scrolling: touch;
                        width: 100%;
                    }
                </style>

                <div style="padding-left:400px; padding-bottom:30px;">

                    <form>
                        <input type="text" name"Search" placeholders="search">

                        <input type="submit" value="search" class="btn btn-outline-primary">
                    </form>
                </div>

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
                <th>Delivered</th>
                
            </tr>
        </thead>
        <tbody>
            
            <tr>
                @foreach($orders as $order)
                <td>{{ $order->id }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ $order->user_id }}</td>
                <td>{{ $order->art_title }}</td>
                <td>kshs {{ $order->price }}</td>
                <td><img src="{{ asset('storage/' . $order->image) }}" height="50" width="50"></td>
                <td>{{ $order->payment_status }}</td>
                <td>{{ $order->delivery_status }}</td>
           
                
                @endforeach

                <td><a href="{{url('print_pdf', $order->id)}}" class="btn btn-info">print PDF</a></td>

                <td>
                @if($order->delivery_status=='processing')

                <a href="{{url('delivered', $order->id)}}" onclick="return confirm('Are you sure it has been delivered')" class="btn btn-primary">Delivered</a>

                @else
                <p style="color: magenta;" >Delivered</p>
                @endif

            </td>
            </tr>
           
        </tbody>
    </table>
</div>

            </div>
        </div>
    </div>


    @endsection
</x-admin-layout>