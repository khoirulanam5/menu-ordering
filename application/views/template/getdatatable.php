<?php
if (!empty($this->input->get('ops'))) {
    $ops = $this->input->get('ops');
    if ($ops == 'proses') {
        $datas = cek_kirim(1);
    }elseif($ops=='selesai'){
        $datas = cek_kirim(2);
    }else{
        $datas = cek_bayar(0);   
    }
    if ($ops == 'proses' || $ops == 'selesai') {
        ?>
        <table class="table table-bordered table-striped" id="tables">
            <thead>
                <tr>
                    <th style="">No Resi </th>
                    <th style="">Total Bayar</th>
                    <th style="">Status Pengiriman</th>
                    <th style="">Tgl Jual</th>
                    <th style="">Nama Penerima</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    if (!empty($datas)) {
                        foreach ($datas as $key => $value) {
                        $total = json_decode($value->data_produk);
                        if($value->status_kirim == 1){
                            $pengiriman = "Proses dikirim";
                        }elseif($value->status_kirim == 2){
                            $pengiriman = "Paket sudah diterima";
                        }else{
                            $pengiriman = "Pembayaran belum diverifikasi";
                        }
                        ?>
                        <tr id="<?= $value->no_transaksi ?>">
                            <?php
                                echo "<th>" . strtoupper($value->no_transaksi) . "</th>";
                                echo "<th>" . strtoupper($total->total_bayar) . "</th>";
                                echo "<th>" . strtoupper($pengiriman) . "</th>";
                                echo "<th>" . strtoupper(($value->tgl_jual == NULL) ? "-":$value->tgl_jual). "</th>";
                                echo "<th>" . strtoupper($value->nama_penerima) . "</th>";
                            ?>
                        </tr>
                        <?php $no++;
                            }
                        } 
                    ?>
            </tbody>
        </table>
        <?php
    }else{
        ?>
        <table class="table table-bordered table-striped" id="tables" style="font-size: small;">
            <thead>
                <tr>
                    <th style="">No Transaksi </th>
                    <th style="">Nama Pelanggan</th>
                    <th style="">Status Pengiriman</th>
                    <th style="">Kota Tujuan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    if (!empty($datas)) {
                        foreach ($datas as $key => $value) {
                        if($value->status_kirim  == 1 ){
                            $pengiriman = "<span class='btn btn-primary btn-xs'>Proses Dikirim</span>";
                        }elseif ($value->status_kirim  == 2) {
                            $pengiriman = "<span class='btn btn-success btn-xs'>Selesai Dikirim</span>";
                        } else {
                            $pengiriman = "<span class='btn btn-warning btn-xs'>Pembayaran Belum diverifikasi</span>";
                        }
                        ?>
                        <tr id="<?= $value->no_transaksi ?>">
                            <?php
                                echo "<th>" . strtoupper($value->no_transaksi) . "</th>";
                                echo "<th>" . strtoupper($value->nama_pelanggan) . "</th>";
                                echo "<th>" .$pengiriman. "</th>";
                                echo "<th>" . strtoupper($value->kabupaten) . "</th>";
                            ?>
                        </tr>
                        <?php $no++;
                            }
                        } 
                ?>
            </tbody>
            </table>
        <?php
    }
}