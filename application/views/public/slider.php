<div class="col-lg-6 col-xl-3">
    <div style="padding:50px" class="text-center">
        <h2>WM Garang Asem</h2>
        <p style="font-size:12px">WM Garang Asem Podo Roso menyediakan aneka menu khas tradisional Jawa, khususnya garang asem yang diolah dengan resep turun-temurun dan cita rasa autentik. Kami melayani penjualan untuk makan di tempat, bawa pulang, maupun dalam bentuk frozen food. Setiap hidangan kami dibuat dengan bahan berkualitas dan diolah secara higienis, cocok untuk dinikmati setiap hari maupun acara khusus.</p>
        <p style="font-size:13px">Alamat : Jl. Patimura, Karangwatu, Loram Kulon, Kec. Jati, Kab. Kudus, Jawa Tengah</p>
    </div>
    <div class="modal fade" id="bs-example-modal-md" tabindex="-1" aria-labelledby="bs-example-modal-md"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center bg-info">
                    <h4 class="modal-title text-center w-100 text-white" id="myLargeModalLabel">Buat Akun</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php $this->load->view("public/pendaftaran");?>
                </div>
                <div class="modal-footer">
                 </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6 col-xl-3">
    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <?php
            foreach ($datas as $key => $value) {
                $active = ($key == 0 ? 'class="active"' : '');
                echo '<li data-bs-target="#carouselExampleDark" data-bs-slide-to="0" ' . $active . '></li>';
            }
            ?>
        </ol>
        <div class="carousel-inner">
            <?php
            foreach ($datas as $key => $value) {
                $imgcek = file_exists(FCPATH.'images/'.$value->images) ? $value->images : 'noimages.jpg';
                $active = ($key == 0 ? 'active' : '');
                echo '<div class="carousel-item ' . $active . '" data-bs-interval="4000">
                            <img style="object-fit: contain;height: 300px;" src="' . base_url("images/") . $imgcek. '" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block text-center" style="position: absolute;
                            bottom: 0px;left:0px; width:100%;">
                                <p>'.$value->nama_produk.'</p>
                            </div>
                        </div>';
                    }
            ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleDark" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleDark" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>
</div>

<div class="col-md-12 mt-3 mb-3">
    <form method="get" action="<?=base_url()?>public/home"> 
        <div class="input-group">
            <input type="text" class="form-control" name="cari_key" aria-label="Text input with checkbox">
            <button class="btn btn-info text-white font-weight-medium" type="submit">Cari Produk</button>
        </div>
    </form>
</div>