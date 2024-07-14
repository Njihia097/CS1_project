<x-admin-layout : artistCount="$artistCount" contentCount="$contentCount">
    @section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <h1 class="mb-4 text-2xl font-bold text-white uppercase">Orders</h1>
            <div class="table-responsive">
                <table class="w-full text-white table-auto">
                    <thead>
                        <tr class="bg-gray-900">
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Phone</th>
                            <th class="px-6 py-3 text-left">User ID</th>
                            <th class="px-6 py-3 text-left">Art Title</th>
                            <th class="px-6 py-3 text-left">Price</th>
                            <th class="px-6 py-3 text-left">Image</th>
                            <th class="px-6 py-3 text-left">Payment Status</th>
                            <th class="px-6 py-3 text-left">Delivery Status</th>
                            <th class="px-6 py-3 text-left">PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="bg-gray-800 hover:bg-gray-700">
                                <td class="px-6 py-4">{{ $order->id }}</td>
                                <td class="px-6 py-4">{{ $order->name }}</td>
                                <td class="px-6 py-4">{{ $order->email }}</td>
                                <td class="px-6 py-4">{{ $order->phone ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $order->user_id }}</td>
                                <td class="px-6 py-4">{{ $order->art_title }}</td>
                                <td class="px-6 py-4">{{ $order->price }}</td>
                                <td class="px-6 py-4">
                                    <img src="{{ asset('storage/' . $order->image) }}"
                                        class="object-cover w-16 h-16 rounded">
                                </td>
                                <td class="px-6 py-4">{{ $order->payment_status }}</td>
                                <td class="px-6 py-4">{{ $order->delivery_status }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ asset('storage/' . $order->pdf) }}"
                                        class="text-blue-400 hover:underline">Download</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @endsection
</x-admin-layout>