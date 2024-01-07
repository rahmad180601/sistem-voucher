@extends('template.user')

@section('title')
Cart
@endsection

@section('style')
<link rel="stylesheet" href="{{asset('css/cart.css')}}">
@endsection

@section('content')
<div class="container">
    <!-- success message & Error message -->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if (session('errortotal'))
    <div class="alert alert-danger">
        {{ session('errortotal') }}
    </div>
@endif
    
    @php
    $total = 0;
    @endphp

    @if ($carts->count() == 0)
    <p style="text-align:center;">Your Cart is Empty</p>
    @else

    <div>
        <h3>{{ $carts->count() }} Item in your cart</h3>
    </div>


    @foreach ($carts as $item)
    <div class="cart">
        <div class="row">
            <div class="col-lg-3">
                <img class="img-cart" src="{{ asset('image/produk/'.$item->produk->image) }}" alt="">
            </div>
            <div class="col-lg-9">
                <div class="top">
                    <p class="item-name">{{ $item->produk->name_produk }}</p>
                    <div class="top-right">
                        <p class="">Rp{{ number_format($item->produk->price) }}</p>
                        <select name="qty" id="qty" class="quantity" data-item="{{ $item->id }}">
                            @for ($i = 1; $i <= 10; $i++) <option value="{{$i}}"
                                {{ $item->qty == $i ? 'selected' : '' }}>{{$i}}</option>
                                @endfor
                        </select>
                        <!-- Subtotal -->
                        <p class="total-item">Rp {{ number_format($item->produk->price * $item->qty) }}</p>
                    </div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="bottom">
                    <div class="row">
                        <p class="col-lg-6 item-desc">
                            {{ $item->produk->desc }}
                        </p>
                        <div class="offset-lg-4">

                        </div>
                        <div class="col-lg-2">
                            <!-- delete cart -->
                            <form action="{{ route('cart.delete', $item->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
    $total += ($item->produk->price * $item->qty);
    @endphp

    @php
    $card_id = $item->id;
    @endphp
    @endforeach

    <div class="totalz">
        <h4 class="total-price">Total Price: Rp {{ number_format($total) }}</h4>
        @if (session('voucher_amount'))
            <h4 class="total-price text-danger">Discount: Rp {{ number_format(session('voucher_amount')) }}</h4>
            <h4 class="total-price">Final Price: Rp {{ number_format($total - session('voucher_amount')) }}</h4>
            @php
                session()->forget('voucher_amount');
            @endphp
        @endif
    </div>


    <form action="{{ route('apply.voucher') }}" method="POST" style="margin-top: 20px;">
        @csrf
        <div class="form-group">
            <label for="code">Enter Voucher Code:</label>
            <input type="text" class="form-control" id="code" name="code" required>
            {{-- <input type="text" class="form-control" id="cart_id" name="cart_id" value="{{ $card_id }}"> --}}
            <input type="hidden" class="form-control" id="subtotal" name="subtotal" value="{{ $total }}">
        </div>
        <button type="submit" class="btn btn-primary">Apply Voucher</button>
      
    </form>

</div>

<form action="{{ route('checkout.store') }}" method="POST" style="margin-left: 700px;">
    @csrf
    <input type="hidden" name="subtotal" id="subtotal" value="{{ $total }}">
    <input type="hidden" class="form-control" id="voucher_id" name="voucher_id" value="{{ session('voucher_id') ?? '' }}">
    @foreach ($carts as $item)
        <input type="hidden" name="total" value="{{ $item->produk->price * $item->qty }}">
    @endforeach
    <button type="submit" class="btn btn-primary">Checkout</button>
</form>
@endif
@endsection

@section('script')
<script type="text/javascript">
    (function () {
        const classname = document.querySelectorAll('.quantity');

        Array.from(classname).forEach(function (element) {
            element.addEventListener('change', function () {
                const id = element.getAttribute('data-item');
                axios.patch(`/cart/${id}`, {
                        quantity: this.value,
                        id: id
                    })
                    .then(function (response) {
                        //console.log(response);
                        window.location.href = '/cart'
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            })
        })
    })();

</script>
<script type="text/javascript" src="{{asset('js/script.js')}}"></script>
@endsection
