@extends('clinet.index')

@section('main')
<main class="main">
    <div class="container">
        {{-- <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
            <li class="active"><a href="#">Shopping Cart</a></li>
            <li><a href="#">Checkout</a></li>
            <li class="disabled"><a href="#">Order Complete</a></li>
        </ul> --}}

        <div class="row">
            <div class="col-lg-8">
                @if($carts->isNotEmpty())
                    <div class="cart-table-container">
                        <table class="table table-cart">
                            <thead>
                                <tr>
                                    <th class="thumbnail-col"></th>
                                    <th class="product-col">Product</th>
                                    <th class="price-col">Price</th>
                                    <th class="qty-col">Quantity</th>
                                    <th class="text-right">Subtotal</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $item)
                                <tr class="product-row">
                                    <td>
                                        <figure class="product-image-container">
                                            <a href="product.html" class="product-image">
                                                <img src="{{ asset('client_assets') }}/assets/images/products/product-4.jpg" alt="product">
                                            </a>
                                        </figure>
                                    </td>
                                    <td class="product-col">
                                        <h5 class="product-title">
                                            <a href="#">{{ $item->product->name }}</a>
                                        </h5>
                                    </td>
                                    <td>{{ $item->product->sale_price }}</td>
                                    <td>
                                        <div class="product-single-qty">
                                            <input class="form-control" type="text" value="{{ $item->quantity }}">
                                        </div>
                                    </td>
                                    <td class="text-right"><span class="subtotal-price">{{ $item->product->sale_price * $item->quantity }}</span></td>
                                    <td class="text-right">
                                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="clearfix">
                                        <div class="float-left">
                                            <div class="cart-discount">
                                                <form action="#">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm" placeholder="Coupon Code" required>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-sm btn-primary" type="submit">Apply Coupon</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="float-right">
                                            <form action="{{ route('cart.update', ['cart' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-shop btn-primary btn-sm">Update Cart</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <p>Your cart is empty.</p>
                @endif
            </div>

            <div class="col-lg-4">
                @if($totalPrice > 0)
                    <div class="cart-summary">
                        <h3>CART TOTALS</h3>
                        <table class="table table-totals">
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td>{{ $totalPrice }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td>{{ $totalPrice }}</td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="checkout-methods">
                            <a href="{{ route('cart.checkout') }}" class="btn btn-block btn-dark">Proceed to Checkout <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="mb-6"></div>
</main>
@endsection
