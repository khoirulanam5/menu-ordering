<h3>Cek Resi</h3>
<form action="<?= base_url() ?>transaksi/penjualan/cek_harga" method="post">
    <div class="input-group mb-3">
        <label class="input-group-text" for="inputGroupSelect01">Options</label>
        <select class="form-select" id="inputGroupSelect01">
            <option selected>Pilih Kurir...</option>
            <option value="jnt">JNT</option>
            <option value="pos">POS Indonesia</option>
            <option value="sicepat">SiCepat</option>
            <option value="jne">JNE</option>
            <option value="anteraja">Anteraja</option>
            <option value="wahana">Wahana</option>
            <option value="ninja">Ninja</option>
        </select>
    </div>
    <div class="input-group mb-3">
        <label class="input-group-text" for="input">No Resi</label>
        <input class="form-select" id="awb" name="awb" placeholder="No resi">
    </div>
    <div class="mb-3 row form-group">
        <input type="sumbit" class="form-control btn btn-success" value="Check">
    </div>
</form>

curl --location --request GET 'https://api.binderbyte.com/wilayah/provinsi?api_key=159d589711c6f3ed20322851291eb9e70e483e7c72bb99c427041ed0406c3f00'

curl --location --request GET 'https://api.binderbyte.com/v1/track?api_key=159d589711c6f3ed20322851291eb9e70e483e7c72bb99c427041ed0406c3f00&courier=jne&awb=8825112045716759'

{"status":200,"message":"Successfully tracked package","data":{"summary":{"awb":
"8825112045716759","courier":"JNE Express","service":"REG","status":"DELIVERED",
"date":"2020-10-02 13:33:00","desc":"TAS TOTE","amount":"","weight":"0.4 Kg"},"d
etail":{"origin":"KOTA JAKARTA BARAT","destination":"PRINGSEWU, PRINGSEWU","ship
per":"TASIMPORTBATAMMURAH","receiver":"RESALINA OKTARIA"},"history":[{"date":"20
20-10-02 13:33:00","desc":"DELIVERED TO [RESALINA | 02-10-2020 13:33 | PRINGSEWU
, PRINGSEWU ]","location":""},{"date":"2020-10-02 09:09:00","desc":"WITH DELIVER
Y COURIER  [BANDARLAMPUNG]","location":""},{"date":"2020-09-30 12:43:00","desc":
"RECEIVED AT WAREHOUSE [TKG, ALIMUDIN (INBOUND)]","location":""},{"date":"2020-0
9-29 22:27:00","desc":"PROCESSED AT SORTING CENTER [DEPOK, MARGONDA 265]","locat
ion":""},{"date":"2020-09-29 10:12:00","desc":"RECEIVED AT SORTING CENTER [DEPOK
]","location":""},{"date":"2020-09-29 01:50:00","desc":"SHIPMENT RECEIVED BY JNE
 COUNTER OFFICER AT [DEPOK]","location":""}]}}
