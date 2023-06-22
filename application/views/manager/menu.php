
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color:lightseagreen" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <img src="<?= base_url()?>assets/img/logo.png" style="width:100%" alt="Indosar">
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <?php if($this->uri->segment(1)=="home"){?>
                <li class="nav-item active">
                <?php }else{ ?>
                    <li class="nav-item">
                <?php } ?>
                <a class="nav-link" href="<?= base_url("home") ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Home</span></a>
            </li>

            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Report
            </div>

            <!-- Nav Item - Charts -->
            <?php if($this->uri->segment(2)=="reportperkode"){?>
                <li class="nav-item active">
                <?php }else{ ?>
                    <li class="nav-item">
                <?php } ?>
                <a class="nav-link" href="<?= base_url("report/reportperkode")?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Per Kode Barang</span></a>
            </li>
            <!-- Nav Item - Charts -->
            <?php if($this->uri->segment(2)=="reportpergrup"){?>
                <li class="nav-item active">
                <?php }else{ ?>
                    <li class="nav-item">
                <?php } ?>
                <a class="nav-link" href="<?= base_url("report/reportpergrup")?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Per Grup</span></a>
            </li>
            <!-- Nav Item - Charts -->
            <?php if($this->uri->segment(2)=="reportall"){?>
                <li class="nav-item active">
                <?php }else{ ?>
                    <li class="nav-item">
                <?php } ?>
                <a class="nav-link" href="<?= base_url("report/reportall")?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Keseluruhan</span></a>
            </li>
            <?php if($this->uri->segment(2)=="buffer_stock"){?>
                <li class="nav-item active">
                <?php }else{ ?>
                    <li class="nav-item">
                <?php } ?>
                <a class="nav-link" href="<?=base_url()?>ppic/buffer_stock">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Buffer Stock</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">
                    
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    
                    <h3>Gudang Kemas</h3>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                    
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                    
                        <div class="topbar-divider d-none d-sm-block"></div>
                    
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->session->userdata("username");?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?=base_url()?>assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url("setting")?>">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    
                    </ul>
                    
                    </nav>
                    <!-- End of Topbar -->