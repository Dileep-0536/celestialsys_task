<!-- Sidebar Menu -->
         <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-initial" data-widget="treeview" 
          role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->   
         <!--Admin sidebar menu -->
         @auth
         @if(Auth::user()->name  == "admin")
         <li class="nav-item">
        <a href="{{url('companies')}}" class="nav-link">
        <p>Manage Companies</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="{{url('employees')}}" class="nav-link">
         <p>Manage Employees</p>
        </a>
       </li>
       <!-- end Admin sidebar menu -->
      @endif
      @endauth
</ul>