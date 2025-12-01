<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?></title>
  <link rel="shortcut icon" type="image/icon" href="<?= base_url('/src/img/wm.jpeg'); ?>"/>
  <link rel="stylesheet" href="<?= base_url('src/css/styles.css'); ?>">
  <?php $this->load->view("template/Css"); ?>
  <style>
    body {
      background-color: #ffffff;
    }

    .login-box {
      width: 480px; /* Perbesar ukuran card */
      margin: 60px auto;
    }

    .card, .card-header, .card-body {
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    .app-title {
      font-weight: bold;
      font-size: 20px;
      text-align: center;
      color: #333;
      margin-top: 10px;
    }

    .app-address {
      font-size: 16px;
      text-align: center;
      color: #666;
      margin-bottom: 20px;
    }

    hr {
      border-top: 2px solid #ddd;
      margin: 20px 0;
    }

    .form-control {
      height: 48px;
      font-size: 16px;
    }

    .input-group-text {
      font-size: 18px;
    }

    .btn {
      height: 48px;
      font-size: 18px;
      background-color:rgb(0, 0, 0);
      color: white;
      transition: 0.3s;
    }

    .btn:hover {
      background-color:rgb(0, 0, 0);
    }

    .input-group {
      margin-bottom: 20px;
    }
  </style>
</head>

<body class="hold-transition login-page">
  <div class="login-box" id="loginForm">
    <div class="card card-outline">
      <div class="card-body text-center">
      <img src="<?= base_url('/src/img/wm.jpeg'); ?>" alt="Logo" width="150" style="margin-bottom: 10px;">
        <div class="app-title">WM GARANG ASEM PODO ROSO</div>
        <div class="app-address">Jl. Patimura, Karangwatu, Loram Kulon, Kec. Jati, Kab. Kudus, Jawa Tengah</div>
        <hr>
        <form action="<?= base_url('login/cek'); ?>" method="post">
          <div class="input-group">
            <input type="text" class="form-control" name="username" autocomplete="off" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group">
            <input type="password" class="form-control" name="password" autocomplete="off" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-default btn-block">Masuk</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
