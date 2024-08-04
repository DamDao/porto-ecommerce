@extends('clinet.index')
@section('main')
    <main class="main main-test">
        <div class="container checkout-container">
            {{-- <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
                <li>
                    <a href="cart.html">Shopping Cart</a>
                </li>
                <li class="active">
                    <a href="checkout.html">Checkout</a>
                </li>
                <li class="disabled">
                    <a href="#">Order Complete</a>
                </li>
            </ul> --}}

            <form action="{{ route('cart.Storecheckout') }}" method="POST" name="checkout-form" id="checkout-form">
                @method('POST')
                @csrf
                <input type="hidden" name="total" value="{{number_format($total)}}" id="">

                <div class="row">
                    <div class="col-lg-7">
                        <ul class="checkout-steps">
                            <li>
                                <h2 class="step-title">Billing details</h2>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First name
                                                <abbr class="required" title="required">*</abbr>
                                            </label>
                                            <input name="name" type="text" class="form-control" required />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Street address
                                                <abbr class="required" title="required">*</abbr></label>
                                            <input name="address" type="text" class="form-control"
                                                placeholder="House number and street name" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone <abbr class="required" title="required">*</abbr></label>
                                        <input name="phone_number" type="tel" class="form-control" />
                                    </div>
                                </div>
                                {{-- <button type="submit" class="btn btn-dark">
                                    Place order
                                </button> --}}
                                {{-- </form> --}}

                            </li>
                        </ul>
                    </div>
                    <!-- End .col-lg-8 -->

                    <div class="col-lg-5">
                        <div class="order-summary">
                            <h3>YOUR ORDER</h3>

                            <table class="table table-mini-cart">
                                <thead>
                                    <tr>
                                        <th colspan="2">Product</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart as $item)
                                        <tr>
                                            <td class="product-col">
                                                <h3 class="product-title">
                                                    {{ $item->product->name }} ×
                                                    <span class="product-qty">{{ $item->quantity }}</span>
                                                </h3>
                                            </td>

                                            <td class="price-col">
                                                <span>{{ $item->product->sale_price * $item->quantity }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    {{-- <tr class="cart-subtotal">
                                    <td>
                                        <h4>Subtotal</h4>
                                    </td>

                                    <td class="price-col">
                                        <span>{{$item->quantity}}</span>
                                    </td>
                                </tr> --}}
                                    <tr class="order-shipping">
                                        {{-- <form action="{{ route('cart.Storecheckout') }}" method="POST" name="checkout-form" id="checkout-form">
                                        @method('POST')
                                        @csrf --}}
                                        <td class="text-left" colspan="2">
                                            <h4 class="m-b-sm">Shipping</h4>

                                            <div class="form-group form-group-custom-control">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="radio" checked
                                                        value="0">
                                                    <label class="custom-control-label">Local pickup</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .form-group -->
    
                                            <div class="form-group form-group-custom-control mb-0">
                                                <div class="custom-control custom-radio mb-0">
                                                    <input type="radio" name="radio" class="custom-control-input"
                                                        value="1">
                                                    <label class="custom-control-label">Ví VNPay</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div>
                                            <!-- End .form-group -->
                                        </td>
                                        {{-- </form> --}}
                                    </tr>

                                    <tr class="order-total">
                                        <td>
                                            <h4>Total</h4>
                                        </td>
                                        <td>
                                            <b class="total-price"><span>{{ number_format($total) }}</span></b>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            {{-- 
                            <div class="payment-methods">
                                <h4 class="">Payment methods</h4>
                                <div class="info-box with-icon p-0">
                                    <p>
                                        Sorry, it seems that there are no available payment methods for your state. Please
                                        contact us if you require assistance or wish to make alternate arrangements.
                                    </p>
                                </div>
                            </div> --}}
                            <button type="submit" class="btn btn-dark " name="redirect" form="checkout-form">
                                Place order
                            </button>
                        </div>
                        <!-- End .cart-summary -->
                    </div>
                    <!-- End .col-lg-4 -->
                </div>
                <!-- End .row -->
            </form>
        </div>
        <!-- End .container -->
    </main>
    <!-- End .main -->
@endsection
