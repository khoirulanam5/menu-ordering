<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="Aquarium Barokah">
        <meta name="description" content="Aquarium Barokah">
        <meta name="robots" content="noindex,nofollow">
        <title>WM Garang Asem</title>
        <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('src/img/wm.jpeg'); ?>">
        <link href="<?= base_url('src/public/css/magnific-popup.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('src/public/css/style.min.css'); ?>" rel="stylesheet">
    </head>

    <body>
        <?php
        if (isset($notif) == 1) {
            $this->load->view("public/cartnotive");
        } ?>
        <div id="main-wrapper">
            <?php $this->load->view("public/header"); ?>
            <div class="container">
                <?php
                $data["title"] = "WM Garang Asem";
                $data["tabs"] = $tabs;
                $this->load->view("public/tabs", $data);
                ?>
                <div class="container-fluid">
                    <?php $this->load->view($page, $data); ?>
                </div>
            </div>
        </div>
        <script src="<?= base_url() ?>/src/public/js/jquery.min.js"></script>
        <script src="<?= base_url() ?>/src/public/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url() ?>/src/public/js/app.min.js"></script>
        <script src="<?= base_url() ?>/src/public/js/app.init.js"></script>
        <script src="<?= base_url() ?>/src/public/js/app-style-switcher.js"></script>
        <script src="<?= base_url() ?>/src/public/js/perfect-scrollbar.jquery.min.js"></script>
        <script src="<?= base_url() ?>/src/public/js/sparkline.js"></script>
        <script src="<?= base_url() ?>/src/public/js/waves.js"></script>
        <script src="<?= base_url() ?>/src/public/js/feather.min.js"></script>
        <script src="<?= base_url() ?>/src/public/js/custom.min.js"></script>
        <script src="<?= base_url() ?>/src/public/js/jquery.magnific-popup.min.js"></script>
        <script src="<?= base_url() ?>/src/public/js/meg.init.js"></script>
    </body>
    <script>
        $("form").attr('autocomplete', 'off');
    </script>
    <style>
        .form-control {
            border: 1px solidrgb(8, 8, 8) !important;
        }
    </style>
</html>