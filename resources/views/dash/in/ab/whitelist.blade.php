@extends('dash.layouts.index')

@section('content')

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Apple Pay Whitelist</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form id="dataForm" method="POST">
        @csrf
        <div class="card-body">
            <input type="hidden" name="requestType" id="requestType"  value="abWhitelist">
          <div class="form-group">
            <label for="abMid">MID</label>
            <input name="abMid" type="text" class="form-control" id="abMid" placeholder="Enter Merchant ID">
          </div>
          <div class="form-group">
            <label for="abBrandId">Brand ID</label>
            <input name="abBrandId" type="text" class="form-control" id="abBrandId" placeholder="Enter Brand ID">
          </div>
          <div class="form-group">
            <label for="abDomains">Domains</label>
            <input name="abDomains" type="text" class="form-control" id="abDomains" placeholder="Enter Domains Seperated by commas">
          </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            {{-- <input type="submit" value="submit"> --}}
          <button onclick="applePayWhitelist()" type="button" id="whitelistButton" class="btn btn-primary">Whitelist</button>
        </div>
      </form>
    </div>
    <!-- /.card -->



</div>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i>
            Whitelist Details
        </h3>
    </div>
    <div id="abOverlayDiv" style="display: none;" class="overlay">
        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
        <div class="text-bold pt-2"></div>
    </div>

    <div class="card-body">
        <h4>Information</h4>
        <div class="row">
            <div class="col-5 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="vert-tabs-details-tab" data-toggle="pill" href="#vert-tabs-details" role="tab" aria-controls="vert-tabs-details" aria-selected="true">Details</a>
                    <a class="nav-link" id="vert-tabs-domains-tab" data-toggle="pill" href="#vert-tabs-domains" role="tab" aria-controls="vert-tabs-domains" aria-selected="false">Domain Names</a>
                    <a class="nav-link" id="vert-tabs-json-tab" data-toggle="pill" href="#vert-tabs-json" role="tab" aria-controls="vert-tabs-json" aria-selected="false">Full JSON</a>
                </div>
            </div>
            <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-tabContent">
                    <!-- Details Tab -->
                    <div class="tab-pane text-left fade show active" id="vert-tabs-details" role="tabpanel" aria-labelledby="vert-tabs-details-tab"></div>
                    <!-- Domain Names Tab -->
                    <div class="tab-pane fade" id="vert-tabs-domains" role="tabpanel" aria-labelledby="vert-tabs-domains-tab"></div>
                    <!-- Full JSON Tab -->
                    <div class="tab-pane fade" id="vert-tabs-json" role="tabpanel" aria-labelledby="vert-tabs-json-tab">
                        <pre id="json-tab-content" style="background-color: #f8f9fa; padding: 10px; border-radius: 5px; overflow-x: auto;"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






@endsection
