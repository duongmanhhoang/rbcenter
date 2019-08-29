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
                <span class="m-menu__link-text">Quản lí người dùng</span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>


                <ul class="m-menu__subnav">
                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?php echo e(route('admin.users.create')); ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-plus">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">Thêm</span>
                        </a>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-list">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">Danh sách</span>
                        </a>
                    </li>

                </ul>



            </div>
        </li>
        <!--End: User-->


        <!--START: Classes-->
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon fa  fa-university"></i>
                <span class="m-menu__link-text">Quản lí lớp học</span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>


                <ul class="m-menu__subnav">
                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?php echo e(route('admin.classes.create')); ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-plus">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">Thêm</span>
                        </a>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?php echo e(route('admin.classes.index')); ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-list">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">Danh sách</span>
                        </a>
                    </li>

                </ul>



            </div>
        </li>
        <!--End: Classes-->

        <!--START: Products-->
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon fa fa-cubes"></i>
                <span class="m-menu__link-text">Quản lí sản phẩm</span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>


                <ul class="m-menu__subnav">
                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?php echo e(route('admin.products.create')); ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-plus">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">Thêm</span>
                        </a>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-list">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">Danh sách</span>
                        </a>
                    </li>

                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?php echo e(route('admin.products.categories.index')); ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-list-alt">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">Danh mục sản phẩm</span>
                        </a>
                    </li>

                </ul>



            </div>
        </li>
        <!--End: Products-->

        <!--START: Posts-->
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon fa fa-book"></i>
                <span class="m-menu__link-text">Quản lí bài viết</span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>


                <ul class="m-menu__subnav">
                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?php echo e(route('admin.posts.create')); ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-plus">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">Thêm</span>
                        </a>
                    </li>
                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?php echo e(route('admin.posts.index')); ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-list">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">Danh sách</span>
                        </a>
                    </li>

                    <li class="m-menu__item " aria-haspopup="true">
                        <a href="<?php echo e(route('admin.posts.categories.index')); ?>" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-list-alt">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">Danh mục bài viết</span>
                        </a>
                    </li>

                </ul>



            </div>
        </li>
        <!--End: Posts-->



    </ul>
</div><?php /**PATH /var/www/html/rbcenter/admin/resources/views/admin/layouts/aside.blade.php ENDPATH**/ ?>