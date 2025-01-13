<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>apple pay button</title>
    <link rel="stylesheet" href="https://tap-sdks.b-cdn.net/apple-pay/build-1.1.6/main.css" />
    <script src="https://tap-sdks.b-cdn.net/apple-pay/build-1.1.6/main.js"></script>
</head>

<body>
    <div id="apple-pay-button"></div>
    <script type="text/javascript">
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

    </script>
</body>

</html>
