
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('src/img/wm.jpeg'); ?>">
    <title>WM Garang Asem</title>
    <?php
        $data["title"] = "WM GARANG ASEM";
        $data["menu"]  = $menu;
        // $data["datas"]  = $datas;
    ?>
    <?php $this->load->view("template/Css"); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php
        $this->load->view("template/NavTop", $data);
        $this->load->view("template/LeftMenu");
        $this->load->view($page, $data);
        $this->load->view("template/footer");
        ?>
    </div>
    <?php $this->load->view("template/js"); ?>
</body>
</html>

