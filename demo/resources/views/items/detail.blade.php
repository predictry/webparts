@extends('layouts.front')
@section('content')
<div class="col-sm-12">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo URL::to("tenants"); ?>">Home</a></li>
            <li><a href="<?php echo URL::to("tenant/{$tenant}/items"); ?>">Catalog</a></li>
            <li class="active">{{ $item->name or '' }}</li>
        </ol>
        <div class="pull-right"><a class="btn btn-default" href="<?php echo URL::to('/'); ?>"><i class="fa fa-shopping-cart"></i> Shopping Cart ( <?php echo 0; ?> ) Items</a></div>
    </div>
    <div class="col-lg-1 clearfix">
        <?php 
             if (($tenant == "SOUKAIMY") && (substr($item['img_url'],0 , 4) !== "http"))  {
                  $img_src        = "http://www.soukai.my". $item['img_url'];
              } else {
                  $img_src        = $item['img_url'];
              }
        ?>
        <ul class="list-unstyled product-thumbs">
            <li class="thumbnail"><a href="javascript:void(0);"><img src="{{ $img_src or '' }}" class="img-responsive img-rounded" alt="" onerror='imgError(this);' alt="small thumbnail"></a></li>
            <li class="thumbnail"><a href="javascript:void(0);"><img src="{{ $img_src or '' }}" class="img-responsive img-rounded" alt="" onerror='imgError(this);' alt="small thumbnail"></a></li>
            <li class="thumbnail"><a href="javascript:void(0);"><img src="{{ $img_src or '' }}" class="img-responsive img-rounded" alt="" onerror='imgError(this);' alt="small thumbnail"></a></li>
        </ul>
    </div>
    <div class="col-lg-5">
        <img src="{{ $img_src or '' }}" class="img-responsive img-rounded" alt="" onerror='imgError(this);'>
    </div>
    <div class="col-lg-6">

        <div class="product-title">
            <h1>{{ $item->name or '' }}</h1>
        </div>

        <div class="weight">
            <p>{{ $item->brand or '' }}</p>
        </div>

        <div class="product-description">
            <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore, harum, maxime, placeat, doloremque laudantium ipsum nulla ab in consectetur fugiat nam saepe quidem sequi at ut facilis aliquid alias impedit!</p>-->
            <p>{{ $item->description or '' }}</p>
        </div>

        <div class="price">
            <h3>Price: {{ $item->price or 0 }}</h3>
        </div>

        <div class="cart">
            <a href="{{ $item->item_url }}" class="btn btn-default btn-primary text-uppercase" target="_blank" id="">Visit Original Item Page</a>
            <?php // echo Form::open(); ?>
            <?php // echo Form::hidden('product_id', $item->id ? $item->id : 0); ?>
            <!--<button class="btn btn-default input-lg disabled">ADD TO MY WISHLIST</button>-->
            <?php // echo Form::close(); ?>
        </div>
    </div>
    <div class="col-lg-offset-3 col-lg-6">
        <div class="box-heading text-center"><h3>Recommended for you</h3></div>
      
    </div>
    <div class="col-md-12">
      
      <ins class="predictry-duo predictryTyped" data-predictry-item-id="{{ $item->id }}" data-predictry-currency="$" data-predictry-title="Others are also interested" data-predictry-limit="10"></ins>
    
    </div>

    <div class="col-md-12"> 
      <ins class="predictry-similar predictryTyped" data-predictry-item-id="{{ $item->id }}" data-predictry-currency="$" data-predictry-limit="10"></ins>
    </div>

    <div class="col-md-12"> 
      <ins class="predictry-oivt predictryTyped" data-predictry-item-id="{{ $item->id }}" data-predictry-currency="$" data-predictry-limit="10"></ins>
    </div>

    <div class="col-md-12">
      <ins class="predictry-oipt predictryTyped" data-predictry-item-id="{{ $item->id }}" data-predictry-currency="$" data-predictry-limit="10"></ins>
    </div>
    <div class="col-md-12">
      <ins class="predictry-oip predictryTyped" data-predictry-item-id="{{ $item->id }}" data-predictry-currency="$" data-predictry-limit="10"></ins>
    </div>
    <script type="text/javascript">_predictry.push(['getWidget']);</script>
    <script type="text/javascript">

</div>
@stop
