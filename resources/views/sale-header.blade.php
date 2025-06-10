<!DOCTYPE html>
<html>

<body>
@foreach($data as $item)
    <div class="">
    [
        'id'=>{{$item->id}},
        'end_price'=>{{$item->end_price??'\'\''}},
        'cost_price'=>{{$item->cost_price??'\'\''}},
        'discount'=>{{$item->discount??'\'\''}}
    ],
    </div>
@endforeach
</body>

</html>
