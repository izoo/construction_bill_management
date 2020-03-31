<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <!-- <div class="app-sidebar__user">
        <div>
            <p class="app-sidebar__user-name">EASTLINE SITE</p>
            <p class="app-sidebar__user-designation">DASHBOARD</p>
            <section class="full-top">
			</section>
        </div>
    </div> -->
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
                    <a class="treeview-item" href="#" data-id="list-bills" rel="noopener noreferrer"><i class="icon fa fa-circle-o"></i> Listed Bills</a>
                </li>
                <li>
                    <a class="treeview-item" href="#" data-id="pay-bills" rel="noopener noreferrer"><i class="icon fa fa-circle-o"></i> Pay Bills</a>
                </li>
                <li>
                    <a class="treeview-item" href="#" data-id="paid-bills" rel="noopener noreferrer"><i class="icon fa fa-circle-o"></i>Payments</a>
                </li>
                
               
            </ul>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i>
                <span class="app-menu__label">Suppliers</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" data-id="list-suppliers" href="#"><i class="icon fa fa-circle-o"></i> Listed Suppliers</a>
                </li>
             
               
            </ul>
        </li>
       
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa  fa-university"></i>
                <span class="app-menu__label">Materials</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" data-id="list-materials" href="#"><i class="icon fa fa-circle-o"></i> Listed Materials</a>
                </li>
             
               
            </ul>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa  fa-user"></i>
                <span class="app-menu__label">Profile</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" data-id="update-pass" href="#"><i class="icon fa fa-circle-o"></i>Change Password</a>
                </li>
             
               
            </ul>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa  fa-users"></i>
                <span class="app-menu__label">Users</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" data-id="listed-users" href="#"><i class="icon fa fa-circle-o"></i>Listed Users</a>
                </li>
             
               
            </ul>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa  fa-tasks"></i>
                <span class="app-menu__label">Expenses</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" data-id="list-expenses" href="#"><i class="icon fa fa-circle-o"></i>Listed Bill Expenses</a>
                </li>
                <li>
                    <a class="treeview-item" data-id="list-expenses-new" href="#"><i class="icon fa fa-circle-o"></i>Expenses</a>
                </li>
               
            </ul>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa  fa-tasks"></i>
                <span class="app-menu__label">Sites</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" data-id="listed-sites" href="#"><i class="icon fa fa-circle-o"></i>Listed Sites</a>
                </li>
             
               
            </ul>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa  fa-gear"></i>
                <span class="app-menu__label">Settings</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" data-id="list-passwords" href="#"><i class="icon fa fa-circle-o"></i>Passwords Settings</a>
                </li>
                <li>
                    <a class="treeview-item" data-id="list-roles" href="#"><i class="icon fa fa-circle-o"></i>Roles</a>
                </li>
               
            </ul>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="{{route('admin.logout') }}" ><i class="app-menu__icon fa fa-sign-out"></i>
                <span class="app-menu__label">Logout</span>
              
            </a>
            
        </li>
        
    </ul>
</aside>