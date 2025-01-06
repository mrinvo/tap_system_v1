@extends('dash.layouts.index')

@section('content')

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Retrieve a Merchant</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form id="dataForm" method="POST">
        @csrf
        <div class="card-body">
            <input type="hidden" name="requestType" id="requestType"  value="abWhitelist">
          <div class="form-group">
            <label for="merchantMid">MID</label>
            <input name="merchantMid" type="text" class="form-control" id="merchantMid" placeholder="Enter Merchant ID">
          </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            {{-- <input type="submit" value="submit"> --}}
          <button onclick="retreiveMerchant()" type="button" id="whitelistButton" class="btn btn-primary">Retrieve</button>
        </div>
      </form>
    </div>
    <!-- /.card -->



</div>

<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">
        <i class="fas fa-info-circle"></i>
        Merchant Details
      </h3>
    </div>
    <div id="merchantOverlayDiv" style="display: none;" class="overlay">
      <i class="fas fa-3x fa-sync-alt fa-spin"></i>
      <div class="text-bold pt-2"></div>
    </div>

    <div class="card-body">
      <h4>Information</h4>
      <div class="row">
        <div class="col-4 col-sm-3">
          <div class="nav flex-column nav-tabs h-100" id="tabs" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="general-tab" data-toggle="pill" href="#general-details" role="tab" aria-controls="general-details" aria-selected="true">General Details</a>
            <a class="nav-link" id="terminals-tab" data-toggle="pill" href="#terminals-details" role="tab" aria-controls="terminals-details" aria-selected="false">Terminals</a>
            <a class="nav-link" id="risk-tab" data-toggle="pill" href="#risk-details" role="tab" aria-controls="risk-details" aria-selected="false">Risk</a>
            <a class="nav-link" id="operator-tab" data-toggle="pill" href="#operator-details" role="tab" aria-controls="operator-details" aria-selected="false">Operator</a>
            <a class="nav-link" id="data-status-tab" data-toggle="pill" href="#data-status-details" role="tab" aria-controls="data-status-details" aria-selected="false">Data Status</a>
            <a class="nav-link" id="data-verification-tab" data-toggle="pill" href="#data-verification-details" role="tab" aria-controls="data-verification-details" aria-selected="false">Data Verification</a>
            <a class="nav-link" id="vert-tabs-json-tab" data-toggle="pill" href="#vert-tabs-json" role="tab" aria-controls="vert-tabs-json" aria-selected="false">Full JSON</a>
          </div>
        </div>
        <div class="col-8 col-sm-9">
          <div class="tab-content" id="tabs-content">
            <!-- General Details Tab -->
            <div class="tab-pane fade show active" id="general-details" role="tabpanel" aria-labelledby="general-tab"></div>

            <!-- Terminals Tab -->
            <div class="tab-pane fade" id="terminals-details" role="tabpanel" aria-labelledby="terminals-tab"></div>

            <!-- Risk Tab -->
            <div class="tab-pane fade" id="risk-details" role="tabpanel" aria-labelledby="risk-tab"></div>

            <!-- Operator Tab -->
            <div class="tab-pane fade" id="operator-details" role="tabpanel" aria-labelledby="operator-tab"></div>

            <!-- Data Status Tab -->
            <div class="tab-pane fade" id="data-status-details" role="tabpanel" aria-labelledby="data-status-tab"></div>

            <!-- Data Verification Tab -->
            <div class="tab-pane fade" id="data-verification-details" role="tabpanel" aria-labelledby="data-verification-tab"></div>
            <div class="tab-pane fade" id="vert-tabs-json" role="tabpanel" aria-labelledby="vert-tabs-json-tab">
                <pre id="json-tab-content" style="background-color: #f8f9fa; padding: 10px; border-radius: 5px; overflow-x: auto;"></pre>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>







@endsection
