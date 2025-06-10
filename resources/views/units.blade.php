<!DOCTYPE html>
<html>

<body>
@foreach($data as $unit)
    <div class="">

        ['id'=>{{$unit->id}},
        'name'=>'{{$unit->name}}',
        'count'=>{{$unit->count}},
        'product_id'=>{{$unit->product_id}}],
    </div>
@endforeach
</body>

</html>
