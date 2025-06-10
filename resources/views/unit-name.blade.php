<!DOCTYPE html>
<html>

<body>
@foreach($data as $unit)
    <div class="">

        ['id'=>{{$unit->id}},'name'=>'{{$unit->name}}'],
    </div>
@endforeach
</body>

</html>
