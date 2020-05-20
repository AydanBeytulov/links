<!-- begin: Header Menu -->
<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
<div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
        <ul class="kt-menu__nav ">
            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="{{ route('admin_users') }}" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Users</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_users') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-architecture-and-city"></i><span class="kt-menu__link-text">List users</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_users_add') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-crisp-icons"></i><span class="kt-menu__link-text">Add user</span></a></li>
                    </ul>
                </div>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="{{ route('admin_urls') }}" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">URLs</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_urls') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-architecture-and-city"></i><span class="kt-menu__link-text">List urls</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_urls_add') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-crisp-icons"></i><span class="kt-menu__link-text">Add url</span></a></li>
                    </ul>
                </div>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="{{ route('admin_categories') }}" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Categories</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_categories') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-architecture-and-city"></i><span class="kt-menu__link-text">List categories</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_categories_add') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-crisp-icons"></i><span class="kt-menu__link-text">Add category</span></a></li>
                    </ul>
                </div>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="{{ route('admin_services') }}" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Services</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_services') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-architecture-and-city"></i><span class="kt-menu__link-text">List services</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_services_add') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-crisp-icons"></i><span class="kt-menu__link-text">Add service</span></a></li>
                    </ul>
                </div>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="{{ route('admin_orders') }}" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Orders</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_orders') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-architecture-and-city"></i><span class="kt-menu__link-text">List orders</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_orders_add') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-crisp-icons"></i><span class="kt-menu__link-text">Add orders</span></a></li>
                    </ul>
                </div>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="{{ route('admin_rotators') }}" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Rotators</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_rotators') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-architecture-and-city"></i><span class="kt-menu__link-text">List rotators</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_rotators_add') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-crisp-icons"></i><span class="kt-menu__link-text">Add rotator</span></a></li>
                    </ul>
                </div>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="{{ route('admin_blocks') }}" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">URL Blocks</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_blocks') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-architecture-and-city"></i><span class="kt-menu__link-text">List URL blocks</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_blocks_add') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-crisp-icons"></i><span class="kt-menu__link-text">Add URL block</span></a></li>
                    </ul>
                </div>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="{{ route('admin_ip_blocks') }}" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">IP Blocks</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_ip_blocks') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-architecture-and-city"></i><span class="kt-menu__link-text">List IP blocks</span></a></li>
                        <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('admin_ip_blocks_add') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-crisp-icons"></i><span class="kt-menu__link-text">Add IP block</span></a></li>
                    </ul>
                </div>
            </li>

            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" ><a href="{{ route('admin_logs') }}" class="kt-menu__link "><span class="kt-menu__link-text">Logs</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>

            </li>

            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" ><a href="{{ route('admin_settings_edit') }}" class="kt-menu__link "><span class="kt-menu__link-text">Settings</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>

            </li>

      </ul>
    </div>
</div>
<!-- end: Header Menu -->
