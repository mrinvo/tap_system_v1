@extends('dash.layouts.index')

@section('content')

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Retrieve Payment Types</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form id="dataForm" method="POST">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="ptSecretKey">Enter Secret Key to Retrieve Payment Type Deatails</label>
            <input name="ptSecretKey" type="text" class="form-control" id="ptSecretKey" placeholder="Enter Secert Key">
          </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            {{-- <input type="submit" value="submit"> --}}
          <button type="button" id="retrieveButton" class="btn btn-primary">Retrieve</button>
        </div>
      </form>
    </div>
    <!-- /.card -->



</div>

<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">
        <i class="fas fa-edit"></i>
        Payment and Currency Details
      </h3>
    </div>
    <div id="ptOverlayDiv" style="display: none;" class="overlay">
      <i class="fas fa-3x fa-sync-alt fa-spin"></i>
      <div class="text-bold pt-2"></div>
    </div>

    <div class="card-body">
      <h4>Information</h4>
      <div class="row">
        <div class="col-5 col-sm-3">
          <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="vert-tabs-payment-methods-tab" data-toggle="pill" href="#vert-tabs-payment-methods" role="tab" aria-controls="vert-tabs-payment-methods" aria-selected="true">Payment Methods</a>
            <a class="nav-link" id="vert-tabs-currencies-tab" data-toggle="pill" href="#vert-tabs-currencies" role="tab" aria-controls="vert-tabs-currencies" aria-selected="false">Currencies</a>
            <a class="nav-link" id="vert-tabs-json-tab" data-toggle="pill" href="#vert-tabs-json" role="tab" aria-controls="vert-tabs-json" aria-selected="false">Full JSON</a>

          </div>
        </div>
        <div class="col-7 col-sm-9">
          <div class="tab-content" id="vert-tabs-tabContent">
            <!-- Payment Methods Tab -->
            <div class="tab-pane text-left fade show active" id="vert-tabs-payment-methods" role="tabpanel" aria-labelledby="vert-tabs-payment-methods-tab"></div>
            <!-- Currencies Tab -->
            <div class="tab-pane fade" id="vert-tabs-currencies" role="tabpanel" aria-labelledby="vert-tabs-currencies-tab"></div>
            {{-- Full Json --}}
            <div class="tab-pane fade" id="vert-tabs-json" role="tabpanel" aria-labelledby="vert-tabs-json-tab">
                <pre id="json-tab-content" style="background-color: #f8f9fa; padding: 10px; border-radius: 5px; overflow-x: auto;"></pre>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>




@endsection
