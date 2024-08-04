@extends('clinet.index')

@section('main')
    <main class="main">
        <div class="container">
            {{-- <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
            <li><a href="#">Shopping Cart</a></li>
            <li><a href="#">Checkout</a></li>
            <li class="active"><a href="#">Order Complete</a></li>
        </ul> --}}

            <div class="row">
                <div class="col-lg-12">
                    <div class="order-complete">
                        <h3>Thank You for Your Order!</h3>
                        <p>Your order has been successfully placed. Here are the details:</p>

                        <h4>Order #{{ $order->id }}</h4>
                        <p>Order Date: {{ $order->created_at->format('Y-m-d') }}</p>

                        <h5>Order Summary</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        {{-- <td>{{ dd($item) }}</td> --}}
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->price_per_unit }}</td>
                                        <td>{{ $item->quantity * $item->price_per_unit }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right">Subtotal</td>
                                    <td>{{ $order->orderItems->sum(function ($item) {
                                        return $item->quantity * $item->price_per_unit;
                                    }) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">Total</td>
                                    <td>{{ $order->orderItems->sum(function ($item) {
                                        return $item->quantity * $item->price_per_unit;
                                    }) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('index') }}" class="btn btn-primary">Return to Home</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
