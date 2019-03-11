<?php /* /var/www/html/rbcenter/admin/resources/views/admin/layouts/aside.blade.php */ ?>
<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
        <li class="m-menu__item  m-menu__item--active" aria-haspopup="true">
            <a href="" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">Dashboard</span>
										</span>
									</span>
            </a>
        </li>
        <!--START: Websetting-->
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon fa fa-wrench"></i>
                <span class="m-menu__link-text">Web Setting</span>
            </a>
        </li>
        <!--End: Websetting-->


        <!--START: User-->
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon fa fa-users"></i>
                <span class="m-menu__link-text">Users</span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>


                <ul class="m-menu__subnav">
                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="javascript:;" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-plus">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">Add</span>
                        </a>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="javascript:;" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-list">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">List</span>
                        </a>
                    </li>

                </ul>



            </div>
        </li>
        <!--End: User-->




    </ul>
</div>