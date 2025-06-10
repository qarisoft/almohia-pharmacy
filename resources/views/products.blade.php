<!DOCTYPE html>
<html>

<body>
@foreach($data as $product)
    <div class="">
    [
        'id'=>{{$product->id}},
        'unit_price'=>{{$product->unit_price??0}},
        'barcode'=>'{{$product->barcode}}',
        'name_ar' => "{{str_replace("'",'\\\'',$product->name_ar,)}}",
        'name_en' => "{{str_replace("'",'\\\'',$product->name_en,)}}",
        'scientific_name'=>'{{$product->scientific_name}}',
        'company_id'=>{{$product->company_id??'\'\''}}
    ],
</div>
@endforeach
</body>
</html>

