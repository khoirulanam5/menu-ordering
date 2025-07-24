<aside class="customizer">
    <a href="javascript:void(0)" class="service-panel-toggle" style="padding: 4px 13px">
        <i class="mdi mdi-cart" style="font-size: xx-large;"></i>
        <?php
            if (!empty($keranjang)) {
                echo '<div class="notify"> 
                <span class="heartbit"></span>
                 <span class="point"></span>
                 <span class="text-danger" style="width: 7px;
                 height: 6px;
                 position: absolute;
                 right: 22px;
                 top: -5px;
                 font-size: small;">'.count($keranjang).'</span>
                </div>';
            }
        ?>
    </a>
    <div class="customizer-body">
        <ul class="nav customizer-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#chat" role="tab"
                    aria-controls="chat" aria-selected="false">
                    <i class="mdi mdi-chart fs-6"></i>
                </a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <!-- Tab 2 -->
            <div class="tab-pane fade active show" id="chat" role="tabpanel" aria-labelledby="pills-profile-tab">
                <ul class="mailbox list-style-none mt-3">
                    <li>
                        <div class="message-center chat-scroll position-relative">
                        <?php
                            $profil = $this->db->get_where("pelanggan", array("id_pelanggan" => $this->session->username))->row();
                            if(!empty($keranjang[0]->id_produk)){ 
                                foreach ($keranjang as $key => $value) {
                                    $imgcek = file_exists(FCPATH.'images/'.$value->images) ? $value->images : 'noimages.jpg';
                                    ?>
                                    <a href="<?= base_url('public/home/cart'); ?>"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2"
                                        id='c<?=$value->id_detail_produk?>' data-user-id='<?=$value->id_detail_produk?>'>
                                        <span class="user-img position-relative d-inline-block"> 
                                            <img src="<?= base_url('images/') . $imgcek ?>" alt="user" class="w-100">
                                            <span class="profile-status rounded-circle offline"></span> </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h5 class="message-title mb-0 mt-1"><?=$value->nama_produk?></h5> 
                                            <span class="fs-2 text-nowrap d-block text-muted text-truncate">Qt :<?=$value->jumlah?> Pcs</span> 
                                            <span class="fs-2 text-nowrap d-block text-muted"><?=rp($value->harga_jualpro)?></span>
                                        </div>
                                    </a>
                                    <?php   
                                }
                            }
                        ?>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- End Tab 2 -->
        </div>
    </div>
</aside>
<style>
    .customizer .service-panel-toggle {
        background: #1e88e5;
    }
    .notify .heartbit {
        position: absolute;
        top: -20px;
        right: -4px;
        height: 60px;
        width: 60px;
        z-index: 10;
        border: 5px solid #ffff;
        border-radius: 70px;
    }
</style>
