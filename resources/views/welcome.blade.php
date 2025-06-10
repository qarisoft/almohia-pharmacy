<!DOCTYPE html>
<html >

<body >
{{--        @foreach($product_inputs as $product)--}}
{{--            <div class="">--}}
{{--                ['ex' => {{$product->product->expire_date??'\'\''}},'u_cost'=>{{$product->unit_cost_price}},'bill_number'=>{{$product->header->bill_number}}, 'qt' => {{$product->quantity??1}}, 'n' => '{{$product->product->name_ar}}','product_id'=>{{$product->product->id}}],--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--            {{json_encode($products)}}--}}
@foreach($products as $product)
    <div class="">
        [
        'id'=>{{$product->id}},'u_p'=>{{$product->unit_price??0}},
        'bc'=>'{{$product->barcode??'-'}}', 'n' => '{{$product->name_ar}}',
        'ne'=>'{{$product->name_en??'-'}}','scientific_name'=>'{{$product->scientific_name??'-'}}',
        'units'=>[
        @foreach($product->units as $unit)
            ['id'=>{{$unit->id}},'count'=>{{$unit->count}},'product_id'=>{{$unit->product_id}}],
        @endforeach

        ]
        ],
    </div>
@endforeach
</body>

</html>
