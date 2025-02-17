<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScopingController extends Controller
{
    private $freshdeskApiKey;
    private $freshdeskDomain;

    public function __construct()
    {
        $this->freshdeskApiKey = "n5GwnlgoPYiAKqGQMZ";
        $this->freshdeskDomain = "tapsupport.freshdesk.com";
    }

    public function processMerchantOnboarding(Request $request)
    {
        try {
            // Validate the request
            // $validatedData = $request->validate([
            //     'serviceType' => 'required|string',
            //     'companyName' => 'required|string',
            //     'baseCountry' => 'required|string',
            //     'accountHolderName' => 'required|string',
            //     'accountHolderEmail' => 'required|email',
            //     'accountHolderPhone' => 'required|string',
            //     'hasMultipleCountries' => 'required|string',
            //     'operatingCountries' => 'required|array',
            //     'pciCompliant' => 'required|string',
            //     'categoryType' => 'required|string',
            //     'merchantSegment' => 'required|string',
            //     'businessType' => 'required|string',
            //     'platformBusinessType' => 'required|string',
            //     'settlementCurrency' => 'required|string',
            //     'payinCurrencies' => 'required|array',
            //     'paymentMethods' => 'required|array',
            //     'integrationChannels' => 'required|array',
            //     'mainDomain' => 'required|string',
            //     'testDomain' => 'required|string',
            //     'frontendTech' => 'required|string',
            //     'backendTech' => 'required|string',
            //     'appTechnologies' => 'required|string',
            //     'bundleIds' => 'required|array',
            //     'integrationFlow' => 'required|string',
            //     'features' => 'required|array',
            //     'goLiveDate' => 'required|date',
            //     'reviewMeetingDate' => 'required|date',
            //     'reportChannels' => 'required|array',
            //     'ccEmails' => 'required|array',
            //     'csvFile' => 'required|file|mimes:csv,txt',
            //     'pdfFile' => 'required|file|mimes:pdf',
            // ]);

            // Prepare email content
            $emailBody = $this->prepareEmailBody($request);

            // Prepare file attachments
            $attachments = $this->prepareAttachments($request);

            // Send email via Freshdesk API
            $response = $this->sendFreshdeskEmail([
                'subject' => "New Merchant Onboarding - {$request['companyName']}",
                'description' => $emailBody,
                'email' => $request['accountHolderEmail'],
                'cc_emails' => $request['ccEmails'],
                'attachments' => $attachments,
                'status' => 2,
                'priority' => 2,
                'type' => 'Merchant Onboarding'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Merchant onboarding processed successfully',
                'ticket_id' => $response['id'] ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('Merchant onboarding error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error processing merchant onboarding',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function prepareEmailBody($data)
    {
        $sections = [];

        // Service Type Section
        if (!empty($data['serviceType'])) {
            $sections[] = "Service Type: {$data['serviceType']}";
        }

        // Company Information Section
        $companyInfo = [];
        if (!empty($data['companyName'])) {
            $companyInfo[] = "Company Name: {$data['companyName']}";
        }
        if (!empty($data['baseCountry'])) {
            $companyInfo[] = "Base Country: {$data['baseCountry']}";
        }
        if (!empty($data['operatingCountries']) && is_array($data['operatingCountries'])) {
            $companyInfo[] = "Operating Countries: " . implode(', ', $data['operatingCountries']);
        }
        if (!empty($companyInfo)) {
            $sections[] = "Company Information:\n" . implode("\n", $companyInfo);
        }

        // Account Holder Section
        $accountHolder = [];
        if (!empty($data['accountHolderName'])) {
            $accountHolder[] = "Name: {$data['accountHolderName']}";
        }
        if (!empty($data['accountHolderEmail'])) {
            $accountHolder[] = "Email: {$data['accountHolderEmail']}";
        }
        if (!empty($data['accountHolderPhone'])) {
            $accountHolder[] = "Phone: {$data['accountHolderPhone']}";
        }
        if (!empty($accountHolder)) {
            $sections[] = "Account Holder Details:\n" . implode("\n", $accountHolder);
        }

        // Business Details Section
        $businessDetails = [];
        if (!empty($data['businessType'])) {
            $businessDetails[] = "Business Type: {$data['businessType']}";
        }
        if (!empty($data['platformBusinessType'])) {
            $businessDetails[] = "Platform Business Type: {$data['platformBusinessType']}";
        }
        if (!empty($data['pciCompliant'])) {
            $businessDetails[] = "PCI Compliance Status: {$data['pciCompliant']}";
        }
        if (!empty($data['categoryType'])) {
            $businessDetails[] = "Category Type: {$data['categoryType']}";
        }
        if (!empty($data['merchantSegment']) && $data['merchantSegment'] !== 'undefined') {
            $businessDetails[] = "Merchant Segment: {$data['merchantSegment']}";
        }
        if (!empty($businessDetails)) {
            $sections[] = "Business Details:\n" . implode("\n", $businessDetails);
        }

        // Integration Details Section
        $integrationDetails = [];
        if (!empty($data['mainDomain'])) {
            $integrationDetails[] = "Main Domain: {$data['mainDomain']}";
        }
        if (!empty($data['testDomain'])) {
            $integrationDetails[] = "Test Domain: {$data['testDomain']}";
        }
        if (!empty($data['frontendTech'])) {
            $integrationDetails[] = "Frontend Technology: {$data['frontendTech']}";
        }
        if (!empty($data['backendTech'])) {
            $integrationDetails[] = "Backend Technology: {$data['backendTech']}";
        }
        if (!empty($data['appTechnologies'])) {
            $integrationDetails[] = "App Technologies: {$data['appTechnologies']}";
        }
        if (!empty($data['integrationChannels']) && is_array($data['integrationChannels'])) {
            $integrationDetails[] = "Integration Channels: " . implode(', ', $data['integrationChannels']);
        }
        if (!empty($data['integrationFlow'])) {
            $integrationDetails[] = "Integration Flow: {$data['integrationFlow']}";
        }
        if (!empty($integrationDetails)) {
            $sections[] = "Integration Details:\n" . implode("\n", $integrationDetails);
        }

        // Payment Configuration Section
        $paymentConfig = [];
        if (!empty($data['settlementCurrency'])) {
            $paymentConfig[] = "Settlement Currency: {$data['settlementCurrency']}";
        }
        if (!empty($data['payinCurrencies']) && is_array($data['payinCurrencies'])) {
            $paymentConfig[] = "Pay-in Currencies: " . implode(', ', $data['payinCurrencies']);
        }
        if (!empty($data['paymentMethods']) && is_array($data['paymentMethods'])) {
            $paymentConfig[] = "Payment Methods: " . implode(', ', $data['paymentMethods']);
        }
        if (!empty($paymentConfig)) {
            $sections[] = "Payment Configuration:\n" . implode("\n", $paymentConfig);
        }

        // Timeline Section
        $timeline = [];
        if (!empty($data['goLiveDate'])) {
            $timeline[] = "Go-Live Date: {$data['goLiveDate']}";
        }
        if (!empty($data['reviewMeetingDate'])) {
            $timeline[] = "Review Meeting Date: {$data['reviewMeetingDate']}";
        }
        if (!empty($timeline)) {
            $sections[] = "Timeline:\n" . implode("\n", $timeline);
        }

        // Additional Features Section
        $features = [];
        if (!empty($data['features']) && is_array($data['features'])) {
            $features[] = "Features Requested: " . implode(', ', $data['features']);
        }
        if (!empty($data['reportChannels']) && is_array($data['reportChannels'])) {
            $features[] = "Report Channels: " . implode(', ', $data['reportChannels']);
        }
        if (!empty($features)) {
            $sections[] = "Additional Features:\n" . implode("\n", $features);
        }

        // Mobile App Details Section
        if (!empty($data['bundleIds']) && is_array($data['bundleIds'])) {
            $bundleInfo = [];
            if (isset($data['bundleIds']['android'])) {
                $bundleInfo[] = "Android Bundle ID: {$data['bundleIds']['android']}";
            }
            if (isset($data['bundleIds']['flutter'])) {
                $bundleInfo[] = "Flutter Bundle ID: {$data['bundleIds']['flutter']}";
            }
            if (!empty($bundleInfo)) {
                $sections[] = "Mobile App Details:\n" . implode("\n", $bundleInfo);
            }
        }

        // Combine all sections with double line breaks between them
        return implode("\n\n", array_filter($sections));
    }

    private function prepareAttachments(Request $request)
    {
        $attachments = [];

        if ($request->hasFile('csvFile')) {
            $csvFile = $request->file('csvFile');
            $attachments[] = [
                'name' => $csvFile->getClientOriginalName(),
                'content' => base64_encode(file_get_contents($csvFile->getRealPath()))
            ];
        }

        if ($request->hasFile('pdfFile')) {
            $pdfFile = $request->file('pdfFile');
            $attachments[] = [
                'name' => $pdfFile->getClientOriginalName(),
                'content' => base64_encode(file_get_contents($pdfFile->getRealPath()))
            ];
        }

        return $attachments;
    }

    private function sendFreshdeskEmail($data)
    {
        $response = Http::withBasicAuth($this->freshdeskApiKey, 'X')
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post("{$this->freshdeskDomain}/api/v2/tickets", $data);

        if (!$response->successful()) {
            throw new \Exception('Failed to create Freshdesk ticket: ' . $response->body());
        }

        return $response->json();
    }
}
