<header class="app-header">
    <a class="app-header__logo" href="#">Eastline <span>
     &nbsp &nbsp <img src="{{asset('images/maurer-1020143_640.jpg')}}" class="img-circle" style="height:70%;width:20%;" alt="Company Logo Goes Here">
 </span></a>
   
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <ul class="app-nav">
      <!-- Full Screen Toggle -->
      <li class="dropdown">
      <a id="toggle" class="app-nav__item fullscreen_button">
      <i class="fa fa-arrows-alt fa-lg text-white"></i>
</a>
      </li>
      <!-- End Full Screen Toggle -->
         <!--Notification Menu-->
         <li class="dropdown">
          <a
            class="app-nav__item"
            href="#"
            data-toggle="dropdown"
            aria-label="Show notifications"
            ><i class="fa fa-bell-o fa-lg">
            <span id="new-notes" class="badge badge-light"></span>
            </i></a>
          <ul class="app-notification dropdown-menu dropdown-menu-right">
            <li class="app-notification__title">
              You have <b id="note-count"></b> new notifications.
            </li>
            <div id="latest-notifications" class="app-notification__content">
             
             

             
              
            </div>
            <li class="app-notification__footer">
              <a href="#">See all notifications.</a>
            </li>
          </ul>
        </li>
        <li class="dropdown">
            <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
               
                <li>
                    <a class="dropdown-item" href="{{route('admin.logout') }}"><i class="fa fa-sign-out fa-lg"></i> Logout</a>
                </li>
            </ul>
        </li>
    </ul>
</header>