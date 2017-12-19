<nav class="navbar has-shadow" >
  <div class="container is-fluid">
    <div class="navbar-brand">
      <a class="navbar-item is-paddingless brand-item" href="{{route('home')}}">
        <img src="{{asset('images/rocmnd.png')}}" alt="Rocmnd Logo">
      </a>

      @if (Request::segment(1) == "manage")
        <a class="navbar-item is-hidden-desktop" id="admin-slideout-button">
          <span class="icon">
            <i class="fa fa-arrow-circle-right"></i>
          </span>
        </a>
      @endif

      <button class="button navbar-burger">
       <span></span>
       <span></span>
       <span></span>
     </button>
    </div>
    <div class="navbar-menu">
      <div class="navbar-start">
        @auth
          @role('serveradministrator|payrollmanager|director|assistantdirector|administrator')
            {{-- <a href="{{route('manage.dashboard')}}" class="navbar-item"> --}}
            <a href="#" class="navbar-item">
              Dashboard
            </a>
          @endrole
        @endauth
      </div> <!-- end of .navbar-start -->


      <div class="navbar-end nav-menu" style="overflow: visible">

        @guest
          <a href="{{route('login')}}" class="navbar-item is-tab">Login</a>
          {{-- <a href="{{route('register')}}" class="navbar-item is-tab">Join Rocmnd</a> --}}
        @else
          {{-- @if (Auth::user()->isClockedIn())        
              <form class="navbar-item" role="form" method="POST" action="{{ route('clockout') }}">
                  {{ csrf_field() }}           
                  <input class="button is-primary" type="submit" value="Clock Out">
              </form>
          @else    --}}     
              {{-- <form class="navbar-item" role="form" method="POST" action="{{ route('timesheets.store') }}">
                {{ csrf_field() }}
                <div class="field has-addons"> 
                  <div class="control">
                    <div class="select">
                      <select name="reason">
                        <option value="Scheduled">Scheduled</option>
                        <option value="Called in">Called in</option>
                        <option value="On call">On call</option>
                        <option value="Meeting">Meeting</option>
                        <option value="DR. Appointment">Dr. App</option>
                      </select>
                    </div>
                  </div> 
                  <div class="control">         
                    <input class="button is-primary" type="submit" value="Clock In">
                  </div>
                </div>
              </form>                    
          @endif --}}
          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">Welcome {{Auth::user()->getNameOrUsername()}}</a>
            <div class="navbar-dropdown is-right" >
              <a href="#" class="navbar-item">
                <span class="icon">
                  <i class="fa fa-fw fa-user-circle-o m-r-5"></i>
                </span>Profile
              </a>

              <a href="#" class="navbar-item">
                <span class="icon">
                  <i class="fa fa-fw fa-bell m-r-5"></i>
                </span>Notifications
              </a>
              @auth
                @role('serveradministrator|payrollmanager|director|assistantdirector|administrator')
                  {{-- <a href="{{route('manage.dashboard')}}" class="navbar-item"> --}}
                  <a href="#" class="navbar-item">
                    <span class="icon">
                      <i class="fa fa-fw fa-cog m-r-5"></i>
                    </span>Manage
                  </a>          
                @endrole
              @endauth              
              <hr class="navbar-divider">
              <a href="{{route('logout')}}" class="navbar-item" onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                <span class="icon">
                  <i class="fa fa-fw fa-sign-out m-r-5"></i>
                </span>
                Logout
              </a>
              @include('_includes.forms.logout')
            </div>
          </div>
        @endguest
      </div>
    </div>

  </div>
</nav>