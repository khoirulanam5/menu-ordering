<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center col-md-4 mx-auto editprof">
                    <form action="<?= base_url('users/edit'); ?>" method="post" style="margin: 20px;" class="mx-auto" enctype="multipart/form-data">
                        <?php
                        $img = (empty($detail->images) ? 'user-solid.svg': $detail->images); 
                        ?>
                        <div class="col-md-12">
                            <center>
                                <img src="<?= base_url('images/'); ?><?=$img?>" width="100px" style="padding:10px" class="mx-auto">
                            </center>
                            <small class="text-white">Ganti Foto :</small>
                            <div class="input-group mb-3">
                            <input type="file" class="form-control  btn-sm" name="gambar" accept=".jpg, .jpeg, .png" >
                            <input type="hidden" class="form-control  btn-sm" name="gambar_old" value="<?=$detail->images?>" >
                            </div>
                        </div>
                       <div class="input-group mb-3">
                            <span class="input-group-text btn-sm" id="basic-addon1">Nama</span>
                            <input type="text" class="form-control  btn-sm" value="<?=$detail->nama_pelanggan?>" name="nama_pelanggan" placeholder="Nama "
                                aria-label="nama_pelangan" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text btn-sm" id="basic-addon1">Username</span>
                            <input type="text" class="form-control  btn-sm" value="<?=$detail->id_pelanggan?>" name="username" placeholder="Username"
                                aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text btn-sm" id="basic-addon1">Password</span>
                            <input type="password" class="form-control  btn-sm" value="<?=$detail->password?>" name="password" placeholder="Password"
                                aria-label="password" aria-describedby="basic-addon1">
                        </div>
                        <p for="" class="btn-xs text-white">*Daftar kota tujuan pengiriman.</p>
                        <div class="input-group mb-3">
                            <span class="input-group-text btn-sm" id="basic-addon1">Kabupaten</span>
                            <select name="kabupaten" id="kabupaten" class="form-control  btn-sm">
                                <?php
                                echo '<option value="' . $detail->kabupaten . '">' . $detail->kabupaten . '</option>';
                                echo '<option value="">--Pilih Kabupaten--</option>';
                                $kota = $this->db->select("lokasi_tujuan")->from("ongkos_kirim")->get()->result();
                                foreach ($kota as $k => $val) {
                                    if ($val->lokasi_tujuan != '-') {
                                        echo '<option value="' . $val->lokasi_tujuan . '">' . $val->lokasi_tujuan . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text btn-sm" id="basic-addon1">Kecamatan</span>
                            <input type="text" class="form-control  btn-sm" value="<?=$detail->kecamatan?>" name="kecamatan" placeholder="Kecamatan"
                                aria-label="kecamatan" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text btn-sm" id="basic-addon1">Desa</span>
                            <input type="text" class="form-control  btn-sm" value="<?=$detail->desa?>" name="desa" placeholder="Desa"
                                aria-label="desa" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text btn-sm" id="basic-addon1">Kode Pos</span>
                            <input type="text" class="form-control  btn-sm" value="<?=$detail->kodepos?>" name="kodepos" placeholder="Kode Pos"
                                aria-label="kodepos" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text btn-sm" id="basic-addon1">Rw</span>
                            <input type="text" class="form-control  btn-sm" value="<?=$detail->rw?>" name="rw" placeholder="Rw" aria-label="rw"
                                aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text btn-sm" id="basic-addon1">Rt</span>
                            <input type="text" class="form-control  btn-sm" value="<?=$detail->rt?>" name="rt" placeholder="Rt" aria-label="Rt"
                                aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text btn-sm" id="basic-addon1">No Hp</span>
                            <input type="number" class="form-control  btn-sm" value="<?=$detail->no_hp?>" name="no_hp" placeholder="No Hp"
                                aria-label="no_hp" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text btn-sm" id="basic-addon1">Email</span>
                            <input type="email" class="form-control  btn-sm" value="<?=$detail->email?>" name="email" placeholder="Email"
                                aria-label="email" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" class="form-control btn btn-sm btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>