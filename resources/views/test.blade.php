<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>apple pay button</title>
    <link rel="stylesheet" href="https://tap-sdks.b-cdn.net/apple-pay/build-1.1.6/main.css" />
    <script src="https://tap-sdks.b-cdn.net/apple-pay/build-1.1.6/main.js"></script>
    {{-- benifi pay SDK --}}
<script src="https://tap-sdks.b-cdn.net/benefit-pay/build-1.0.20/main.js"></script>
</head>

<body>
    <div id="apple-pay-button"></div>
    <hr>
    <div id="benefit-pay-button"></div>
    {{-- <script type="text/javascript">
        // var applePayRender = undefined
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
                    currency: 'AED',
                    amount: '20'

                },
                customer: {
                    name: [{
                        locale: 'en',
                        first: 'test',
                        last: 'tester',
                        middle: 'test'
                    }],
                    contact: {
                        email: 'test@gmail.com',
                        phone: {
                            number: '1000000000',
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

    </script> --}}
<script type="text/javascript">
// Input fields for Hash Calculation
publicApiKey = 'pk_test_Iebi6FLQgwu0RJEVmZfnMqCv';  //Your Public API Key Provided by Tap
amount = 'charge.amount'; 		//charge amount formatted to 3 decimal places
currency = 'charge.currency'; //charge currency (BHD)
transactionReference = 'reference.transaction' //reference transaction
postUrl = 'charge.postUrl' //the Post URL that receives the webhook
secretAPIKey = "sk_test_v13n2MyPKHOi7gWFf8CIS9jY	"; //Your secret API Key provided by Tap

// Concatenate the fields to form the string that will be hashed
toBeHashed = `x_publickey${publicApiKey}x_amount${amount}x_currency${currency}x_transaction${transactionReference}x_post${postUrl}`;

// Log the string to be hashed for verification
console.log("String to be hashed: ", toBeHashed);

// Create the hash string using HMAC SHA256 and your secret API key
// myHashString = hash_hmac('sha256', toBeHashed, secretAPIKey);
myHashString = "dsjflk;sadjf;lkasdjf;klasdjf;klasdjf;laskdjf;lskd";

// Output the resulting hash string (this is what you need to send)
console.log("Generated Hash String: ", myHashString);
    const { render, Edges, Locale, ThemeMode } = window.TapBenefitpaySDK
    render(
        {
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
                currency: 'BHD'
            },
            reference: {
                transaction: 'txn_123',
                order: 'ord_123'
            },
            customer: {
                names: [
                    {
                        lang: Locale.EN,
                        first: 'test',
                        last: 'tester',
                        middle: 'test'
                    }
                ],
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
</script>
</body>

</html>
