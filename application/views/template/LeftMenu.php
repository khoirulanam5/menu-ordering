<aside class="main-sidebar sidebar-dark elevation-4" style="background-color: white;">
    <a href="#" class="brand-link d-flex flex-column align-items-center py-3">
        <!-- Logo -->
        <img src="<?= base_url('/src/img/wm.jpeg'); ?>" alt="Logo Garang Asem" style="width: 50px; height: auto;">

        <!-- Nama Usaha -->
        <div class="text-center mt-2">
            <span style="font-weight: bold; font-size: 16px; color: #322f20;">WM GARANG ASEM PODO ROSO</span>
        </div>

    </a>
    <!-- Foto Profil dan Level -->
    <div class="d-flex align-items-center px-3 py-2">
        <img src="<?= base_url('/src/img/default.png'); ?>" alt="User" class="img-circle elevation-3" style="opacity: .8; width: 40px; height: 40px;">
        <div class="ml-2" style="font-weight: bold; font-size: 16px; color: #322f20;">
            <?= $this->session->level ?>
        </div>
    </div>
    <hr style="width: 90%; border-top: 1px solid black;">

    <div class="sidebar">
        <!-- Navigasi Sidebar -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">
                    <a href="<?= base_url('dashboard'); ?>" style="color: black;">
                        <h3>Dashboard</h3>
                    </a>
                </li>
                <?php
                if (!empty($this->session->level)) {
                    $menus = json_decode(file_get_contents(base_url('sources/custommenu.json')));
                    if ($this->session->level == 'pelanggan') {
                        redirect('login/logout');
                    }
                    foreach ($menus->{$this->session->level} as $key => $value) {
                        if (!empty($value->menusub)) {
                ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon far fa-plus-square"></i>
                                    <p><?= $value->menu ?><i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <?php foreach ($value->menusub as $subs) : ?>
                                        <li class="nav-item">
                                            <a href="<?= base_url(strtolower($value->link . "/" . $subs->link_sub)) ?>" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p><?= $subs->menu_sub ?></p>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li class="nav-item">
                                <a href="<?= base_url($value->menu . "/" . $value->link) ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p><?= $value->menu ?></p>
                                </a>
                            </li>
                <?php
                        }
                    }
                }
                ?>
            </ul>
        </nav>
    </div>
</aside>
