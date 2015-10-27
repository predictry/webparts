@extends('layouts.front')
@section('content')
<div class="col-sm-12">
    <div class='product-list'>
        <div class="row">

            <?php
            $arrItems = $items->toArray();
            $arrItems = $arrItems['data'];

            $i             = 1;
            $num_per_rows  = 6;
            $child_row_css = array(3 => 'col-sm-6 col-md-4', 4 => 'col-sm-6 col-md-3', 6 => 'col-lg-2');
            $full_str      = $full_str2     = $str           = $str2          = "";
            ?>
            @foreach ($arrItems as $item)
            <?php
            $str           = '';
            if ($i % $num_per_rows == 1 && $i > $num_per_rows - 1) {
                ?></div><div class='row'><?php
            }

            $img_src = 'https://s3-ap-southeast-1.amazonaws.com/media.redmart.com/newmedia/460x/coming_soon.jpg';
            if (isset($item['img_url'])) {
                if ($tenant == "SOUKAIMY") {
                  if (substr($item['img_url'],0 , 4) !== "http") {
                    $img_src        = "http://www.soukai.my". $item['img_url'];
                  }
                  $itemid  = str_replace("-", "",($item['id']));
                  $itemid  = str_replace("_", "", $itemid);
                } else {
                  $img_src        = $item['img_url'];
                  $itemid = $item['id'];
                }

                $item_local_url = URL::to("tenant/{$tenant}/item/{$itemid}/detail");
                ?><div class='column column {{ $child_row_css[$num_per_rows] }}'><?php
                ?><a href='{{$item_local_url}}'><img src='{{$img_src}}' class="img-responsive img-rounded" alt='Related Thumbnails'></a><?php
                ?><div class='description'><a href='{{$item_local_url}}'><h4>{{$item['name']}}</h4></a></div><?php
                ?><div class='price'><h5>Price: {{$item['price']}}</h5></div>
                    <div class='controls'>
                        <!--<button class='btn btn-default add-to-cart' onclick='addToCart({{$item['id']}});'>Add To Cart</button>-->
                        <a class='btn btn-default pull-right view' href='{{ $item_local_url }}'><i class='fa fa-search'></i></a>
                    </div>
                </div><?php
                if ($i % $num_per_rows == 0 && $i > $num_per_rows - 1) {
                    ?><div class='clearfix'></div><?php
                }

                $full_str2 .= $str2;
                $i+=1;
            }
            ?>
            @endforeach
        </div>
    </div>
    <div class="text-center">
        <?php echo $items->render(); ?>
    </div>
</div>
@stop
