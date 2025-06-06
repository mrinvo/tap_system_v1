  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="/fav.svg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Tap ERP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/dash/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('profile.edit') }}" class="d-block">{{ @Auth::user()->name; }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-header">General Operations</li>

{{-- Checkout Start --}}
        <li class="nav-item">
            <a href="{{ route('checkout.view') }}" class="nav-link ">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Checkout
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('checkout.view') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Checkout</p>
                </a>
              </li>


            </ul>
          </li>
          {{-- checkout end --}}
          <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Businesses
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('business.create') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Business</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('business.retrieve') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Retrieve a Business</p>
                </a>
              </li>

            </ul>
          </li>

                    {{-- Lead Start --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link ">
                          <i class="nav-icon fas fa-copy"></i>
                          <p>
                            Leads
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right"></span>
                          </p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="{{ route('lead.create') }}" class="nav-link active">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Create Lead</p>
                            </a>
                          </li>


                        </ul>
                      </li>
                      {{-- Lead End --}}

          <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Merchants
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{ route('merchant.retrieve') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Retrieve a Merchant</p>
                </a>
              </li>

            </ul>
          </li>

          <li class="nav-header">Bulk Operations</li>
          {{-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Platforms
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/layout/top-nav.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Platform</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Retrieve a Platform</p>
                </a>
              </li>

            </ul>
          </li> --}}

          <li class="nav-header">Internal Operations</li>

              <li class="nav-item">
                <a href="{{ route('pt.retrieve') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PT Details</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link ">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Apple Pay
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right"></span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('ap.whitelist') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Whitelist</p>
                    </a>
                  </li>
                  {{-- <li class="nav-item">
                    <a href="{{ route('ap.whitelist.retrieve') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Retrieve Whitelist</p>
                    </a>
                  </li> --}}

                </ul>
              </li>



        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
