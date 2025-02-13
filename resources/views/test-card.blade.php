<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src=https://tap-sdks.b-cdn.net/card/1.0.2/index.js></script>
    <!-- <script src="/payment.js"></script> -->

    <title>card demo</title>
</head>

<body>
    <div id="card-sdk-id"></div>
    <!-- <button id="card-v2" onclick="window.CardSDK.tokenize()">Submit</button> -->
    <script>
                    const { renderTapCard, Theme, Currencies, Direction, Edges, Locale } = window.CardSDK
                    const { unmount } = renderTapCard('card-sdk-id', {
                                    publicKey: 'pk_test_fWZlLPHqE3Qbxk5Y4h1V2Tp7',
                                    merchant: {
                                                    id: '49812912'
                                    },
                                    transaction: {
                                                    amount: 10,
                                                    currency: Currencies.SAR
                                    },
                                    customer: {
                                                    // id: 'customer id',
                                                    name: [
                                                                    {
                                                                                    lang: Locale.EN,
                                                                                    first: 'Test',
                                                                                    last: 'Test',
                                                                                    middle: 'Test'
                                                                    }
                                                    ],
                                                    nameOnCard: 'Test Test',
                                                    editable: true,
                                                    contact: {
                                                                    email: 'test@gmail.com',
                                                                    phone: {
                                                                                    countryCode: '20',
                                                                                    number: '1000000000'
                                                                    }
                                                    }
                                    },
                                    acceptance: {
                                                    supportedBrands: ['VISA', 'MASTERCARD'],
                                                    supportedCards: "ALL"
                                    },
                                    fields: {
                                                    cardHolder: true
                                    },
                                    addons: {
                                                    displayPaymentBrands: true,
                                                    loader: true,
                                                    saveCard: false
                                    },
                                    interface: {
                                                    locale: Locale.EN,
                                                    theme: Theme.LIGHT,
                                                    edges: Edges.CURVED,
                                                    direction: Direction.LTR
                                    },
                                    onReady: () => console.log('onReady'),
                                    onFocus: () => console.log('onFocus'),
                                    onBinIdentification: (data) => console.log('onBinIdentification', data),
                                    onValidInput: (data) => console.log('onValidInputChange', data),
                                    onInvalidInput: (data) => console.log('onInvalidInput', data),
                                    onChangeSaveCardLater: (isSaveCardSelected) => console.log(isSaveCardSelected, " :onChangeSaveCardLater"), // isSaveCardSelected:boolean
                                    onError: (data) => console.log('onError', data),
                                    onSuccess: (data) => console.log('onSuccess', data)
                    })
    </script>
</body>

</html>
