<!DOCTYPE html>
<html>
    <head>
        <title>Order details</title>
    </head>
<body>
    <h1> Order details</h1>

    <h3>Creator Email:{{$orderdet->Email}}</h3>

    <h3>Creator Phone number:{{$orderdet->phone}}</h3>

    <h3>Creator id:{{$orderdet->user_id}}</h3>

    <h3>Art Name:{{$orderdet->art_title}}</h3>

    <h3>Art Price{{$orderdet->price}}</h3>

    <h3>Art quantity{{$orderdet->quantity}}</h3>

    <h3>Payment status{{$orderdet->payment_status}}</h3>

    <h3>Delivery status{{$orderdet->delivery_status}}</h3>
</body>
</html>