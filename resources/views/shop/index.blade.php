@extends('template.user')

@section('title')
    Shop
@endsection

@section('style')
<link rel="stylesheet" href="{{asset('css/shop.css')}}">
@endsection

@section('content')
<div class="content">
  <div class="container">
    <div class="row">
      {{-- <div class="col-lg-4">
        <div class="category">
          <h2 id="category-label">Categories</h2>
          <ul class="list-group">
            <li class="list-group-item"><a href="{{ route('shop') }}">all</a></li>
            @foreach ($all as $item)
            <li class="list-group-item {{ $item->id == $id ? 'active' : '' }}"> <a href="{{ route('shop.category', $item->id) }}">{{ $item->name }}</a></li>
            @endforeach
          </ul>
        </div>
        <h2 id="category-label" class="text-center mt-5">Search Product</h2>
        <form action="" class="form-inline ml-5">
          <input type="text" class="form-control" name="search">
          <button class="btn btn-primary">Search</button>
        </form>
      </div> --}}
        <div class="col-lg-12">
          <div class="item-list" style="margin-bottom: 2em;">
          <h2>Our Products</h2>
          <hr style="margin-bottom: 2em;">
          <div class="row list-product">
            @foreach ($product as $item)
            <div class="col-lg-4 item mt-5">
              <a href="{{ route('shop.show', $item->id) }}">
              <img src="{{ asset('image/produk/'.$item->image) }}" alt="nopic" height="180" width="180">
              </a>
              <p class="product-name mt-3 font-weight-bold"><a href="">{{ $item->name }}</a></p>
              <p class="product-price">Rp{{ number_format($item->price) }}</p>
            </div>
            @endforeach
          </div>
        </div>
        {{ $product->links()}}
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/script.js')}}"></script>
@endsection

