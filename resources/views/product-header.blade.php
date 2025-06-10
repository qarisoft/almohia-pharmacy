<!DOCTYPE html>
<html>

<body>
@foreach($data as $item)
    <div class="">
    [
        'id'=>{{$item->id}},
        'bill_number'=>{{$item->bill_number}},
        'total_price'=>{{$item->total_price}},
    ],
    </div>
@endforeach
</body>

</html>
