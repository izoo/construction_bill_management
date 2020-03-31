<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <div>
            <p class="app-sidebar__user-name">EASTLINE SITE</p>
            <p class="app-sidebar__user-designation">USER DASHBOARD</p>
        </div>
    </div>
    <ul class="app-menu">
        <li>
            <a class="app-menu__item active" href="#"><i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-database"></i>
                <span class="app-menu__label">Bills</span>
  
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
     
                <li>
                    <a class="treeview-item" href="#" data-id="list-bills" rel="noopener noreferrer"><i class="icon fa fa-circle-o"></i>New Bill</a>
                </li>
               
                
               
            </ul>
        </li>
     
 
       
        <li class="treeview">
            <a class="app-menu__item" href="{{route('normal.logout') }}" ><i class="app-menu__icon fa fa-sign-out"></i>
                <span class="app-menu__label">Logout</span>
              
            </a>
            
        </li>
        
    </ul>
</aside>