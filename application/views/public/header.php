<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item d-none d-md-block search-box">
                    <form class="app-search">
                        <input type="text" class="form-control" placeholder="Search & enter">
                        <a class="srh-btn"><i class="ti-close"></i></a>
                    </form>
                </li>
            </ul>

            <style>
               .topbar, .topbar .top-navbar,.topbar .navbar-collapse {
                    height: 86px;
                }

                @media only screen and (max-width: 768px) {
                    .nav-toggler {
                        display: none !important;
                    }

                    a.navbar-brand {
                        float: left
                    }

                    a.topbartoggler {
                        float: right
                    }
                }

                .topbar .user-dd {
                    width:450px;
                }
                .dropdown-menu {
                    margin: -3.875rem 0 0;
                    right : 45px;
                }

                .btn {
                    background-image: linear-gradient(180deg, black 50%, transparent 50%);
                    background-size: 200% 200%;
                    background-position: bottom;
                    transition: background-position 0.3s;
                }
                .btn:hover {
                    background-position: top;
                    color: white;
                }
            </style>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <?php
                    if ($this->session->level != "pelanggan") {
                        ?>
                        <a class="nav-link waves-effect waves-dark text-white" href="#" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" style="font-size: x-large;">
                            <i class="fas fa-user-plus"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end user-dd animated flipInY">
                            <div class="d-flex no-block align-items-center p-3 bg-info text-white mb-2">
                                <div class="">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="ms-2">
                                    <h4 class="mb-0 text-white btn-sm">Daftar Akun</h4>
                                </div>
                            </div>
                            <div class="dropdown-divider">
                            </div>
                            <style>
                                .mb-3 {
                                    margin-bottom: 10px !important;
                                }
                            </style>
                            <div style="overflow-y: scroll;" class="daftars">
                                <?php $this->load->view('public/pendaftaran');?>
                                <br>
                            </div>
                            <script>
                                // Get the height of the phone screen
                                var phoneHeight = window.innerHeight;
                                // Set the minimum height of the main content
                                document.querySelector('.daftars').style.height = phoneHeight - 150 + 'px';
                            </script>
                        <div class="dropdown-divider"></div>
                        <?php
                    }
                    ?>
                </li>

                <li class="nav-item dropdown">
                    <?php
                    if ($this->session->level == "pelanggan") {
                        $this->session->flashdata("message");
                        $profil = $this->db->get_where("pelanggan", array("id_pelanggan" => $this->session->username))->row();
                        ?>
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="<?php
                            $img = (!empty($profil->images) ? $profil->images : "user-solid.svg");
                            echo base_url('images/') . $img;
                            ?>" alt="user" width="30" class="profile-pic rounded-circle" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-end user-dd animated flipInY">
                            <div class="d-flex no-block align-items-center p-3 bg-info text-white mb-2">
                                <div class="">
                                    <img src="<?= base_url('images/'); ?><?=$img?>" alt="user"
                                        class="rounded-circle" width="60">
                                    </div>
                                <div class="ms-2">
                                    <h4 class="mb-0 text-white"><?= $profil->nama_pelanggan ?></h4>
                                    <p class=" mb-0"><?= $profil->email ?></p>
                                    <a href="<?= base_url('public/home/editprofil'); ?>" class="btn btn-danger btn-sm">Edit Profil</a>
                                </div>
                            </div>
                            <a class="dropdown-item" href="<?= base_url('public/home/product_order'); ?>">
                                <i class="fas fa-shopping-bag feather-sm text-danger me-1 ms-1"></i>Semua Pesanan</a>
                            <a class="dropdown-item" href="<?= base_url('login/logout') ?>"><i data-feather="log-out"
                                class="feather-sm text-danger me-1 ms-1"></i> Logout</a>
                        </div>
                        <?php
                    } else {
                        echo '<a class="nav-link waves-effect waves-dark text-white" href="' . base_url('login') . '"><i data-feather="log-in" class="feather-sm text-white me-1 ms-1"></i> Login</a>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
<style>
    @media (max-width: 575.98px){
        .topbar .top-navbar .dropdown-menu {
            position: absolute;
            left: 0px;
            width: 100%;
        }
    }
</style>