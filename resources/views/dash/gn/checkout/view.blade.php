@extends('dash.layouts.index')

@section('content')



        <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Create Business Form</h3>
              </div>

              @if(session('success'))
              <div class="alert alert-success">
                  {{ session('success') }}
              </div>
          @endif

          @if($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach($errors->all() as $error)
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
                      <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">Brand Information</span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#contact-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">Contact information</span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#bank-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">Bank/Billing Information</span>
                      </button>
                    </div>
                  </div>
                  <form action="{{ route('business.create') }}" method="POST">
                    @csrf
                    {{-- request type --}}

                    <input type="text" hidden value="createBusiness">
                  <div class="bs-stepper-content">
                    <!-- your steps content here -->
                    <div id="brand-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Name (en)</label>
                            <input type="text" name="brandNameEn" class="form-control" id="brandNameEn" placeholder="Enter Brand Name">
                      </div>
                        <div class="form-group">
                            <label for="brandNameEn">Name (ar)</label>
                            <input type="text" class="form-control" name="brandNameAr" id="brandNameAr" placeholder="Enter Brand Name">
                      </div>

                      <div class="form-group">
                        <label for="brandType">Brand Type</label>

                        <select name="branType" class="form-control" style="width: 100%;" id="brandType">
                            <option value="ind">Individual (For individual based businesses e.g. Instagram businesses, freelancers etc.)</option>
                            <option value="corp">Corporate (For registered business)</option>
                          </select>

                    </div>


                    <hr>

                    <div class="form-group">
                        <label for="brandType">Entity Details</label>
                        <hr>

                        <label for="">Legal Name (en) <span style="color: red">*</span></label>
                        <input required style="" type="text" class="form-control" id="name" placeholder="Enter Brand Legal name (en)">
                        <br>
                        <label for="">Legal Name (ar)</label>
                        <input style="" type="text" class="form-control" id="name" placeholder="Enter Brand Legal Name (ar)">
                        <br/>
                        <label for="">Is your business licensed?</label>

                        <select name="isLicensed" class="form-control" style="width: 100%;" id="isLicensed">
                            <option value="yes">Yes</option>
                            <option selected value="no">No</option>
                          </select>

                          <div style="display: none" id="licenseDetails">
                            <br>
                            <label for="">License Type</label>
                            <input style="" type="text" class="form-control" id="name" placeholder="Enter Brand Legal Name (ar)">
                            <br>
                            <label for="">License Number</label>
                            <input style="" type="text" class="form-control" id="name" placeholder="Enter Brand Legal Name (ar)">
                            <br>
                            <label for="">Tax Number</label>
                            <input style="" type="text" class="form-control" id="name" placeholder="Enter Brand Legal Name (ar)">

                          </div>
                          <br/>
                          <label for="">Is your business not for profit?</label>

                          <select name="isLicensed" class="form-control" style="width: 100%;" id="isLicensed">
                              <option value="yes">Yes, my business is not for profit </option>
                              <option selected value="no">No, my business is for profit</option>
                            </select>

                            <br/>
                            <label for="">What is the country that your business operates in?</label>

                            <select name="brandCountry" class="form-control" style="width: 100%;" id="countryList">
                                <option value="">-- Select a country --</option>

                              </select>


                    </div>


                      <button class="btn btn-primary" type="button" onclick="stepper.next()">Next</button>
                    </div>
                    <div id="contact-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">


                            <!-- Contact Person Name -->
                            <div class="form-group">
                                <label for="contactPersonTitle">Title</label>
                                <input type="text" name="contact_person[name][title]" class="form-control" id="contactPersonTitle" placeholder="Enter Title">
                            </div>
                            <div class="form-group">
                                <label for="contactPersonFirstName">First Name</label>
                                <input type="text" name="contact_person[name][first]" class="form-control" id="contactPersonFirstName" placeholder="Enter First Name">
                            </div>
                            <div class="form-group">
                                <label for="contactPersonMiddleName">Middle Name</label>
                                <input type="text" name="contact_person[name][middle]" class="form-control" id="contactPersonMiddleName" placeholder="Enter Middle Name">
                            </div>
                            <div class="form-group">
                                <label for="contactPersonLastName">Last Name</label>
                                <input type="text" name="contact_person[name][last]" class="form-control" id="contactPersonLastName" placeholder="Enter Last Name">
                            </div>

                            <!-- Contact Info -->
                            <div class="form-group">
                                <label for="contactPersonEmail">Email</label>
                                <input type="email" name="contact_person[contact_info][primary][email]" class="form-control" id="contactPersonEmail" placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label for="contactPersonPhoneCountryCode">Phone Country Code</label>
                                <input type="text" name="contact_person[contact_info][primary][phone][country_code]" class="form-control" id="contactPersonPhoneCountryCode" placeholder="Enter Country Code">
                            </div>
                            <div class="form-group">
                                <label for="contactPersonPhoneNumber">Phone Number</label>
                                <input type="text" name="contact_person[contact_info][primary][phone][number]" class="form-control" id="contactPersonPhoneNumber" placeholder="Enter Phone Number">
                            </div>

                            <!-- Nationality and Date of Birth -->
                            <div class="form-group">
                                <label for="contactPersonNationality">Nationality</label>
                                <input type="text" name="contact_person[nationality]" class="form-control" id="contactPersonNationality" placeholder="Enter Nationality">
                            </div>
                            <div class="form-group">
                                <label for="contactPersonDOB">Date of Birth</label>
                                <input type="date" name="contact_person[date_of_birth]" class="form-control" id="contactPersonDOB">
                            </div>

                            <!-- Authorization -->
                            <div class="form-group">
                                <label for="isAuthorized">Are you Authorized?</label>
                                <select name="contact_person[is_authorized]" class="form-control" id="isAuthorized">
                                    <option value="yes">Yes</option>
                                    <option selected value="no">No</option>
                                </select>
                            </div>
                            <div id="authorizationDetails" style="display: none">
                            <div class="form-group">
                                <label for="authorizationTitle">Authorization Title</label>
                                <input type="text" name="contact_person[authorization][name][title]" class="form-control" id="authorizationTitle" placeholder="Enter Authorization Title">
                            </div>
                            <div class="form-group">
                                <label for="authorizationFirstName">Authorization First Name</label>
                                <input type="text" name="contact_person[authorization][name][first]" class="form-control" id="authorizationFirstName" placeholder="Enter Authorization First Name">
                            </div>
                            <div class="form-group">
                                <label for="authorizationMiddleName">Authorization Middle Name</label>
                                <input type="text" name="contact_person[authorization][name][middle]" class="form-control" id="authorizationMiddleName" placeholder="Enter Authorization Middle Name">
                            </div>
                            <div class="form-group">
                                <label for="authorizationLastName">Authorization Last Name</label>
                                <input type="text" name="contact_person[authorization][name][last]" class="form-control" id="authorizationLastName" placeholder="Enter Authorization Last Name">
                            </div>
                            <div class="form-group">
                                <label for="authorizationType">Authorization Type</label>
                                <input type="text" name="contact_person[authorization][type]" class="form-control" id="authorizationType" placeholder="Enter Authorization Type">
                            </div>
                            <div class="form-group">
                                <label for="issuingCountry">Issuing Country</label>
                                <input type="text" name="contact_person[authorization][issuing_country]" class="form-control" id="issuingCountry" placeholder="Enter Issuing Country">
                            </div>
                            <div class="form-group">
                                <label for="issuingDate">Issuing Date</label>
                                <input type="date" name="contact_person[authorization][issuing_date]" class="form-control" id="issuingDate">
                            </div>
                            <div class="form-group">
                                <label for="expiryDate">Expiry Date</label>
                                <input type="date" name="contact_person[authorization][expiry_date]" class="form-control" id="expiryDate">
                            </div>
                            <div class="form-group">
                                <label for="authorizationFiles">Authorization Files</label>
                                <input type="text" name="contact_person[authorization][files][]" class="form-control" id="authorizationFiles" placeholder="Enter File Reference">
                            </div>
                        </div>

                         <button class="btn btn-primary" type="button" onclick="stepper.previous()">Previous</button>
                         <button class="btn btn-primary" type="button" onclick="stepper.next()">Next</button>
                       </div>
                    <div id="bank-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
    <!-- Bank Account -->
    <h3>Bank Account</h3>
    <div class="form-group">
        <label for="bankAccountIban">IBAN</label>
        <input type="text" name="bank_account[iban]" class="form-control" id="bankAccountIban" placeholder="Enter IBAN">
    </div>
    <div class="form-group">
        <label for="bankAccountSwiftCode">SWIFT Code</label>
        <input type="text" name="bank_account[swift_code]" class="form-control" id="bankAccountSwiftCode" placeholder="Enter SWIFT Code">
    </div>
    <div class="form-group">
        <label for="bankAccountNumber">Account Number</label>
        <input type="text" name="bank_account[account_number]" class="form-control" id="bankAccountNumber" placeholder="Enter Account Number">
    </div>

    <!-- Billing Address -->
    <h3>Billing Address</h3>
    <div class="form-group">
        <label for="billingRecipientName">Recipient Name</label>
        <input type="text" name="billing_address[recipient_name]" class="form-control" id="billingRecipientName" placeholder="Enter Recipient Name">
    </div>
    <div class="form-group">
        <label for="billingAddress1">Address Line 1</label>
        <input type="text" name="billing_address[address_1]" class="form-control" id="billingAddress1" placeholder="Enter Address Line 1">
    </div>
    <div class="form-group">
        <label for="billingAddress2">Address Line 2</label>
        <input type="text" name="billing_address[address_2]" class="form-control" id="billingAddress2" placeholder="Enter Address Line 2">
    </div>
    <div class="form-group">
        <label for="billingPOBox">P.O. Box</label>
        <input type="text" name="billing_address[po_box]" class="form-control" id="billingPOBox" placeholder="Enter P.O. Box">
    </div>
    <div class="form-group">
        <label for="billingDistrict">District</label>
        <input type="text" name="billing_address[district]" class="form-control" id="billingDistrict" placeholder="Enter District">
    </div>
    <div class="form-group">
        <label for="billingCity">City</label>
        <input type="text" name="billing_address[city]" class="form-control" id="billingCity" placeholder="Enter City">
    </div>
    <div class="form-group">
        <label for="billingState">State</label>
        <input type="text" name="billing_address[state]" class="form-control" id="billingState" placeholder="Enter State">
    </div>
    <div class="form-group">
        <label for="billingZipCode">Zip Code</label>
        <input type="text" name="billing_address[zip_code]" class="form-control" id="billingZipCode" placeholder="Enter Zip Code">
    </div>
    <div class="form-group">
        <label for="billingCountry">Country</label>
        <input type="text" name="billing_address[country]" class="form-control" id="billingCountry" placeholder="Enter Country">
    </div>
                      <button type="button" class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                      <input type="submit" class="btn btn-primary" value="Submit">
                      {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                    </div>
                  </div>
                  </form>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                Visit <a href="https://github.com/Johann-S/bs-stepper/#how-to-use-it">bs-stepper documentation</a> for more examples and information about the plugin.
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->




@endsection
