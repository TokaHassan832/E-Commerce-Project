<!DOCTYPE html>
<html lang="en">

<body>

@include('components.header')

@include('components.breadcrumb', ['title' => 'Checkout'])


@if (session()->has('message'))
    <div class="spacer col-lg-8"></div>
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@if(count($errors) > 0)
    <div class="spacer"></div>
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span>
            </h5>
            <div class="bg-light p-30 mb-5">
                <div class="row">

                    <div class="col-md-6 form-group">
                        <label>Mobile No</label>
                        <input name="mobile" class="form-control" type="text" placeholder="+123 456 789">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 1</label>
                        <input name="address1" class="form-control" type="text" placeholder="123 Street">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 2</label>
                        <input name="address2" class="form-control" type="text" placeholder="123 Street">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Country</label>
                        <select class="custom-select">
                            <option selected>United States</option>
                            <option>Afghanistan</option>
                            <option>Albania</option>
                            <option>Algeria</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>City</label>
                        <input class="form-control" type="text" placeholder="New York">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>State</label>
                        <input class="form-control" type="text" placeholder="New York">
                    </div>
                    <div class="col-md-12 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="newaccount">
                            <label class="custom-control-label" for="newaccount">Create an account</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="shipto">
                            <label class="custom-control-label" for="shipto" data-toggle="collapse"
                                   data-target="#shipping-address">Ship to different address</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span
                    class="bg-secondary pr-3">Order Total</span></h5>

            <div class="bg-light p-30 mb-5">
                <div class="border-bottom">
                    <h6 class="mb-3">Products</h6>
                    @foreach (Cart::content() as $item)
                        <div class="d-flex justify-content-between mb-3">
                            <h6>{{ $item->model->name }}</h6>
                            <h6><img src="{{ $item->model->image }}" alt="Product Image" style="width: 50px;">
                            </h6>
                            <h6>{{ presentPrice($item->model->price_after_offer) }}</h6>
                        </div>
                    @endforeach
                </div>
                <div class="border-bottom pt-3 pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6>   {{ presentPrice(Cart::subtotal()) }}</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Tax</h6>
                        <h6 class="font-weight-medium">{{ presentPrice(Cart::tax()) }}</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5>{{ presentPrice(Cart::total()) }}</h5>
                    </div>
                </div>
            </div>

            <h5 class="section-title position-relative text-uppercase mb-3"><span
                    class="bg-secondary pr-3">Payment</span></h5>
            <div class="bg-light p-30 mb-5">
                <form action="{{ route('payment.store') }}" method="POST" id="payment-form">
                    @csrf
                    <div class="mb-3">
                        <div class="flex form-group">
                            <label>Your Name</label>
                            <input name="name" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="flex form-group">
                            <label>Your Email</label>
                            <input name="email" class="form-control" type="email">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="payment-method"
                               class="inline-block font-bold mb-2 uppercase text-sm tracking-wider">Payment
                            Method</label>
                        <div>
                            <input type="radio" name="payment_method" id="card" value="card" checked>
                            <label for="card">Credit Card</label>
                        </div>
                        <div>
                            <input type="radio" name="payment_method" id="paypal" value="paypal">
                            <label for="paypal">PayPal</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="card" class="inline-block font-bold mb-2 uppercase text-sm tracking-wider">Card
                            details</label>
                        <div class="bg-gray-100 p-6 rounded-xl">
                            <div id="card-element"></div>
                        </div>
                    </div>
                    <a href="{{ route('payment.store') }}">
                        <button type="submit" class="btn btn-block btn-primary font-weight-bold py-3">Place Order</button>
                    </a>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const {paymentMethod, error} = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {}
        });

        if (error) {
        } else {
            const paymentMethodInput = document.createElement('input');
            paymentMethodInput.setAttribute('type', 'hidden');
            paymentMethodInput.setAttribute('name', 'payment_method');
            paymentMethodInput.setAttribute('value', paymentMethod.id);
            form.appendChild(paymentMethodInput);

            form.submit();
        }
    });
</script>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="assets/lib/easing/easing.min.js"></script>
<script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Contact Javascript File -->
<script src="assets/mail/jqBootstrapValidation.min.js"></script>
<script src="assets/mail/contact.js"></script>

<!-- Template Javascript -->
<script src="assets/js/main.js"></script>

</body>

</html>
