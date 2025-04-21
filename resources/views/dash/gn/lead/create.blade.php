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
                        <div class="step" data-target="#brand-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="brand-part-trigger">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Brand Information</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#contact-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="contact-part-trigger">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Contact Information</span>
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('business.create') }}" method="POST">
                        @csrf
                        <div class="bs-stepper-content">
                            <!-- Brand Information -->
                            <div id="brand-part" class="content" role="tabpanel" aria-labelledby="brand-part-trigger">
                                <div class="form-group">
                                    <label for="brandNameEn">Brand Name (en)</label>
                                    <input type="text" name="brand[name][0][text]" class="form-control" id="brandNameEn" required>
                                    <input type="hidden" name="brand[name][0][lang]" value="en">
                                </div>

                                <div class="form-group">
                                    <label for="brandType">Brand Type</label>
                                    <select name="segment[type]" class="form-control" id="brandType" required>
                                        <option value="BUSINESS">Business</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select name="country" class="form-control" id="country" required>
                                        <option value="AE">United Arab Emirates</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="legalNameEn">Legal Name (en)</label>
                                    <input type="text" name="entity[legal_name][0][text]" class="form-control" id="legalNameEn" required>
                                    <input type="hidden" name="entity[legal_name][0][lang]" value="en">
                                </div>

                                <div class="form-group">
                                    <label for="licenseNumber">License Number</label>
                                    <input type="text" name="entity[license][number]" class="form-control" id="licenseNumber" required>
                                    <input type="hidden" name="entity[license][country]" value="AE">
                                </div>

                                <div class="form-group">
                                    <label for="licenseType">License Type</label>
                                    <input type="text" name="entity[license][type]" class="form-control" id="licenseType" required>
                                </div>

                                <button class="btn btn-primary" type="button" onclick="stepper.next()">Next</button>
                            </div>

                            <!-- Contact Information -->
                            <div id="contact-part" class="content" role="tabpanel" aria-labelledby="contact-part-trigger">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="users[0][name][0][title]" class="form-control" id="title" required>
                                </div>

                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" name="users[0][name][0][first]" class="form-control" id="firstName" required>
                                </div>

                                <div class="form-group">
                                    <label for="middleName">Middle Name</label>
                                    <input type="text" name="users[0][name][0][middle]" class="form-control" id="middleName">
                                </div>

                                <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" name="users[0][name][0][last]" class="form-control" id="lastName" required>
                                </div>

                                <input type="hidden" name="users[0][name][0][lang]" value="en">
                                <input type="hidden" name="users[0][primary]" value="true">

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="users[0][contact][email][0][address]" class="form-control" id="email" required>
                                    <input type="hidden" name="users[0][contact][email][0][primary]" value="true">
                                </div>

                                <div class="form-group">
                                    <label for="phoneCountryCode">Phone Country Code</label>
                                    <input type="text" name="users[0][contact][phone][0][country_code]" class="form-control" id="phoneCountryCode" required>
                                </div>

                                <div class="form-group">
                                    <label for="phoneNumber">Phone Number</label>
                                    <input type="text" name="users[0][contact][phone][0][number]" class="form-control" id="phoneNumber" required>
                                    <input type="hidden" name="users[0][contact][phone][0][primary]" value="true">
                                </div>

                                <div class="form-group">
                                    <label for="idNumber">Identification Number</label>
                                    <input type="text" name="users[0][identification][number]" class="form-control" id="idNumber" required>
                                </div>

                                <div class="form-group">
                                    <label for="idType">Identification Type</label>
                                    <input type="text" name="users[0][identification][type]" class="form-control" id="idType" value="national_id" readonly>
                                </div>

                                <input type="hidden" name="users[0][identification][country]" value="AE">
                                <input type="hidden" name="users[0][identification][nationality]" value="AE">

                                <!-- Hidden merchant platform ID -->
                                <input type="hidden" name="merchant[platforms][0][id]" value="commerce_platform_hKAe4525733zM2S30fN0m441">

                                <!-- Hidden post URL -->
                                <input type="hidden" name="post[url]" value="https://webhook.site/6471-4d0f-87cc-91409f092841">

                                <button class="btn btn-primary" type="button" onclick="stepper.previous()">Previous</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
