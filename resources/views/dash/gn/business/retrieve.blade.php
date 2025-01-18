@extends('dash.layouts.index')

@section('content')

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Retrieve Business</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form id="dataForm" method="POST">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="businessId">Write Business ID to Retrieve Business</label>
            <input name="businessId" type="text" class="form-control" id="businessId" placeholder="Enter Business ID">
          </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            {{-- <input type="submit" value="submit"> --}}
          <button type="button" onclick="retrieveBusiness()" id="retrieveBusinessButton" class="btn btn-primary">Retrieve</button>
        </div>
      </form>
    </div>
    <!-- /.card -->



  </div>

  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">
        <i class="fas fa-edit"></i>
        Business Details
      </h3>
    </div>
    <div id="overlayDiv"  class="overlay hidden-div"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2"></div></div>

    <div class="card-body">
      <h4>Business Information</h4>
      <div class="row">
        <div class="col-5 col-sm-3">
          <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="vert-tabs-general-tab" data-toggle="pill" href="#vert-tabs-general" role="tab" aria-controls="vert-tabs-general" aria-selected="true">General</a>
            <a class="nav-link" id="vert-tabs-brands-tab" data-toggle="pill" href="#vert-tabs-brands" role="tab" aria-controls="vert-tabs-brands" aria-selected="false">Brands</a>
            <a class="nav-link" id="vert-tabs-user-tab" data-toggle="pill" href="#vert-tabs-user" role="tab" aria-controls="vert-tabs-user" aria-selected="false">User</a>
            <a class="nav-link" id="vert-tabs-entities-tab" data-toggle="pill" href="#vert-tabs-entities" role="tab" aria-controls="vert-tabs-entities" aria-selected="false">Entities</a>
            <a class="nav-link" id="vert-tabs-json-tab" data-toggle="pill" href="#vert-tabs-json" role="tab" aria-controls="vert-tabs-json" aria-selected="false">Full JSON</a>

          </div>
        </div>
        <div class="col-7 col-sm-9">
          <div class="tab-content" id="vert-tabs-tabContent">
            <!-- General Tab -->
            <div class="tab-pane text-left fade show active" id="vert-tabs-general" role="tabpanel" aria-labelledby="vert-tabs-general-tab"></div>
            <!-- Brands Tab -->
            <div class="tab-pane fade" id="vert-tabs-brands" role="tabpanel" aria-labelledby="vert-tabs-brands-tab"></div>
            <!-- User Tab -->
            <div class="tab-pane fade" id="vert-tabs-user" role="tabpanel" aria-labelledby="vert-tabs-user-tab"></div>
            <!-- Entities Tab -->
            <div class="tab-pane fade" id="vert-tabs-entities" role="tabpanel" aria-labelledby="vert-tabs-entities-tab"></div>

            {{-- Full json Tab --}}
            <div class="tab-pane fade" id="vert-tabs-json" role="tabpanel" aria-labelledby="vert-tabs-json-tab">
                <pre id="json-tab-content" style="background-color: #f8f9fa; padding: 10px; border-radius: 5px; overflow-x: auto;"></pre>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


@endsection
