@extends('dash.layouts.index')

@section('content')



    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Create Business Form</h3>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body p-0">
                    <div class="bs-stepper">
                        <div class="bs-stepper-header" role="tablist">
                            <!-- your steps here -->
                            <div class="step" data-target="#brand-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="logins-part"
                                    id="logins-part-trigger">
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="bs-stepper-label">Cart Information</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#contact-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="information-part"
                                    id="information-part-trigger">
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="bs-stepper-label">Customer information</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#bank-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="information-part"
                                    id="information-part-trigger">
                                    <span class="bs-stepper-circle">3</span>
                                    <span class="bs-stepper-label">Payment Information</span>
                                </button>
                            </div>
                        </div>
                        <form>
                            @csrf
                            {{-- request type --}}

                            <input type="text" hidden value="createBusiness">
                            <div class="bs-stepper-content">
                                <!-- your steps content here -->
                                <div id="brand-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">

                                    <div class="form-group">
                                        <label for="transactionCurrency">Currency</label>
                                        <select name="transactionCurrency" class="form-control" id="transactionCurrency">
                                            <option value="AED">AED</option>
                                            <option value="SAR">SAR</option>
                                            <option value="USD">USD</option>
                                            <option value="KWD">KWD</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="transactionAmount">Amount</label>
                                        <input type="number" name="transactionAmount" class="form-control"
                                            id="transactionAmount" placeholder="Enter Amount">
                                    </div>
                                    <div class="form-group">
                                        <label for="webhook">Webhook</label>
                                        <input type="text" name="transaction[webhook]" class="form-control"
                                            id="webhook" placeholder="Enter Webhook URL">
                                    </div>

                                    <button class="btn btn-primary" type="button" onclick="stepper.next()">Next</button>
                                </div>

                                <div id="contact-part" class="content" role="tabpanel"
                                    aria-labelledby="logins-part-trigger">

                                    <div class="form-group">
                                        <label for="contactPersonFirstName">First Name</label>
                                        <input type="text" name="contact_person[name][first_name]" class="form-control"
                                            id="contactPersonFirstName" placeholder="Enter First Name">
                                    </div>

                                    <div class="form-group">
                                        <label for="contactPersonMiddleName">Middle Name</label>
                                        <input type="text" name="contact_person[name][middle_name]" class="form-control"
                                            id="contactPersonMiddleName" placeholder="Enter Middle Name">
                                    </div>

                                    <div class="form-group">
                                        <label for="contactPersonLastName">Last Name</label>
                                        <input type="text" name="contact_person[name][last_name]" class="form-control"
                                            id="contactPersonLastName" placeholder="Enter Last Name">
                                    </div>

                                    <div class="form-group">
                                        <label for="contactPersonEmail">Email</label>
                                        <input type="email" name="contact_person[email]" class="form-control"
                                            id="contactPersonEmail" placeholder="Enter Email">
                                    </div>

                                    <div class="form-group">
                                        <label for="contactPersonCountryCode">Country Code</label>
                                        <input type="text" name="contact_person[phone][country_code]"
                                            class="form-control" id="contactPersonCountryCode"
                                            placeholder="Enter Country Code">
                                    </div>

                                    <div class="form-group">
                                        <label for="contactPersonPhoneNumber">Phone Number</label>
                                        <input type="text" name="contact_person[phone][number]" class="form-control"
                                            id="contactPersonPhoneNumber" placeholder="Enter Phone Number">
                                    </div>


                                    <button class="btn btn-primary" type="button"
                                        onclick="stepper.previous()">Previous</button>
                                    <button class="btn btn-primary" type="button" onclick="stepper.next()">Next</button>
                                </div>
                                <div id="bank-part" class="content" role="tabpanel"
                                    aria-labelledby="information-part-trigger">


                                    <div>
                                        <label>Choose Payment Method:</label>

                                        <div>
                                            <label>
                                                <input type="radio"  name="paymentMethod" value="cards">
                                                Cards
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="paymentMethod" value="applePay"> Apple Pay
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="paymentMethod" value="benefitPay"> Benefit
                                                Pay
                                            </label>
                                        </div>

                                    </div>

                                    <hr>

                                    <div style="display: none" id="card-sdk-id"></div>
                                    <div style="display: none" id="apple-pay-button"></div>
                                    <div style="display: none" id="benefit-pay-button"></div>


                                    <hr>
                                    <br>

                                    <button type="button" class="btn btn-primary"
                                        onclick="stepper.previous()">Previous</button>


                                    {{-- <input type="submit" class="btn btn-primary" value="Submit"> --}}
                                    {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    Visit <a href="https://github.com/Johann-S/bs-stepper/#how-to-use-it">bs-stepper documentation</a> for
                    more examples and information about the plugin.
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->




@endsection

@section('script')
    <script>
        // Function to display the corresponding payment method section
        document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Hide all sections
                document.getElementById('apple-pay-button').style.display = 'none';
                document.getElementById('benefit-pay-button').style.display = 'none';
                document.getElementById('card-sdk-id').style.display = 'none';

                     const firstNameInput = document.getElementById('contactPersonFirstName').value;
                    const middleNameInput = document.getElementById('contactPersonMiddleName').value;
                    const lastNameInput = document.getElementById('contactPersonLastName').value;
                    const emailInput = document.getElementById('contactPersonEmail').value;
                    const countryCodeInput = document.getElementById('contactPersonCountryCode').value;
                    const phoneNumberInput = document.getElementById('contactPersonPhoneNumber').value;

                // Show the selected section
                if (this.value === 'applePay') {
                    // var applePayRender = undefined


                    // Get transaction fields
                    const amount = document.getElementById('transactionAmount')
                        .value; // Adjust ID if needed
                    const currency = document.getElementById('transactionCurrency')
                        .value; // Adjust ID if needed
                    console.log(firstNameInput);

                    const {
                        render,
                        abortApplePaySession
                    } =
                    window.TapApplepaySDK
                    // applePayRender?.unmount()
                    render({
                            debug: false,
                            scope: 'TapToken',
                            publicKey: 'pk_test_Vlk842B1EA7tDN5QbrfGjYzh',
                            environment: 'development',
                            merchant: {
                                domain: 'tap-erp.invogp.com',
                                id: 'merchant_pUErA4725620r2id6810Z276'
                            },
                            acceptance: {
                                supportedBrands: ['masterCard', 'visa']
                            },
                            features: {
                                supportsCouponCode: false
                            },
                            transaction: {
                                currency: 'AED', // Dynamically set from form
                                amount: 100 // Dynamically set from form
                            },
                            customer: {
                                name: [{
                                    locale: 'en',
                                    first: 'firstName',
                                    middle: 'middleName',
                                    last: 'lastName'
                                }],
                                contact: {
                                    email: 'test@test.com',
                                    phone: {
                                        number: '23423432',
                                        countryCode: '+20'
                                    }
                                }
                            },
                            interface: {
                                locale: 'en',
                                theme: 'dark',
                                type: 'buy',
                                edges: 'curved'
                            },
                            onCancel: () => {
                                // it's called when the user cancels the payment
                                console.log('onCancel')
                            },
                            onError: (error) => {
                                // it's called when there is an error with the payment
                                console.log('onError', error)
                            },
                            onReady: () => {
                                // it's called when the apple pay button is ready to click
                                console.log('onReady')
                            },
                            onSuccess: async (data, event) => {
                                // it's called when the payment is successful
                                console.log('onSuccess', data)
                                // event is the same as the event in the onpaymentauthorized event https://developer.apple.com/documentation/apple_pay_on_the_web/applepaypaymentauthorizedevent
                                console.log('apple pay event', event)
                            }
                        },
                        'apple-pay-button'
                    )
                    document.getElementById('apple-pay-button').style.display = 'block';
                } else if (this.value === 'benefitPay') {
                    myHashString = "dsjflk;sadjf;lkasdjf;klasdjf;klasdjf;laskdjf;lskd";

                    console.log("Generated Hash String: ", myHashString);
                    const {
                        render,
                        Edges,
                        Locale,
                        ThemeMode
                    } = window.TapBenefitpaySDK
                    render({
                            operator: {
                                publicKey: 'pk_test_Vlk842B1EA7tDN5QbrfGjYzh',
                                hashString: myHashString
                            },
                            debug: true,
                            merchant: {
                                id: 'merchant_pUErA4725620r2id6810Z276'
                            },
                            transaction: {
                                amount: '12',
                                currency: 'AED'
                            },
                            reference: {
                                transaction: 'txn_123',
                                order: 'ord_123'
                            },
                            customer: {
                                names: [{
                                    lang: Locale.EN,
                                    first: 'test',
                                    last: 'tester',
                                    middle: 'test'
                                }],
                                contact: {
                                    email: 'test@gmail.com',
                                    phone: {
                                        countryCode: '20',
                                        number: '1234567'
                                    }
                                }
                            },
                            interface: {
                                locale: Locale.EN,
                                edges: Edges.CURVED
                            },
                            post: {
                                url: ''
                            },
                            onReady: () => {
                                console.log('Ready')
                            },
                            onClick: () => {
                                console.log('Clicked')
                            },
                            onCancel: () => console.log('cancelled'),
                            onError: (err) => console.log('onError', err),
                            onSuccess: (data) => {
                                console.log(data)
                            }
                        },
                        'benefit-pay-button'
                    )

                    document.getElementById('benefit-pay-button').style.display = 'block';
                } else if (this.value === 'cards') {

                    const {
                        renderTapCard,
                        Theme,
                        Currencies,
                        Direction,
                        Edges,
                        Locale
                    } = window.CardSDK
                    const {
                        unmount
                    } = renderTapCard('card-sdk-id', {
                        publicKey: 'pk_test_Vlk842B1EA7tDN5QbrfGjYzh', // Tap's public key
                        merchant: {
                            id: 'merchant_pUErA4725620r2id6810Z276'
                        },
                        transaction: {
                            amount: 1,
                            currency: Currencies.SAR
                        },
                        customer: {
                            name: [{
                                lang: Locale.EN,
                                first: 'Test',
                                last: 'Test',
                                middle: 'Test'
                            }],
                            nameOnCard: 'Test',
                            editable: true,
                            contact: {
                                email: 'test@gmail.com',
                                phone: {
                                    countryCode: '971',
                                    number: '52999944'
                                }
                            }
                        },
                        acceptance: {
                            supportedBrands: ['AMERICAN_EXPRESS', 'VISA', 'MASTERCARD'], //Remove the ones that are NOT enabled on your Tap account
                            supportedCards: "ALL" //To accept both Debit and Credit
                        },
                        fields: {
                            cardHolder: true
                        },
                        addons: {
                            displayPaymentBrands: true,
                            loader: true,
                            saveCard: true
                        },
                        interface: {
                            locale: Locale.EN,
                            theme: Theme.LIGHT,
                            edges: Edges.CURVED,
                            direction: Direction.LTR
                        }
                    })
                    document.getElementById('card-sdk-id').style.display = 'block';
                }


            });
        });
    </script>
@endsection
