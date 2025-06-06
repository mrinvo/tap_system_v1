<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Merchant Onboarding Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        :root {
            --primary-color: #1f222a;
            --text-color: #1a1f36;
            --light-text: #4f566b;
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            color: var(--text-color);
            background-color: #f5f5f5;
        }

        .logo-container {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }

        .logo-container img {
            max-height: 50px;
            width: auto;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .step-indicator {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            justify-content: center;
        }

        .step-dot {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4f566b;
            font-size: 14px;
            font-weight: 500;
        }

        .step-dot.active {
            background: var(--primary-color);
            color: white;
        }

        .step-dot.completed {
            background: #28a745;
            color: white;
        }

        .step-line {
            flex: 0 1 100px;
            height: 2px;
            background: #dee2e6;
            margin: 0 10px;
        }

        .form-step {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: none;
            margin-bottom: 20px;
        }

        .form-step.active {
            display: block;
        }

        .step-title {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 16px;
            text-align: center;
        }

        .step-subtitle {
            color: var(--light-text);
            text-align: center;
            margin-bottom: 30px;
        }

        .account-header {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .account-header.show {
            display: block;
        }

        .options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .option-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .option-card.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .option-card:not(.disabled):hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .option-card.selected {
            border-color: var(--primary-color);
            background-color: #f5f3ff;
        }

        .option-icon {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .option-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 8px;
        }

        .option-description {
            font-size: 14px;
            color: var(--light-text);
            margin: 0;
        }

        .conditional-field {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid var(--primary-color);
        }

        .conditional-field.show {
            display: block;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: #6234e3;
        }

        .btn-secondary {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            color: var(--text-color);
        }

        .btn-secondary:hover {
            background: #e9ecef;
        }

        .congratulations {
            text-align: center;
            margin: 20px 0;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 8px;
            display: none;
        }

        .congratulations.show {
            display: block;
            animation: fadeIn 0.5s ease-in;
        }

        /* Add these styles to your existing CSS */
        .cc-email-container {
            max-width: 500px;
            margin: 0 auto;
        }

        .cc-email-group {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .cc-email-group .form-control {
            flex: 1;
        }

        .remove-cc-email {
            padding: 0.375rem 0.75rem;
        }

        #primaryEmail {
            color: #1f222a;
        }

        .summary-table {
            width: 100%;
            margin-top: 20px;
            display: none;
        }

        .summary-table.show {
            display: table;
            animation: fadeIn 0.5s ease-in;
        }

        .export-buttons {
            margin-top: 20px;
            display: none;
        }

        .export-buttons.show {
            display: flex;
            gap: 10px;
            justify-content: center;
            animation: fadeIn 0.5s ease-in;
        }

        .multi-select-container {
            max-height: 200px;
            overflow-y: auto;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .prompt-message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            display: none;
        }

        .prompt-message.show {
            display: block;
            animation: fadeIn 0.5s ease-in;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .summary-table td {
            padding: 10px;
            vertical-align: top;
        }

        .summary-table td:first-child {
            font-weight: 500;
            width: 200px;
        }

        .summary-table td:last-child {
            white-space: pre-line;
        }
    </style>
</head>

<body>
    <div class="logo-container">
        <img src="tap-logo-dark.png" alt="Company Logo">
    </div>

    <div class="container">
        <div class="step-indicator">
            <div class="step-dot active">1</div>
            <div class="step-line"></div>
            <div class="step-dot">2</div>
            <div class="step-line"></div>
            <div class="step-dot">3</div>
            <div class="step-line"></div>
            <div class="step-dot">4</div>
            <div class="step-line"></div>
            <div class="step-dot">5</div>
        </div>

        <form id="multiStepForm">
            <!-- Account Header -->
            <div class="account-header">
                <h4>Account Details</h4>
                <div id="accountSummary"></div>
            </div>

            <!-- Step 1: Service Selection -->
            <div class="form-step active" data-step="1">
                <h2 class="step-title">What Service Do You Need?</h2>
                <p class="step-subtitle">Select the service that best matches your needs</p>

                <div class="options-grid">
                    <div class="option-card" data-value="new-merchant">
                        <div class="option-icon">🏢</div>
                        <div class="option-label">New Merchant</div>
                    </div>
                    <div class="option-card disabled" data-value="existing-merchant">
                        <div class="option-icon">🔄</div>
                        <div class="option-label">Existing Merchant</div>
                    </div>
                    <div class="option-card disabled" data-value="troubleshooting">
                        <div class="option-icon">🔧</div>
                        <div class="option-label">Troubleshooting</div>
                    </div>
                    <div class="option-card disabled" data-value="inquiries">
                        <div class="option-icon">❓</div>
                        <div class="option-label">Inquiries</div>
                    </div>
                </div>

                <div class="conditional-field" data-parent="new-merchant">
                    <div class="form-group mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company-name">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Company Base Country</label>
                        <select class="form-control" name="base-country">
                            <option value="">Select country</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Account Holder Name</label>
                        <input type="text" class="form-control" name="account-holder-name">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Account Holder Email</label>
                        <input type="email" class="form-control" name="account-holder-email">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Account Holder Phone</label>
                        <input type="tel" class="form-control" name="account-holder-phone">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Do you operate in other countries?</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="operate-other-countries"
                                value="yes">
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="operate-other-countries"
                                value="no">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                    <div class="conditional-field operating-countries-field" data-parent="operate-other-countries">
                        <div class="form-group mb-3">
                            <label class="form-label">Operating Countries</label>
                            <div class="multi-select-container">
                                <select class="form-control" name="operating-countries" multiple>
                                    <!-- Countries will be populated via JavaScript -->
                                </select>
                                <small class="form-text text-muted mt-2">Hold Ctrl/Cmd to select multiple
                                    countries</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Are you PCI compliant?</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="pci-compliant" value="yes">
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="pci-compliant" value="no">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                    <div class="conditional-field" data-parent="operate-other-countries">
                        <div class="form-group mb-3">
                            <label class="form-label">Operating Countries</label>
                            <select class="form-control" name="operating-countries" multiple>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Company Category -->
            <div class="form-step" data-step="2">
                <h2 class="step-title">Company Category (Segment)</h2>
                <p class="step-subtitle">Choose the type of account(s) you need in Tap Payments</p>

                <div class="options-grid">
                    <div class="option-card" data-value="single-account">
                        <div class="option-icon">🏢</div>
                        <div class="option-label">Single Account</div>
                        <p class="option-description">A single account to handle all payments under one company.
                            Suitable for merchants with a single B2C company.</p>
                    </div>
                    <div class="option-card" data-value="multiple-accounts">
                        <div class="option-icon">🏢🏢</div>
                        <div class="option-label">Multiple Accounts for the Same Corporate</div>
                        <p class="option-description">Multiple accounts at the same level for different operating
                            countries, fields of service, or businesses.</p>
                    </div>
                    <div class="option-card" data-value="master-account">
                        <div class="option-icon">👑</div>
                        <div class="option-label">Master Account with Multiple Accounts Under It</div>
                        <p class="option-description">A master account for platforms/marketplaces/development
                            houses/payment technologies.</p>
                    </div>
                </div>


                <!-- Conditional fields for Single Account -->
                <div class="conditional-field d-none" data-parent="single-account">
                    <input type="hidden" name="merchantSegment" value="Normal Merchant">
                </div>

                <!-- Conditional fields for Multiple Accounts -->
                <div class="conditional-field" data-parent="multiple-accounts">
                    <input type="hidden" name="merchantSegment" value="Normal Merchant with Multiple Accounts">
                    <div class="form-group mb-3">
                        <label class="form-label">Number of accounts with Tap Payments</label>
                        <input type="number" class="form-control" name="number-of-accounts" min="2">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Dashboard preferences</label>
                        <select class="form-control" name="dashboard-preference">
                            <option value="">Select preference</option>
                            <option value="single">Single dashboard</option>
                            <option value="separate">Separate dashboards</option>
                            <option value="both">Both</option>
                        </select>
                    </div>
                </div>

                <!-- Conditional fields for Master Account -->
                <div class="conditional-field" data-parent="master-account">
                    <div class="form-group mb-3">
                        <label class="form-label">Type of business provided to onboarded merchants</label>
                        <div class="form-check mb-2">
                            <input type="radio" class="form-check-input" name="business-type" value="marketplace">
                            <label class="form-check-label">Marketplace - Customers pay you directly, and you settle
                                amounts</label>
                            <input type="hidden" data-for="marketplace" name="merchantSegment" value="Marketplace">
                        </div>
                        <div class="form-check mb-2">
                            <input type="radio" class="form-check-input" name="business-type" value="platform">
                            <label class="form-check-label">Platform - Customers pay businesses directly</label>
                            <input type="hidden" data-for="platform" name="merchantSegment" value="Platform">
                        </div>
                        <div class="form-check mb-2">
                            <input type="radio" class="form-check-input" name="business-type"
                                value="development-house">
                            <label class="form-check-label">Development House - Providing different solutions for
                                businesses</label>
                            <input type="hidden" data-for="development-house" name="merchantSegment"
                                value="Development House">
                        </div>
                        <div class="form-check mb-2">
                            <input type="radio" class="form-check-input" name="business-type"
                                value="psp-managed-tap">
                            <label class="form-check-label">Payment Technology (PSP - Managed by Tap)</label>
                            <input type="hidden" data-for="psp-managed-tap" name="merchantSegment"
                                value="PSP - Payment Technology">
                        </div>
                        <div class="form-check mb-2">
                            <input type="radio" class="form-check-input" name="business-type"
                                value="psp-managed-you">
                            <label class="form-check-label">Payment Technology (PSP - Managed by You)</label>
                            <input type="hidden" data-for="psp-managed-you" name="merchantSegment"
                                value="PSP - Payment Facilitator">
                        </div>
                    </div>

                    <!-- Platform specific fields -->
                    <div class="conditional-field" data-parent="platform">
                        <div class="form-group mb-3">
                            <label class="form-label">Business Type</label>
                            <select class="form-control" name="platform-business-type">
                                <option value="">Select business type</option>
                                <option value="Commerce">Commerce</option>
                                <option value="Retail">Retail</option>
                                <option value="App">App</option>
                                <option value="Billing">Billing</option>
                            </select>
                            <input type="hidden" name="merchantSubSegment" value="">
                        </div>
                    </div>
                </div>


                <div class="prompt-message" id="segmentPrompt"></div>
            </div>

            <!-- Step 3: Acceptance -->
            <div class="form-step" data-step="3">
                <h2 class="step-title">Acceptance</h2>
                <p class="step-subtitle">Configure your payment acceptance settings</p>

                <div class="form-group mb-4">
                    <label class="form-label">Settlement/Payout Currency</label>
                    <select class="form-control" name="settlement-currency">
                        <option value="">Select currency</option>
                        <!-- Currencies will be populated via JavaScript -->
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Pay-in Currencies</label>
                    <select class="form-control" name="payin-currencies" multiple>
                        <!-- Currencies will be populated via JavaScript -->
                    </select>
                    <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple currencies</small>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Payment Methods</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="payment-methods" value="visa">
                        <label class="form-check-label">Visa</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="payment-methods" value="mastercard">
                        <label class="form-check-label">Mastercard</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="payment-methods" value="amex">
                        <label class="form-check-label">Amex</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="payment-methods" value="mada">
                        <label class="form-check-label">Mada</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="payment-methods" value="apple-pay">
                        <label class="form-check-label">Apple Pay</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="payment-methods" value="google-pay">
                        <label class="form-check-label">Google Pay</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="payment-methods" value="stc-pay">
                        <label class="form-check-label">STC Pay</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="payment-methods" value="benefit-pay">
                        <label class="form-check-label">Benefit Pay</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="payment-methods" value="tappy">
                        <label class="form-check-label">Tappy</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="payment-methods" value="fawry">
                        <label class="form-check-label">Fawry</label>
                    </div>
                </div>
            </div>

            <!-- Step 4: Integration -->
            <div class="form-step" data-step="4">
                <h2 class="step-title">Integration</h2>
                <p class="step-subtitle">Configure your integration preferences</p>

                <div class="form-group mb-4">
                    <label class="form-label">Integration Channels</label>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" name="integration-channels" value="web">
                        <label class="form-check-label">Web</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" name="integration-channels" value="app">
                        <label class="form-check-label">App</label>
                    </div>
                </div>
                <!-- <div class="conditional-field" data-parent="web">
                    <div class="form-group mb-3">
                        <label class="form-label">Production Domain</label>
                        <input type="url" class="form-control" name="production-domain" placeholder="https://example.com">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Test Domain</label>
                        <input type="url" class="form-control" name="test-domain" placeholder="https://test.example.com">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Front End Technology</label>
                        <select class="form-control" name="frontend-tech" multiple>
                            <option value="react">React</option>
                            <option value="vue">Vue.js</option>
                            <option value="angular">Angular</option>
                            <option value="vanilla">Vanilla JavaScript</option>
                            <option value="jquery">jQuery</option>
                            <option value="other">Other</option>
                        </select>
                        <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple technologies</small>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Back End Technology</label>
                        <select class="form-control" name="backend-tech" multiple>
                            <option value="node">Node.js</option>
                            <option value="python">Python</option>
                            <option value="php">PHP</option>
                            <option value="java">Java</option>
                            <option value="dotnet">.NET</option>
                            <option value="ruby">Ruby</option>
                            <option value="other">Other</option>
                        </select>
                        <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple technologies</small>
                    </div>
                </div>

                <div class="conditional-field" data-parent="app">
                    <div class="form-group mb-3">
                        <label class="form-label">App Technologies</label>
                        <div class="mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="app-tech" value="ios">
                                <label class="form-check-label">Native iOS</label>
                            </div>
                            <div class="conditional-field bundle-id-field" data-parent="ios">
                                <input type="text" class="form-control mt-2 mb-2" name="ios-bundle-id" placeholder="com.company.app">
                                <button type="button" class="btn btn-sm btn-secondary add-bundle-id" data-for="ios">+ Add another bundle ID</button>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="app-tech" value="android">
                                <label class="form-check-label">Native Android</label>
                            </div>
                            <div class="conditional-field bundle-id-field" data-parent="android">
                                <input type="text" class="form-control mt-2 mb-2" name="android-bundle-id" placeholder="com.company.app">
                                <button type="button" class="btn btn-sm btn-secondary add-bundle-id" data-for="android">+ Add another bundle ID</button>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="app-tech" value="flutter">
                                <label class="form-check-label">Flutter</label>
                            </div>
                            <div class="conditional-field bundle-id-field" data-parent="flutter">
                                <input type="text" class="form-control mt-2 mb-2" name="flutter-bundle-id" placeholder="com.company.app">
                                <button type="button" class="btn btn-sm btn-secondary add-bundle-id" data-for="flutter">+ Add another bundle ID</button>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="app-tech" value="react-native">
                                <label class="form-check-label">React Native</label>
                            </div>
                            <div class="conditional-field bundle-id-field" data-parent="react-native">
                                <input type="text" class="form-control mt-2 mb-2" name="react-native-bundle-id" placeholder="com.company.app">
                                <button type="button" class="btn btn-sm btn-secondary add-bundle-id" data-for="react-native">+ Add another bundle ID</button>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="app-tech" value="ionic">
                                <label class="form-check-label">Ionic</label>
                            </div>
                            <div class="conditional-field bundle-id-field" data-parent="ionic">
                                <input type="text" class="form-control mt-2 mb-2" name="ionic-bundle-id" placeholder="com.company.app">
                                <button type="button" class="btn btn-sm btn-secondary add-bundle-id" data-for="ionic">+ Add another bundle ID</button>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="app-tech" value="cordova">
                                <label class="form-check-label">Cordova</label>
                            </div>
                            <div class="conditional-field bundle-id-field" data-parent="cordova">
                                <input type="text" class="form-control mt-2 mb-2" name="cordova-bundle-id" placeholder="com.company.app">
                                <button type="button" class="btn btn-sm btn-secondary add-bundle-id" data-for="cordova">+ Add another bundle ID</button>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="app-tech" value="webview">
                                <label class="form-check-label">WebView</label>
                            </div>
                            <div class="conditional-field bundle-id-field" data-parent="webview">
                                <input type="text" class="form-control mt-2 mb-2" name="webview-bundle-id" placeholder="com.company.app">
                                <button type="button" class="btn btn-sm btn-secondary add-bundle-id" data-for="webview">+ Add another bundle ID</button>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Web Integration Fields -->
                <div class="conditional-field" data-parent="web">
                    <div class="form-group mb-3">
                        <label class="form-label">Main domain</label>
                        <input type="url" class="form-control" name="main-domain">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Test domain</label>
                        <input type="url" class="form-control" name="test-domain">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Front-end technology</label>
                        <input type="text" class="form-control" name="frontend-tech">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Back-end technology</label>
                        <input type="text" class="form-control" name="backend-tech">
                    </div>
                </div>

                <!-- App Integration Fields -->
                <!-- <div class="conditional-field" data-parent="app">
                    <div class="form-group mb-3">
                        <label class="form-label">App Technology</label>
                        <select class="form-control" name="app-technology">
                            <option value="">Select technology</option>
                            <option value="ios">iOS</option>
                            <option value="android">Android</option>
                            <option value="flutter">Flutter</option>
                            <option value="react-native">React Native</option>
                            <option value="web-view">Web View</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Bundle ID</label>
                        <input type="text" class="form-control" name="bundle-id">
                        <small class="form-text text-muted">Required for iOS/Android/Flutter/React Native</small>
                    </div>
                </div> -->
                <div class="conditional-field" data-parent="app">
                    <div class="form-group mb-3">
                        <label class="form-label">App Technologies</label>
                        <select class="form-control" name="app-technologies" multiple>
                            <option value="ios">Native iOS</option>
                            <option value="android">Native Android</option>
                            <option value="flutter">Flutter</option>
                            <option value="react-native">React Native</option>
                            <option value="ionic">Ionic</option>
                            <option value="cordova">Cordova</option>
                            <option value="web-view">Web View</option>
                        </select>
                        <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple technologies</small>
                    </div>

                    <!-- Container for dynamic bundle ID fields -->
                    <div id="bundleIdContainer" class="mt-4"></div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Integration Flow</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="integration-flow"
                            value="direct-capture">
                        <label class="form-check-label">Direct Capture</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="integration-flow"
                            value="authorize-capture">
                        <label class="form-check-label">Authorize/Hold and Capture Later</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="integration-flow" value="save-card">
                        <label class="form-check-label">Save Card Details for Subscription Payments</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="integration-flow" value="api-refund">
                        <label class="form-check-label">API Refund</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="integration-flow"
                            value="dashboard-refund">
                        <label class="form-check-label">Dashboard Refund</label>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Features</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="features" value="save-card">
                        <label class="form-check-label">Save Card</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="features" value="issuer-details">
                        <label class="form-check-label">Receive Issuer Bank Details</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="features" value="payment-descriptor">
                        <label class="form-check-label">Dynamic Payment Descriptor</label>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Additional Dates</label>
                    <div class="mb-3">
                        <label class="form-label">Go Live Date</label>
                        <input type="date" class="form-control" name="go-live-date">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Integration Review Meeting Date</label>
                        <input type="date" class="form-control" name="review-meeting-date">
                    </div>
                </div>
            </div>

            <!-- Step 5: Reporting & Dashboards -->
            <div class="form-step" data-step="5" id="report-dashboard">
                <h2 class="step-title">Reporting & Dashboards</h2>
                <p class="step-subtitle">Choose your reporting preferences</p>

                <div class="form-group mb-4">
                    <label class="form-label">Choose the Channels for Report Generation</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="report-channels" value="api">
                        <label class="form-check-label">API</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="report-channels" value="dashboard">
                        <label class="form-check-label">Dashboard</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="report-channels" value="none">
                        <label class="form-check-label">None</label>
                    </div>
                </div>
            </div>

            <!-- Completion Summary Section -->
            <!-- <div class="congratulations">
                <h3>🎉 Congratulations!</h3>
                <p>You have completed your integration scoping.</p>
            </div> -->

            <div class="congratulations">
                <h3>🎉 Congratulations!</h3>
                <p>You have completed your integration scoping.</p>
                <div id="emailNotification" class="mt-4">
                    <p>A copy of these details will be sent to your email: <strong id="primaryEmail"></strong></p>
                    <div class="form-group mt-3">
                        <label>Would you like to add additional email recipients? (CC)</label>
                        <div class="cc-email-container">
                            <div class="input-group mb-2">
                                <input type="email" class="form-control cc-email"
                                    placeholder="Enter email address">
                                <button type="button" class="btn btn-secondary add-cc-email">Add Another</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table summary-table">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody id="summaryTableBody">
                </tbody>
            </table>

            <div class="export-buttons">
                <button type="button" class="btn btn-secondary" onclick="exportToCSV()">Export to CSV</button>
                <button type="button" class="btn btn-secondary" onclick="exportToPDF()">Export to PDF</button>
                <button type="button" class="btn btn-primary" onclick="submitForm()">Submit Scope Details</button>
            </div>
        </form>

        <div class="navigation">
            <button class="btn btn-secondary" id="prevBtn" style="visibility: hidden">Previous</button>
            <button class="btn btn-primary" id="nextBtn">Next step</button>
        </div>
    </div>

    <script>
        // Form data storage
        const formData = {};
        let currentStep = 0;

        // Initialize form on load
        document.addEventListener('DOMContentLoaded', function() {
            initializeForm();
            populateCountries();
            initializeIntegrationChannels();
            removeRequiredAttributes();
            populateCurrencies();
        });

        function initializeForm() {
            const form = document.getElementById('multiStepForm');
            const steps = form.querySelectorAll('.form-step');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const stepDots = document.querySelectorAll('.step-dot');

            initializeOptionCards();
            initializeFormInputs();
            initializeCheckboxGroups();
            initializeConditionalFields();

            // Initialize navigation
            prevBtn.addEventListener('click', () => updateStep(-1));
            nextBtn.addEventListener('click', () => updateStep(1));
        }

        function populateCountries() {
            const countries = [
                "United Arab Emirates", "Saudi Arabia", "Kuwait", "Bahrain",
                "Qatar", "Oman", "Egypt", "Jordan", "Lebanon", "Iraq",
                // Add more countries as needed
            ];

            const baseCountrySelect = document.querySelector('select[name="base-country"]');
            const operatingCountriesSelect = document.querySelector('select[name="operating-countries"]');

            countries.forEach(country => {
                baseCountrySelect.add(new Option(country, country));
                operatingCountriesSelect.add(new Option(country, country));
            });
        }

        function populateCurrencies() {
            const currencies = [{
                    code: "AED",
                    name: "UAE Dirham"
                },
                {
                    code: "SAR",
                    name: "Saudi Riyal"
                },
                {
                    code: "KWD",
                    name: "Kuwaiti Dinar"
                },
                {
                    code: "BHD",
                    name: "Bahraini Dinar"
                },
                {
                    code: "QAR",
                    name: "Qatari Riyal"
                },
                {
                    code: "OMR",
                    name: "Omani Rial"
                },
                {
                    code: "EGP",
                    name: "Egyptian Pound"
                },
                {
                    code: "USD",
                    name: "US Dollar"
                },
                // Add more currencies as needed
            ];

            const settlementCurrencySelect = document.querySelector('select[name="settlement-currency"]');
            const payinCurrenciesSelect = document.querySelector('select[name="payin-currencies"]');

            currencies.forEach(currency => {
                const option = new Option(`${currency.code} - ${currency.name}`, currency.code);
                settlementCurrencySelect.add(option.cloneNode(true));
                payinCurrenciesSelect.add(option.cloneNode(true));
            });
        }

        function initializeOptionCards() {
            document.querySelectorAll('.option-card:not(.disabled)').forEach(card => {
                card.addEventListener('click', function() {
                    handleOptionCardClick(this);
                });
            });
        }

        function handleOptionCardClick(card) {
            const parent = card.closest('.form-step');

            // Handle card selection
            parent.querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');

            // Store the selected value
            const stepNumber = parent.dataset.step;
            formData[`step${stepNumber}_selection`] = card.dataset.value;

            // Handle conditional fields
            const selectedValue = card.dataset.value;
            parent.querySelectorAll('.conditional-field').forEach(field => {
                if (field.dataset.parent === selectedValue) {
                    field.classList.add('show');
                    field.querySelectorAll('input, select, textarea').forEach(input => {
                        input.required = true;
                    });
                } else {
                    field.classList.remove('show');
                    field.querySelectorAll('input, select, textarea').forEach(input => {
                        input.required = false;
                    });
                }
            });

            // Handle segment prompts for step 2
            if (stepNumber === '2') {
                const promptMessage = document.getElementById('segmentPrompt');
                promptMessage.classList.add('show');

                let segmentText = '';
                switch (selectedValue) {
                    case 'single-account':
                        segmentText = 'Normal Merchant';
                        break;
                    case 'multiple-accounts':
                        segmentText = 'Normal Merchant with Multiple Accounts';
                        break;
                    case 'master-account':
                        segmentText = 'Master Account';
                        break;
                }

                promptMessage.innerHTML =
                    `<strong>Congratulations!</strong> Your segment has been identified as '${segmentText}'.`;
            }
        }

        function initializeFormInputs() {
            document.querySelectorAll('input[name="operate-other-countries"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    handleOperatingCountriesChange(this);
                });
            });

            document.querySelectorAll('input, select, textarea').forEach(input => {
                input.addEventListener('change', function() {
                    handleInputChange(this);
                });
            });
        }

        function handleInputChange(input) {
            const name = input.name;
            let value;

            if (input.type === 'checkbox') {
                const checkboxes = document.querySelectorAll(`input[name="${name}"]`);
                value = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);
            } else if (input.type === 'radio') {
                value = input.checked ? input.value : formData[name];
            } else if (input.type === 'select-multiple') {
                value = Array.from(input.selectedOptions).map(opt => opt.value);
            } else {
                value = input.value;
            }

            if (value) {
                formData[name] = value;
                updateAccountHeader();
            }

            // Handle special cases
            handleSpecialInputCases(input);
        }

        function handleSpecialInputCases(input) {
            // Handle business type selection for platform
            if (input.name === 'business-type' && input.value === 'platform') {
                const platformFields = document.querySelector('.conditional-field[data-parent="platform"]');
                platformFields.classList.add('show');
                platformFields.querySelectorAll('input, select').forEach(field => field.required = true);
            }

            // Handle integration channels
            if (input.name === 'integration-channels') {
                const channelFields = document.querySelector(`.conditional-field[data-parent="${input.value}"]`);
                if (channelFields) {
                    channelFields.classList.toggle('show', input.checked);
                    channelFields.querySelectorAll('input, select').forEach(field => {
                        field.required = input.checked;
                    });
                }
            }

            // Handle platform business type selection
            if (input.name === 'platform-business-type') {
                const merchantSubSegment = document.querySelector('input[name="merchantSubSegment"]');
                if (merchantSubSegment) {
                    merchantSubSegment.value = input.value;
                }
            }
        }

        function initializeCheckboxGroups() {
            // Handle mutually exclusive checkboxes
            document.querySelectorAll('input[name="report-channels"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.value === 'none' && this.checked) {
                        document.querySelectorAll('input[name="report-channels"]').forEach(cb => {
                            if (cb !== this) cb.checked = false;
                        });
                    } else if (this.checked) {
                        const noneOption = document.querySelector(
                            'input[name="report-channels"][value="none"]');
                        if (noneOption) noneOption.checked = false;
                    }
                });
            });
        }

        function initializeConditionalFields() {
            document.querySelectorAll('.conditional-field').forEach(field => {
                const parentValue = field.dataset.parent;
                if (parentValue) {
                    const parentInput = document.querySelector(`input[value="${parentValue}"]`);
                    if (parentInput) {
                        field.style.display = parentInput.checked ? 'block' : 'none';
                    }
                }
            });
        }

        function updateAccountHeader() {
            const accountHeader = document.querySelector('.account-header');
            const accountSummary = document.getElementById('accountSummary');

            if (currentStep > 0 && formData['company-name']) {
                accountHeader.classList.add('show');
                accountSummary.innerHTML = `
                    <p><strong>Company:</strong> ${formData['company-name']}</p>
                    <p><strong>Account Holder:</strong> ${formData['account-holder-name'] || ''}</p>
                    <p><strong>Email:</strong> ${formData['account-holder-email'] || ''}</p>
                `;
            }
        }

        // function validateCurrentStep() {
        //     const currentStepElement = document.querySelector(`.form-step[data-step="${currentStep + 1}"]`);

        //     // For step 1, check if a service is selected
        //     if (currentStep === 0) {
        //         const selectedCard = currentStepElement.querySelector('.option-card.selected');
        //         if (!selectedCard) {
        //             alert('Please select a service option');
        //             return false;
        //         }
        //     }

        //     // For other steps, check all required fields
        //     const requiredInputs = currentStepElement.querySelectorAll('input[required], select[required], textarea[required]');
        //     const isValid = Array.from(requiredInputs).every(input => {
        //         if (input.type === 'checkbox' || input.type === 'radio') {
        //             const name = input.name;
        //             const checked = currentStepElement.querySelector(`input[name="${name}"]:checked`);
        //             if (!checked) {
        //                 input.classList.add('is-invalid');
        //                 return false;
        //             }
        //         } else if (!input.value.trim()) {
        //             input.classList.add('is-invalid');
        //             return false;
        //         }
        //         input.classList.remove('is-invalid');
        //         return true;
        //     });

        //     if (!isValid) {
        //         alert('Please fill in all required fields');
        //         return false;
        //     }

        //     return true;
        // }

        function validateCurrentStep() {
            // Only validate step 1
            if (currentStep === 0) {
                const currentStepElement = document.querySelector(`.form-step[data-step="${currentStep + 1}"]`);
                const selectedCard = currentStepElement.querySelector('.option-card.selected');

                if (!selectedCard) {
                    alert('Please select a service option');
                    return false;
                }

                // Validate required fields for step 1 only if a card is selected
                const selectedValue = selectedCard.dataset.value;
                const conditionalField = currentStepElement.querySelector(
                    `.conditional-field[data-parent="${selectedValue}"]`);

                if (conditionalField) {
                    const requiredInputs = conditionalField.querySelectorAll(
                        'input[required], select[required], textarea[required]');
                    const isValid = Array.from(requiredInputs).every(input => {
                        if (input.type === 'checkbox' || input.type === 'radio') {
                            const name = input.name;
                            const checked = currentStepElement.querySelector(`input[name="${name}"]:checked`);
                            if (!checked) {
                                input.classList.add('is-invalid');
                                return false;
                            }
                        } else if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            return false;
                        }
                        input.classList.remove('is-invalid');
                        return true;
                    });

                    if (!isValid) {
                        alert('Please fill in all required fields');
                        return false;
                    }
                }
            }

            return true;
        }

        function formatFieldName(key) {
            if (key === 'bundle-ids') return 'Bundle IDs';
            return key
                .split('-')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        }

        // Add a new helper function to format bundle IDs
        function formatBundleIds(bundleIds) {
            return Object.entries(bundleIds)
                .map(([tech, ids]) => {
                    const techLabel = getTechnologyLabel(tech);
                    return `${techLabel}: ${ids.join(', ')}`;
                })
                .join('\n');
        }
        // Additional helper functions
        function validateDate(dateString) {
            const date = new Date(dateString);
            return date instanceof Date && !isNaN(date);
        }

        function initializeIntegrationChannels() {
            document.querySelector('select[name="app-technologies"]')?.addEventListener('change',
            handleAppTechnologyChange);

            // Handle integration channel checkboxes
            document.querySelectorAll('input[name="integration-channels"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    handleIntegrationChannelChange(this);
                });
            });

            // Handle app technology checkboxes
            document.querySelectorAll('input[name="app-tech"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    handleAppTechnologyChange(this);
                });
            });

            // Handle add bundle ID buttons
            document.querySelectorAll('.add-bundle-id').forEach(button => {
                button.addEventListener('click', function() {
                    addBundleIdField(this.dataset.for);
                });
            });
        }

        function handleIntegrationChannelChange(checkbox) {
            console.log("channelFields", checkbox.value);
            const channelFields = document.querySelector(`.conditional-field[data-parent="${checkbox.value}"]`);
            console.log("channelFields", channelFields);
            if (channelFields) {
                if (checkbox.checked) {
                    channelFields.classList.add('show');
                    channelFields.style.display = 'block';
                    channelFields.querySelectorAll('input, select').forEach(field => {
                        if (!field.hasAttribute('data-optional')) {
                            field.required = true;
                        }
                    });
                } else {
                    channelFields.classList.remove('show')
                    channelFields.style.display = 'none';;
                    channelFields.querySelectorAll('input, select').forEach(field => {
                        field.required = false;
                        // Clear values when unchecked
                        if (field.type === 'text' || field.type === 'url') {
                            field.value = '';
                        } else if (field.type === 'select-multiple') {
                            field.selectedIndex = -1;
                        }
                    });
                }
            }
        }

        function handleAppTechnologyChange(checkbox) {
            const bundleIdField = document.querySelector(`.bundle-id-field[data-parent="${checkbox.value}"]`);
            if (bundleIdField) {
                if (checkbox.checked) {
                    bundleIdField.classList.add('show');
                    bundleIdField.querySelectorAll('input[type="text"]').forEach(input => {
                        input.required = true;
                    });
                } else {
                    bundleIdField.classList.remove('show');
                    bundleIdField.querySelectorAll('input[type="text"]').forEach(input => {
                        input.required = false;
                        input.value = '';
                    });
                    // Remove any additional bundle ID fields
                    const additionalFields = bundleIdField.querySelectorAll('.additional-bundle-id');
                    additionalFields.forEach(field => field.remove());
                }
            }
        }

        function addBundleIdField(technology) {
            const bundleIdField = document.querySelector(`.bundle-id-field[data-parent="${technology}"]`);
            if (bundleIdField) {
                const newFieldContainer = document.createElement('div');
                newFieldContainer.className = 'additional-bundle-id mt-2';

                const newInput = document.createElement('input');
                newInput.type = 'text';
                newInput.className = 'form-control mb-2';
                newInput.name = `${technology}-bundle-id`;
                newInput.placeholder = 'com.company.app';
                newInput.required = true;

                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-sm btn-danger mb-2';
                removeButton.textContent = 'Remove';
                removeButton.onclick = function() {
                    newFieldContainer.remove();
                };

                newFieldContainer.appendChild(newInput);
                newFieldContainer.appendChild(removeButton);

                // Insert before the "Add another" button
                const addButton = bundleIdField.querySelector('.add-bundle-id');
                bundleIdField.insertBefore(newFieldContainer, addButton);
            }
        }

        function collectBundleIds() {
            const bundleIds = {};
            document.querySelectorAll('.bundle-id-field').forEach(field => {
                const technology = field.dataset.parent;
                const inputs = field.querySelectorAll('input[type="text"]');
                if (inputs.length > 0) {
                    bundleIds[technology] = Array.from(inputs)
                        .map(input => input.value)
                        .filter(value => value.trim() !== '');
                }
            });
            return bundleIds;
        }

        function handleAppTechnologyChange(select) {
            const bundleIdField = select.closest('.conditional-field').querySelector('input[name="bundle-id"]');
            if (bundleIdField) {
                const requiresBundleId = ['ios', 'android', 'flutter', 'react-native'].includes(select.value);
                bundleIdField.required = requiresBundleId;
                bundleIdField.classList.toggle('d-none', !requiresBundleId);
            }
        }

        // Initialize additional event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Handle integration channel changes
            document.querySelectorAll('input[name="integration-channels"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    handleIntegrationChannelChange(this);
                });
            });

            // Handle app technology changes
            const appTechSelect = document.querySelector('select[name="app-technology"]');
            if (appTechSelect) {
                appTechSelect.addEventListener('change', function() {
                    handleAppTechnologyChange(this);
                });
            }

            // Initialize date validation
            const dateInputs = document.querySelectorAll('input[type="date"]');
            dateInputs.forEach(input => {
                input.addEventListener('change', function() {
                    validateDateInputs();
                });
            });
        });

        function validateDateInputs() {
            const goLiveDate = document.querySelector('input[name="go-live-date"]');
            const reviewDate = document.querySelector('input[name="review-meeting-date"]');

            if (goLiveDate.value && reviewDate.value) {
                const goLive = new Date(goLiveDate.value);
                const review = new Date(reviewDate.value);

                // if (review >= goLive) {
                //     alert('Review meeting date should be before the go-live date');
                //     reviewDate.value = '';
                // }
            }
        }

        function updateStep(direction) {
            if (direction === 1 && !validateCurrentStep()) {
                return;
            }

            const steps = document.querySelectorAll('.form-step');
            const stepDots = document.querySelectorAll('.step-dot');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            const newStep = currentStep + direction;

            if (newStep >= 0 && newStep < steps.length) {
                steps[currentStep].classList.remove('active');
                steps[newStep].classList.add('active');
                stepDots[currentStep].classList.remove('active');
                stepDots[newStep].classList.add('active');
                currentStep = newStep;

                // Update navigation buttons
                prevBtn.style.visibility = currentStep === 0 ? 'hidden' : 'visible';
                nextBtn.textContent = currentStep === steps.length - 1 ? 'Finish' : 'Next step';
                // Update account header visibility
                updateAccountHeader();
            } else if (newStep === steps.length) {
                showCompletionSummary();
            }
        }

        function removeRequiredAttributes() {
            const steps = document.querySelectorAll('.form-step');
            steps.forEach((step, index) => {
                if (index > 0) { // Skip step 1
                    const inputs = step.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        input.removeAttribute('required');
                    });
                }
            });
        }

        function formatFieldName(key) {
            return key
                .split('-')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        }

        function handleOperatingCountriesChange(radio) {
            const operatingCountriesField = document.querySelector('.operating-countries-field');
            if (!operatingCountriesField) return;

            if (radio.value === 'yes' && radio.checked) {
                operatingCountriesField.classList.remove('d-none');
            } else {
                operatingCountriesField.classList.add('d-none');
            }
        }

        function showCompletionSummary() {
            // Show congratulations message
            document.querySelector('.congratulations').classList.add('show');
            document.querySelector('#report-dashboard').style.display = 'none';

            // Populate and show summary table
            const summaryTableBody = document.getElementById('summaryTableBody');
            summaryTableBody.innerHTML = '';

            // Add regular form data
            for (const [key, value] of Object.entries(formData)) {
                const row = document.createElement('tr');

                // Special handling for app technologies and bundle IDs
                if (key === 'app-technologies' && appTechBundleIds && Object.keys(appTechBundleIds).length > 0) {
                    let bundleIdContent = '';
                    Object.entries(appTechBundleIds).forEach(([tech, ids]) => {
                        if (ids.length > 0 && ids[0]) { // Only show if there are valid IDs
                            bundleIdContent += `${getTechnologyLabel(tech)}:\n`;
                            ids.forEach(id => {
                                if (id) bundleIdContent += `  - ${id}\n`;
                            });
                        }
                    });

                    if (bundleIdContent) {
                        row.innerHTML = `
                            <td>App Technologies and Bundle IDs</td>
                            <td><pre class="bundle-id-summary">${bundleIdContent}</pre></td>
                        `;
                    } else {
                        row.innerHTML = `
                            <td>App Technologies</td>
                            <td>${Array.isArray(value) ? value.join(', ') : value}</td>
                        `;
                    }
                } else if (key !== 'bundle-ids') { // Skip separate bundle-ids entry
                    row.innerHTML = `
                        <td>${formatFieldName(key)}</td>
                        <td>${Array.isArray(value) ? value.join(', ') : value}</td>
                    `;
                }

                summaryTableBody.appendChild(row);
            }

            document.querySelector('.summary-table').classList.add('show');
            document.querySelector('.export-buttons').classList.add('show');
            document.querySelector('.navigation').style.display = 'none';
            document.querySelector('.congratulations').classList.add('show');
            document.querySelector('#report-dashboard').style.display = 'none';

            // Set primary email
            const primaryEmail = formData['account-holder-email'];
            document.getElementById('primaryEmail').textContent = primaryEmail || 'Not provided';

            // Initialize CC email functionality
            initializeCCEmails();
        }

        function initializeCCEmails() {
            const addButton = document.querySelector('.add-cc-email');
            if (addButton) {
                addButton.addEventListener('click', addCCEmailField);
            }
        }

        function addCCEmailField() {
            const container = document.querySelector('.cc-email-container');
            const newGroup = document.createElement('div');
            newGroup.className = 'input-group mb-2';

            newGroup.innerHTML = `
                <input type="email" class="form-control cc-email" placeholder="Enter email address">
                <button type="button" class="btn btn-danger remove-cc-email">Remove</button>
            `;

            container.appendChild(newGroup);

            // Add remove button functionality
            newGroup.querySelector('.remove-cc-email').addEventListener('click', function() {
                newGroup.remove();
            });
        }


        function exportToCSV() {
            const rows = [
                ['Field', 'Value']
            ];

            // Add regular form data
            for (const [key, value] of Object.entries(formData)) {
                if (key === 'app-technologies' && appTechBundleIds && Object.keys(appTechBundleIds).length > 0) {
                    // Add app technologies with their bundle IDs
                    Object.entries(appTechBundleIds).forEach(([tech, ids]) => {
                        if (ids.length > 0 && ids[0]) {
                            rows.push([`${getTechnologyLabel(tech)} Bundle IDs`, ids.join('; ')]);
                        }
                    });
                } else if (key !== 'bundle-ids') {
                    rows.push([
                        formatFieldName(key),
                        Array.isArray(value) ? value.join('; ') : value
                    ]);
                }
            }

            const csvContent = rows
                .map(row => row.map(cell => `"${String(cell).replace(/"/g, '""')}"`).join(','))
                .join('\n');

            const blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'merchant_onboarding.csv';
            link.click();
        }

        function exportToPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Add title
            doc.setFontSize(16);
            doc.text('Merchant Onboarding Summary', 20, 20);

            // Add content
            doc.setFontSize(12);
            let yPosition = 40;

            // Add regular form data
            for (const [key, value] of Object.entries(formData)) {
                if (key === 'app-technologies' && appTechBundleIds && Object.keys(appTechBundleIds).length > 0) {
                    // Add app technologies with their bundle IDs
                    doc.text('App Technologies and Bundle IDs:', 20, yPosition);
                    yPosition += 10;

                    Object.entries(appTechBundleIds).forEach(([tech, ids]) => {
                        if (ids.length > 0 && ids[0]) {
                            const techLabel = getTechnologyLabel(tech);
                            doc.text(`${techLabel}:`, 25, yPosition);
                            yPosition += 7;

                            ids.forEach(id => {
                                if (id) {
                                    doc.text(`- ${id}`, 30, yPosition);
                                    yPosition += 7;
                                }
                            });
                        }
                    });
                } else if (key !== 'bundle-ids') {
                    const text = `${formatFieldName(key)}: ${Array.isArray(value) ? value.join(', ') : value}`;
                    const textLines = doc.splitTextToSize(text, 170);

                    // Check if we need a new page
                    if (yPosition + (textLines.length * 7) > 280) {
                        doc.addPage();
                        yPosition = 20;
                    }

                    doc.text(textLines, 20, yPosition);
                    yPosition += (textLines.length * 7) + 3;
                }
            }

            doc.save('merchant_onboarding.pdf');
        }

        function handleOperatingCountriesChange(radio) {
            const operatingCountriesField = document.querySelector('.operating-countries-field');
            if (operatingCountriesField) {
                if (radio.value === 'yes' && radio.checked) {
                    operatingCountriesField.classList.remove('d-none');
                    operatingCountriesField.style.display = 'block';
                    const select = operatingCountriesField.querySelector('select');
                    if (select) {
                        select.required = true;
                    }
                } else {
                    operatingCountriesField.classList.add('d-none');
                    operatingCountriesField.style.display = 'none';
                    const select = operatingCountriesField.querySelector('select');
                    if (select) {
                        select.required = false;
                    }
                }
            }
        }

        function handlePlatformBusinessTypeChange(select) {
            const merchantSubSegment = document.querySelector('input[name="merchantSubSegment"]');
            if (merchantSubSegment) {
                merchantSubSegment.value = select.value;
            }

            // Show congratulations message with platform and subcategory
            const promptMessage = document.getElementById('segmentPrompt');
            promptMessage.classList.add('show');
            promptMessage.innerHTML =
                `<strong>Congratulations!</strong> Your segment has been identified as 'Platform - ${select.value}'.`;
        }

        function handleSpecialInputCases(input) {
            // Handle business type selection for platform
            if (input.name === 'business-type' && input.value === 'platform') {
                const platformFields = document.querySelector('.conditional-field[data-parent="platform"]');
                if (platformFields) {
                    platformFields.classList.add('show');
                    platformFields.querySelectorAll('input, select').forEach(field => {
                        field.required = true;
                    });

                    // Add change event listener to platform business type dropdown
                    const businessTypeSelect = platformFields.querySelector('select[name="platform-business-type"]');
                    if (businessTypeSelect) {
                        businessTypeSelect.addEventListener('change', function() {
                            handlePlatformBusinessTypeChange(this);
                        });
                    }
                }
            }

            // Other special cases remain the same...
        }

        function handleBusinessTypeChange(event) {
            const businessType = event.target.value;
            const promptMessage = document.getElementById('segmentPrompt');
            const mainOption = 'Master Account with Multiple Accounts Under It';
            let subOption = '';

            const platformFields = document.querySelector('.conditional-field[data-parent="platform"]');
            platformFields.style.display = 'none';

            switch (businessType) {
                case 'marketplace':
                    subOption = 'Marketplace';
                    promptMessage.classList.add('show');
                    showSegmentMessage(promptMessage, mainOption, subOption);
                    break;
                case 'platform':
                    // Don't show message yet - wait for subcategory selection
                    promptMessage.classList.remove('show');
                    // Show platform fields
                    const platformFields = document.querySelector('.conditional-field[data-parent="platform"]');
                    platformFields.classList.add('show');
                    platformFields.style.display = 'block';
                    console.log("platform-business-type", platformFields);
                    if (platformFields) {
                        platformFields.classList.add('show');
                        const businessTypeSelect = platformFields.querySelector('select[name="platform-business-type"]');
                        console.log("businessTypeSelect", businessTypeSelect);
                        businessTypeSelect.style.display = 'block';
                        if (businessTypeSelect) {
                            businessTypeSelect.required = true;
                            // Add change event listener if not already added
                            businessTypeSelect.removeEventListener('change', handlePlatformSubcategoryChange);
                            businessTypeSelect.addEventListener('change', handlePlatformSubcategoryChange);
                        }
                    }
                    break;
                case 'development-house':
                    subOption = 'Development House';
                    promptMessage.classList.add('show');
                    showSegmentMessage(promptMessage, mainOption, subOption);
                    break;
                case 'psp-managed-tap':
                    subOption = 'Payment Technology (PSP - Managed by Tap)';
                    promptMessage.classList.add('show');
                    showSegmentMessage(promptMessage, mainOption, subOption);
                    break;
                case 'psp-managed-you':
                    subOption = 'Payment Technology (PSP - Managed by You)';
                    promptMessage.classList.add('show');
                    showSegmentMessage(promptMessage, mainOption, subOption);
                    break;
            }
        }

        function handlePlatformSubcategoryChange(event) {
            const subcategory = event.target.value;
            const promptMessage = document.getElementById('segmentPrompt');
            const mainOption = 'Master Account with Multiple Accounts Under It';

            // Update merchant sub-segment if needed
            const merchantSubSegment = document.querySelector('input[name="merchantSubSegment"]');
            if (merchantSubSegment) {
                merchantSubSegment.value = subcategory;
            }

            // Show message with both platform and subcategory
            const subOption = `Platform - ${subcategory}`;
            promptMessage.classList.add('show');
            showSegmentMessage(promptMessage, mainOption, subOption);
        }

        function handleOptionCardClick(card) {
            const parent = card.closest('.form-step');

            // Handle card selection
            parent.querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');

            // Store the selected value
            const stepNumber = parent.dataset.step;
            formData[`step${stepNumber}_selection`] = card.dataset.value;

            // Handle conditional fields
            const selectedValue = card.dataset.value;
            parent.querySelectorAll('.conditional-field').forEach(field => {
                if (field.dataset.parent === selectedValue) {
                    field.classList.add('show');
                    field.querySelectorAll('input, select, textarea').forEach(input => {
                        input.required = true;
                    });
                } else {
                    field.classList.remove('show');
                    field.querySelectorAll('input, select, textarea').forEach(input => {
                        input.required = false;
                    });
                }
            });

            // Handle segment prompts for step 2
            if (stepNumber === '2') {
                const promptMessage = document.getElementById('segmentPrompt');
                promptMessage.classList.add('show');

                let mainOption = '';
                let subOption = '';

                switch (selectedValue) {
                    case 'single-account':
                        mainOption = 'Single Account';
                        subOption = 'Normal Merchant';
                        showSegmentMessage(promptMessage, mainOption, subOption);
                        break;
                    case 'multiple-accounts':
                        mainOption = 'Multiple Accounts for the Same Corporate';
                        subOption = 'Normal Merchant with Multiple Accounts';
                        showSegmentMessage(promptMessage, mainOption, subOption);
                        break;
                    case 'master-account':
                        // Don't show message yet - wait for business type selection
                        promptMessage.classList.remove('show');
                        // Add event listeners to business type radio buttons
                        const businessTypeRadios = document.querySelectorAll('input[name="business-type"]');
                        businessTypeRadios.forEach(radio => {
                            radio.addEventListener('change', handleBusinessTypeChange);
                        });
                        break;
                }
            }
        }

        function showSegmentMessage(promptElement, mainOption, subOption) {
            promptElement.innerHTML = `
                <strong>Congratulations!</strong><br>
                Main Selection: ${mainOption}<br>
                Category: ${subOption}
            `;
        }

        let appTechBundleIds = {};

        function handleAppTechnologyChange(event) {
            const selectedTechnologies = Array.from(event.target.selectedOptions, option => option.value);
            const container = document.getElementById('bundleIdContainer');
            container.innerHTML = ''; // Clear existing fields

            // Initialize or update bundle IDs object
            const updatedBundleIds = {};
            selectedTechnologies.forEach(tech => {
                updatedBundleIds[tech] = appTechBundleIds[tech] || [''];
            });
            appTechBundleIds = updatedBundleIds;

            // Create fields for each selected technology
            selectedTechnologies.forEach(tech => {
                const techSection = createTechnologySection(tech);
                container.appendChild(techSection);
            });
        }

        function createTechnologySection(technology) {
            const section = document.createElement('div');
            section.className = 'mb-4 p-4 bg-light rounded border';

            const title = document.createElement('h6');
            title.className = 'mb-3';
            title.textContent = getTechnologyLabel(technology) + ' Bundle IDs';
            section.appendChild(title);

            const bundleIdsContainer = document.createElement('div');
            bundleIdsContainer.className = 'bundle-ids-container';
            bundleIdsContainer.dataset.technology = technology;

            // Create initial bundle ID fields
            appTechBundleIds[technology].forEach((bundleId, index) => {
                const fieldGroup = createBundleIdField(technology, index, bundleId);
                bundleIdsContainer.appendChild(fieldGroup);
            });

            section.appendChild(bundleIdsContainer);

            // Add button
            const addButton = document.createElement('button');
            addButton.type = 'button';
            addButton.className = 'btn btn-sm btn-secondary mt-2';
            addButton.textContent = '+ Add another bundle ID';
            addButton.onclick = () => addBundleIdField(technology);
            section.appendChild(addButton);

            return section;
        }

        function createBundleIdField(technology, index, value = '') {
            const fieldGroup = document.createElement('div');
            fieldGroup.className = 'bundle-id-field d-flex gap-2 mb-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control';
            input.name = `bundle-ids[${technology}][]`;
            input.placeholder = 'com.company.app';
            input.value = value;
            input.onchange = (e) => updateBundleId(technology, index, e.target.value);

            fieldGroup.appendChild(input);

            // Only add remove button if there's more than one field
            if (appTechBundleIds[technology].length > 1) {
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-sm btn-danger';
                removeButton.textContent = 'Remove';
                removeButton.onclick = () => removeBundleIdField(technology, index);
                fieldGroup.appendChild(removeButton);
            }

            return fieldGroup;
        }

        function addBundleIdField(technology) {
            appTechBundleIds[technology].push('');
            const container = document.querySelector(`.bundle-ids-container[data-technology="${technology}"]`);
            container.innerHTML = ''; // Clear and rebuild all fields

            appTechBundleIds[technology].forEach((bundleId, index) => {
                const fieldGroup = createBundleIdField(technology, index, bundleId);
                container.appendChild(fieldGroup);
            });
        }

        function removeBundleIdField(technology, index) {
            appTechBundleIds[technology].splice(index, 1);
            const container = document.querySelector(`.bundle-ids-container[data-technology="${technology}"]`);
            container.innerHTML = ''; // Clear and rebuild all fields

            appTechBundleIds[technology].forEach((bundleId, idx) => {
                const fieldGroup = createBundleIdField(technology, idx, bundleId);
                container.appendChild(fieldGroup);
            });
        }

        function updateBundleId(technology, index, value) {
            appTechBundleIds[technology][index] = value;
        }

        function getTechnologyLabel(technology) {
            const labels = {
                'ios': 'Native iOS',
                'android': 'Native Android',
                'flutter': 'Flutter',
                'react-native': 'React Native',
                'ionic': 'Ionic',
                'cordova': 'Cordova',
                'web-view': 'Web View'
            };
            return labels[technology] || technology;
        }

        // function submitForm() {
        //     try {
        //         // Generate CSV data
        //         const csvData = generateCSVData();
        //         const csvBlob = new Blob([csvData], { type: 'text/csv;charset=utf-8' });
        //         const csvFile = new File([csvBlob], 'merchant_onboarding.csv', {
        //             type: 'text/csv;charset=utf-8'
        //         });

        //         // Generate PDF data
        //         const pdfBlob = generatePDFData();
        //         const pdfFile = new File([pdfBlob], 'merchant_onboarding.pdf', {
        //             type: 'application/pdf'
        //         });

        //         // Create FormData object
        //         const formDataToSubmit = new FormData();

        //         // Collect CC emails
        //         const ccEmails = Array.from(document.querySelectorAll('.cc-email'))
        //             .map(input => input.value.trim())
        //             .filter(email => email && isValidEmail(email));

        //         // Structure the form data for Laravel
        //         const mainFormData = {
        //             serviceSelection: {
        //                 serviceType: formData.step1_selection,
        //                 companyDetails: {
        //                     companyName: formData['company-name'],
        //                     baseCountry: formData['base-country'],
        //                     accountHolder: {
        //                         name: formData['account-holder-name'],
        //                         email: formData['account-holder-email'],
        //                         phone: formData['account-holder-phone']
        //                     }
        //                 },
        //                 operatingCountries: {
        //                     hasMultipleCountries: formData['operate-other-countries'] === 'yes',
        //                     countries: formData['operating-countries'] || []
        //                 },
        //                 pciCompliant: formData['pci-compliant']
        //             },
        //             companyCategory: {
        //                 categoryType: formData.step2_selection,
        //                 merchantSegment: formData['merchantSegment'],
        //                 accountDetails: formData.step2_selection === 'multiple-accounts' ? {
        //                     numberOfAccounts: formData['number-of-accounts'],
        //                     dashboardPreference: formData['dashboard-preference']
        //                 } : null,
        //                 masterAccountDetails: formData.step2_selection === 'master-account' ? {
        //                     businessType: formData['business-type'],
        //                     platformDetails: formData['business-type'] === 'platform' ? {
        //                         businessType: formData['platform-business-type']
        //                     } : null
        //                 } : null
        //             },
        //             acceptance: {
        //                 settlementCurrency: formData['settlement-currency'],
        //                 payinCurrencies: formData['payin-currencies'],
        //                 paymentMethods: formData['payment-methods']
        //             },
        //             integration: {
        //                 channels: formData['integration-channels'],
        //                 webIntegration: formData['integration-channels']?.includes('web') ? {
        //                     mainDomain: formData['main-domain'],
        //                     testDomain: formData['test-domain'],
        //                     frontendTech: formData['frontend-tech'],
        //                     backendTech: formData['backend-tech']
        //                 } : null,
        //                 appIntegration: formData['integration-channels']?.includes('app') ? {
        //                     technologies: formData['app-technologies'],
        //                     bundleIds: appTechBundleIds
        //                 } : null,
        //                 integrationFlow: formData['integration-flow'],
        //                 features: formData['features'],
        //                 dates: {
        //                     goLiveDate: formData['go-live-date'],
        //                     reviewMeetingDate: formData['review-meeting-date']
        //                 }
        //             },
        //             reporting: {
        //                 channels: formData['report-channels']
        //             },
        //             ccEmails: ccEmails,
        //         };
        //         const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        //         // Add form data and CSRF token
        //         formDataToSubmit.append('formData', JSON.stringify(mainFormData));
        //         formDataToSubmit.append('_token', csrfToken);

        //         // Add files
        //         formDataToSubmit.append('csvFile', csvFile);
        //         formDataToSubmit.append('pdfFile', pdfFile);

        //         // Create XMLHttpRequest for synchronous request
        //         const xhr = new XMLHttpRequest();
        //         xhr.open('POST', '/api/merchant-onboarding', false); // false makes it synchronous

        //         // Set headers including CSRF token
        //         xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        //         xhr.setRequestHeader('Accept', 'application/json');

        //         // Send request and handle response
        //         xhr.onreadystatechange = function() {
        //             if (xhr.readyState === 4) {
        //                 if (xhr.status === 200) {
        //                     try {
        //                         const response = JSON.parse(xhr.responseText);
        //                         if (response.message) {
        //                             alert(response.message);
        //                         } else {
        //                             alert('Form submitted successfully!');
        //                         }
        //                         resetForm();
        //                     } catch (e) {
        //                         alert('Form submitted successfully!');
        //                         resetForm();
        //                     }
        //                 } else if (xhr.status === 422) {
        //                     // Handle Laravel validation errors
        //                     try {
        //                         const response = JSON.parse(xhr.responseText);
        //                         let errorMessage = 'Validation errors:\n';
        //                         Object.keys(response.errors).forEach(key => {
        //                             errorMessage += `${key}: ${response.errors[key].join(', ')}\n`;
        //                         });
        //                         alert(errorMessage);
        //                     } catch (e) {
        //                         alert('Validation failed. Please check your input.');
        //                     }
        //                 } else {
        //                     alert('Error submitting form. Please try again.');
        //                 }
        //             }
        //         };

        //         // Handle network errors
        //         xhr.onerror = function() {
        //             alert('Network error occurred. Please try again.');
        //         };

        //         // Send the request
        //         xhr.send(formDataToSubmit);

        //     } catch (error) {
        //         console.error('Error preparing form data:', error);
        //         alert('Error preparing form data. Please try again.');
        //     }
        // }

        function submitForm() {
            try {
                // Show loading overlay
                document.body.insertAdjacentHTML('beforeend', `
                    <div id="loadingOverlay" style="
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(255,255,255,0.8);
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        z-index: 9999;
                    ">
                        <div style="text-align: center;">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2">Processing your submission...</p>
                        </div>
                    </div>
                `);

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                // Create FormData object
                const formDataToSubmit = new FormData();

                // Collect CC emails
                const ccEmails = Array.from(document.querySelectorAll('.cc-email'))
                    .map(input => input.value.trim())
                    .filter(email => email && isValidEmail(email));
                    console.log("ccEmails", ccEmails);
                // Structure the form data

                formDataToSubmit.append('serviceType', formData.step1_selection);
                formDataToSubmit.append('companyName', formData['company-name']);
                formDataToSubmit.append('baseCountry', formData['base-country']);
                formDataToSubmit.append('accountHolderName', formData['account-holder-name']);
                formDataToSubmit.append('accountHolderEmail', formData['account-holder-email']);
                formDataToSubmit.append('accountHolderPhone', formData['account-holder-phone']);
                formDataToSubmit.append('hasMultipleCountries', formData['operate-other-countries'] === 'yes');

                // Handle operating countries array
                if (formData['operating-countries']) {
                    formData['operating-countries'].forEach((country, index) => {
                        formDataToSubmit.append(`operatingCountries[${index}]`, country);
                    });
                }

                formDataToSubmit.append('pciCompliant', formData['pci-compliant']);

                // Append company category data
                formDataToSubmit.append('categoryType', formData.step2_selection);
                formDataToSubmit.append('merchantSegment', formData['merchantSegment']);

                if (formData.step2_selection === 'multiple-accounts') {
                    formDataToSubmit.append('numberOfAccounts', formData['number-of-accounts']);
                    formDataToSubmit.append('dashboardPreference', formData['dashboard-preference']);
                }

                if (formData.step2_selection === 'master-account') {
                    formDataToSubmit.append('businessType', formData['business-type']);
                    if (formData['business-type'] === 'platform') {
                        formDataToSubmit.append('platformBusinessType', formData['platform-business-type']);
                    }
                }

                // Append acceptance data
                formDataToSubmit.append('settlementCurrency', formData['settlement-currency']);

                // Handle payin currencies array
                if (formData['payin-currencies']) {
                    formData['payin-currencies'].forEach((currency, index) => {
                        formDataToSubmit.append(`payinCurrencies[${index}]`, currency);
                    });
                }

                // Handle payment methods array
                if (formData['payment-methods']) {
                    formData['payment-methods'].forEach((method, index) => {
                        formDataToSubmit.append(`paymentMethods[${index}]`, method);
                    });
                }

                // Append integration data
                if (formData['integration-channels']) {
                    formData['integration-channels'].forEach((channel, index) => {
                        formDataToSubmit.append(`integrationChannels[${index}]`, channel);
                    });

                    if (formData['integration-channels'].includes('web')) {
                        formDataToSubmit.append('mainDomain', formData['main-domain']);
                        formDataToSubmit.append('testDomain', formData['test-domain']);
                        formDataToSubmit.append('frontendTech', formData['frontend-tech']);
                        formDataToSubmit.append('backendTech', formData['backend-tech']);
                    }

                    if (formData['integration-channels'].includes('app')) {
                        formDataToSubmit.append('appTechnologies', formData['app-technologies']);
                        // Handle bundle IDs
                        if (appTechBundleIds) {
                            Object.entries(appTechBundleIds).forEach(([platform, bundleId]) => {
                                formDataToSubmit.append(`bundleIds[${platform}]`, bundleId);
                            });
                        }
                    }
                }

                formDataToSubmit.append('integrationFlow', formData['integration-flow']);

                // Handle features array
                if (formData['features']) {
                    formData['features'].forEach((feature, index) => {
                        formDataToSubmit.append(`features[${index}]`, feature);
                    });
                }

                formDataToSubmit.append('goLiveDate', formData['go-live-date']);
                formDataToSubmit.append('reviewMeetingDate', formData['review-meeting-date']);

                // Append reporting data
                if (formData['report-channels']) {
                    formData['report-channels'].forEach((channel, index) => {
                        formDataToSubmit.append(`reportChannels[${index}]`, channel);
                    });
                }

                // Append CC emails
                ccEmails.forEach((email, index) => {
                    formDataToSubmit.append(`ccEmails[${index}]`, email);
                });

                // const mainFormData = {
                //     serviceSelection: {
                //         serviceType: formData.step1_selection,
                //         companyDetails: {
                //             companyName: formData['company-name'],
                //             baseCountry: formData['base-country'],
                //             accountHolder: {
                //                 name: formData['account-holder-name'],
                //                 email: formData['account-holder-email'],
                //                 phone: formData['account-holder-phone']
                //             }
                //         },
                //         operatingCountries: {
                //             hasMultipleCountries: formData['operate-other-countries'] === 'yes',
                //             countries: formData['operating-countries'] || []
                //         },
                //         pciCompliant: formData['pci-compliant']
                //     },
                //     companyCategory: {
                //         categoryType: formData.step2_selection,
                //         merchantSegment: formData['merchantSegment'],
                //         accountDetails: formData.step2_selection === 'multiple-accounts' ? {
                //             numberOfAccounts: formData['number-of-accounts'],
                //             dashboardPreference: formData['dashboard-preference']
                //         } : null,
                //         masterAccountDetails: formData.step2_selection === 'master-account' ? {
                //             businessType: formData['business-type'],
                //             platformDetails: formData['business-type'] === 'platform' ? {
                //                 businessType: formData['platform-business-type']
                //             } : null
                //         } : null
                //     },
                //     acceptance: {
                //         settlementCurrency: formData['settlement-currency'],
                //         payinCurrencies: formData['payin-currencies'],
                //         paymentMethods: formData['payment-methods']
                //     },
                //     integration: {
                //         channels: formData['integration-channels'],
                //         webIntegration: formData['integration-channels']?.includes('web') ? {
                //             mainDomain: formData['main-domain'],
                //             testDomain: formData['test-domain'],
                //             frontendTech: formData['frontend-tech'],
                //             backendTech: formData['backend-tech']
                //         } : null,
                //         appIntegration: formData['integration-channels']?.includes('app') ? {
                //             technologies: formData['app-technologies'],
                //             bundleIds: appTechBundleIds
                //         } : null,
                //         integrationFlow: formData['integration-flow'],
                //         features: formData['features'],
                //         dates: {
                //             goLiveDate: formData['go-live-date'],
                //             reviewMeetingDate: formData['review-meeting-date']
                //         }
                //     },
                //     reporting: {
                //         channels: formData['report-channels']
                //     },
                //     ccEmails: ccEmails,
                // };



                // Generate files
                const csvBlob = new Blob([generateCSVData()], {
                    type: 'text/csv;charset=utf-8'
                });
                const csvFile = new File([csvBlob], 'merchant_onboarding.csv', {
                    type: 'text/csv;charset=utf-8'
                });

                const pdfBlob = generatePDFData();
                const pdfFile = new File([pdfBlob], 'merchant_onboarding.pdf', {
                    type: 'application/pdf'
                });

                // Add data to FormData
                formDataToSubmit.append('csvFile', csvFile);
                formDataToSubmit.append('pdfFile', pdfFile);
                formDataToSubmit.append('_token', csrfToken);

                // Create XMLHttpRequest for synchronous submission
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/scoping/submit', false); // false makes it synchronous
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                xhr.setRequestHeader('Accept', 'application/json');

                // Handle the response
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        // Remove loading overlay
                        document.getElementById('loadingOverlay')?.remove();
                        console.log(formDataToSubmit.get('formData'))
                        if (xhr.status === 200) {
                            try {
                                const response = JSON.parse(xhr?.responseText);
                                const formDetails = JSON.parse(response?.formData);
                                // Store any necessary data in session storage
                                sessionStorage.setItem('submissionReference', response.referenceNumber);
                                sessionStorage.setItem('responseItems', response);

                                // Redirect to success page
                                console.log(formDetails);
                                alert(response.message || 'Form submitted successfully!');
                                // Redirect to a generic success page if JSON parsing fails
                                // window.location.href = '/test-card';



                                resetForm();

                            } catch (e) {

                            }
                        } else if (xhr.status === 422) {
                            // Handle Laravel validation errors
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.redirect) {
                                    // Store validation errors in session storage
                                    sessionStorage.setItem('validationErrors', JSON.stringify(response.errors));

                                    // Redirect to error page
                                    // window.location.href = response.redirect;
                                } else {
                                    let errorMessage = 'Validation errors:\n';
                                    Object.keys(response.errors).forEach(key => {
                                        errorMessage += `${key}: ${response.errors[key].join(', ')}\n`;
                                    });
                                    alert(errorMessage);
                                }
                            } catch (e) {
                                alert('Validation failed. Please check your input.');
                            }
                        } else {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.redirect) {
                                    // Store error message in session storage
                                    sessionStorage.setItem('submissionError', response.error ||
                                        'Unknown error occurred');
                                    // Redirect to error page
                                    // window.location.href = response.redirect;
                                } else {
                                    alert('Error submitting form. Please try again.');
                                }
                            } catch (e) {
                                // Redirect to generic error page if JSON parsing fails
                                // window.location.href = '/merchant/error';
                            }
                        }
                    }
                };

                // Handle network errors
                xhr.onerror = function() {
                    // Remove loading overlay
                    document.getElementById('loadingOverlay')?.remove();

                    // Store error message in session storage
                    sessionStorage.setItem('submissionError', 'Network error occurred');

                    // Redirect to error page
                    // window.location.href = '/merchant/error';
                };

                // Send the request
                xhr.send(formDataToSubmit);

            } catch (error) {
                // Remove loading overlay
                document.getElementById('loadingOverlay')?.remove();

                console.error('Error preparing form data:', error);

                // Store error message in session storage
                sessionStorage.setItem('submissionError', error.message || 'Error preparing form data');

                // Redirect to error page
                // window.location.href = '/merchant/error';
            }
        }

        // Add functions to handle page load events for success and error pages
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we're on the success page
            if (window.location.pathname.includes('/merchant/success')) {
                const reference = sessionStorage.getItem('submissionReference');
                if (reference) {
                    // You can use this reference to show additional details
                    document.getElementById('referenceNumber').textContent = reference;
                    // Clear the session storage
                    sessionStorage.removeItem('submissionReference');
                }
            }

            // Check if we're on the error page
            if (window.location.pathname.includes('/merchant/error')) {
                const error = sessionStorage.getItem('submissionError');
                const validationErrors = sessionStorage.getItem('validationErrors');

                if (error) {
                    document.getElementById('errorMessage').textContent = error;
                    sessionStorage.removeItem('submissionError');
                }

                if (validationErrors) {
                    try {
                        const errors = JSON.parse(validationErrors);
                        const errorList = document.getElementById('validationErrorList');
                        if (errorList) {
                            Object.entries(errors).forEach(([field, messages]) => {
                                const li = document.createElement('li');
                                li.innerHTML = `<strong>${field}:</strong> ${messages.join(', ')}`;
                                errorList.appendChild(li);
                            });
                        }
                        sessionStorage.removeItem('validationErrors');
                    } catch (e) {
                        console.error('Error parsing validation errors:', e);
                    }
                }
            }
        });

        // Add a utility function to handle form reset with confirmation
        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
                // Reset form elements
                document.getElementById('multiStepForm').reset();

                // Reset form data
                Object.keys(formData).forEach(key => delete formData[key]);
                appTechBundleIds = {};

                // Reset UI state
                currentStep = 0;

                // Reset step indicators
                document.querySelectorAll('.form-step').forEach((step, index) => {
                    step.classList.toggle('active', index === 0);
                });
                document.querySelectorAll('.step-dot').forEach((dot, index) => {
                    dot.classList.toggle('active', index === 0);
                });

                // Reset cards and fields
                document.querySelectorAll('.option-card').forEach(card => {
                    card.classList.remove('selected');
                });
                document.querySelectorAll('.conditional-field').forEach(field => {
                    field.classList.remove('show');
                });

                // Reset headers and summaries
                document.querySelector('.account-header')?.classList.remove('show');
                document.querySelector('.congratulations')?.classList.remove('show');
                document.querySelector('.summary-table')?.classList.remove('show');
                document.querySelector('.export-buttons')?.classList.remove('show');

                // Reset navigation
                const navigation = document.querySelector('.navigation');
                if (navigation) {
                    navigation.style.display = 'block';
                }
                const prevBtn = document.getElementById('prevBtn');
                if (prevBtn) {
                    prevBtn.style.visibility = 'hidden';
                }
                const nextBtn = document.getElementById('nextBtn');
                if (nextBtn) {
                    nextBtn.textContent = 'Next step';
                }

                // Scroll to top
                window.scrollTo(0, 0);

                return true;
            }
            return false;
        }

        // Add route handling utility
        const routes = {
            success: '/merchant/success',
            error: '/merchant/error',
            dashboard: '/merchant/dashboard',
            support: '/merchant/support'
        };

        function redirect(route, params = {}) {
            let url = routes[route] || route;

            // Add query parameters if any
            if (Object.keys(params).length > 0) {
                const queryString = new URLSearchParams(params).toString();
                url = `${url}?${queryString}`;
            }

            // window.location.href = url;
        }

        // Add loading overlay utility
        function showLoadingOverlay(message = 'Processing...') {
            const overlay = document.createElement('div');
            overlay.id = 'loadingOverlay';
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255,255,255,0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            `;

            overlay.innerHTML = `
                <div style="text-align: center;">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">${message}</p>
                </div>
            `;

            document.body.appendChild(overlay);
            return overlay;
        }

        function hideLoadingOverlay() {
            document.getElementById('loadingOverlay')?.remove();
        }

        // Add form validation utility
        function validateForm() {
            const requiredFields = document.querySelectorAll('[required]');
            const errors = [];

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    errors.push({
                        field: field.name,
                        message: `${field.name.replace('-', ' ')} is required`
                    });
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            return {
                isValid: errors.length === 0,
                errors
            };
        }

        function isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        // Helper function to generate CSV data synchronously
        function generateCSVData() {
            const rows = [
                ['Field', 'Value']
            ];

            for (const [key, value] of Object.entries(formData)) {
                if (key === 'pci-compliant') {
                    rows.push(['PCI Compliance Status', value === 'yes' ? 'Yes' : 'No']);
                } else if (key === 'app-technologies' && appTechBundleIds && Object.keys(appTechBundleIds).length > 0) {
                    Object.entries(appTechBundleIds).forEach(([tech, ids]) => {
                        if (ids.length > 0 && ids[0]) {
                            rows.push([`${getTechnologyLabel(tech)} Bundle IDs`, ids.join('; ')]);
                        }
                    });
                } else if (key !== 'bundle-ids') {
                    rows.push([
                        formatFieldName(key),
                        Array.isArray(value) ? value.join('; ') : value
                    ]);
                }
            }

            return rows
                .map(row => row.map(cell => `"${String(cell).replace(/"/g, '""')}"`).join(','))
                .join('\n');
        }

        // Helper function to generate PDF data synchronously
        function generatePDFData() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Add title
            doc.setFontSize(16);
            doc.text('Merchant Onboarding Summary', 20, 20);

            // Add content
            doc.setFontSize(12);
            let yPosition = 40;

            for (const [key, value] of Object.entries(formData)) {
                if (key === 'app-technologies' && appTechBundleIds && Object.keys(appTechBundleIds).length > 0) {
                    doc.text('App Technologies and Bundle IDs:', 20, yPosition);
                    yPosition += 10;

                    Object.entries(appTechBundleIds).forEach(([tech, ids]) => {
                        if (ids.length > 0 && ids[0]) {
                            const techLabel = getTechnologyLabel(tech);
                            doc.text(`${techLabel}:`, 25, yPosition);
                            yPosition += 7;

                            ids.forEach(id => {
                                if (id) {
                                    doc.text(`- ${id}`, 30, yPosition);
                                    yPosition += 7;
                                }
                            });
                        }
                    });
                } else if (key !== 'bundle-ids') {
                    const text = `${formatFieldName(key)}: ${Array.isArray(value) ? value.join(', ') : value}`;
                    const textLines = doc.splitTextToSize(text, 170);

                    if (yPosition + (textLines.length * 7) > 280) {
                        doc.addPage();
                        yPosition = 20;
                    }

                    doc.text(textLines, 20, yPosition);
                    yPosition += (textLines.length * 7) + 3;
                }
            }

            return doc.output('blob');
        }

        // Reset form function remains the same
        function resetForm() {
            // Reset form elements
            document.getElementById('multiStepForm').reset();

            // Reset form data
            Object.keys(formData).forEach(key => delete formData[key]);
            appTechBundleIds = {};

            // Reset UI state
            currentStep = 0;

            // Reset step indicators
            document.querySelectorAll('.form-step').forEach((step, index) => {
                step.classList.toggle('active', index === 0);
            });
            document.querySelectorAll('.step-dot').forEach((dot, index) => {
                dot.classList.toggle('active', index === 0);
            });

            // Reset cards and fields
            document.querySelectorAll('.option-card').forEach(card => {
                card.classList.remove('selected');
            });
            document.querySelectorAll('.conditional-field').forEach(field => {
                field.classList.remove('show');
            });

            // Reset headers and summaries
            document.querySelector('.account-header').classList.remove('show');
            document.querySelector('.congratulations').classList.remove('show');
            document.querySelector('.summary-table').classList.remove('show');
            document.querySelector('.export-buttons').classList.remove('show');

            // Reset navigation
            document.querySelector('.navigation').style.display = 'block';
            document.getElementById('prevBtn').style.visibility = 'hidden';
            document.getElementById('nextBtn').textContent = 'Next step';

            // Scroll to top
            window.scrollTo(0, 0);
        }
    </script>
</body>

</html>
