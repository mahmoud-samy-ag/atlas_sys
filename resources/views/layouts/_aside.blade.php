  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Atlas Pharma</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/avatar6.webp')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <span class="text-white">{{ Auth::user()->name }}</span>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            @if (auth()->user()->hasRole('sales_manager'))
              <li class="nav-item">
                  <a href="{{ route('home') }}" class="nav-link">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p> Dashboard</p>
                  </a>
              </li>
            @else

              <li class="nav-item">
                  <a href="{{ route('home') }}" class="nav-link">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p> Dashboard</p>
                  </a>
              </li>


              @if (!(auth()->user()->hasRole('product_specialist')))
                <li class="nav-item">
                  <a href="{{ route('users.index') }}" class="nav-link">
                      <i class="fas fa-users"></i>
                      <p> Users</p>
                  </a>
                </li>
              @endif

              @if (auth()->user()->hasRole('ceo') || auth()->user()->hasRole('general_manager'))
                <li class="nav-item">
                  <a href="{{ route('areas.index') }}" class="nav-link">
                      <i class="fas fa-chart-area"></i>
                      <p> Areas </p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('products.index') }}" class="nav-link">
                      <i class="fas fa-boxes"></i>
                      <p> Products </p>
                  </a>
                </li>
              @endif

              

              @if (auth()->user()->hasRole('product_specialist') || auth()->user()->hasRole('distrect_manager'))
                <li class="nav-item">
                  <a href="{{ route('locations.index') }}" class="nav-link">
                      <i class="fas fa-address-card"></i>
                      <p> Address </p>
                  </a>
                </li>
              @endif

              

              <li class="nav-item">
                <a href="{{ route('doctors.index') }}" class="nav-link">
                    <i class="fas fa-user-nurse"></i>
                    <p> Customers </p>
                </a>
              </li>

              

              <li class="nav-item">
                  <a href="{{ route('weeklyPlans.index') }}" class="nav-link">
                      <i class="fas fa-calendar-week"></i>
                      <p> Weekly Plans</p>
                  </a>
              </li>



              <li class="nav-item">
                <a href="{{ route('dailyReports.index') }}" class="nav-link">
                    <i class="fas fa-clock"></i>
                    <p> Daily Reports</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{ route('coverages.index') }}" class="nav-link">
                    <i class="fas fa-star-of-life"></i>
                    <p> Coverages</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('marketFeedbacks.index') }}" class="nav-link">
                    <i class="fas fa-comments"></i>
                    <p> Market FeedBack</p>
                </a>
              </li>
            @endif

            <li class="nav-item">

                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p> {{ __('Logout') }}</p>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
