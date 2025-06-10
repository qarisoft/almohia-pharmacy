<!DOCTYPE html>
<html>

<body>
@foreach($data as $item)
    <div class="">
    [
        'id'=>{{$item->id}},
        'quantity'=>{{$item->quantity}},
        'bill_number'=>{{$item->bill_number??$item->header->bill_number}},
        'product_id'=>{{$item->product_id}},
        'header_id'=>{{$item->header_id}},
        'vendor_id'=>{{$item->vendor_id??'\'\''}},
        'payment_type'=>'{{$item->payment_type}}',
        'total_cost_price'=>{{$item->total_cost_price}},
        'unit_cost_price'=>{{$item->unit_cost_price}},
        'expire_date'=>'{{$item->expire_date}}',
    ],
    </div>
@endforeach
</body>

</html>
