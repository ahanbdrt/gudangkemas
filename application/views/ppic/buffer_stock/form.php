<?php 
$this->load->view("ppic/part/header");
if($this->session->userdata("role")=="ppic") {
    $this->load->view("ppic/part/menu");
}elseif($this->session->userdata("role")=="manager"){
    $this->load->view("manager/menu");
}
?>  
<title>Gudang Kemas | Buffer Stock</title>
</head>
<div class="container-fluid">
<div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-header py-2" style="background-color:lightseagreen">
                    <h5 class="text-white"><b>Buffer Stock</b></h5>
                </div>
                <div class="card-body bg-light">
                    <p>Buffer Stock adalah stock tambahan yang bertujuan untuk menjadi sebuah penyangga guna memenuhi permintaan yang tidak pasti. dengan membuat sebuah sistem yang dapat membantu menentukan jumlah stock  minimal yang diperlukan untuk mencegah stock out sehingga dapat menentukan jumlah barang yang dibutuhkan.</p>

                    <p><b><span>Keterangan:</span></b><br>
                    <li>Beberapa barang tidak di tampilkan karena
                    fitur ini hanya berlaku untuk barang yang memiliki riwayat transaksi minimal 50 kali atau lebih</li>
                    <li>Lama waktu(<b>Lead Time</b>) digunakan untuk memperkirakan stok minimal yang harus dipenuhi untuk beberapa bulan/hari kedepan</li>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-header py-2" style="background-color:lightseagreen">
                    <h5 class="text-white"><b>Form Buffer Stock</b></h5>
                </div>
                <div class="card-body bg-light">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label style="font-size:large" for="kode">Barang :</label>
                        </div>
                        <div class="col-lg-9">
                            <select name="kode" id="kode">
                                <option value disabled selected>Pilih Barang</option>
                                <option value="all">All</option>
                                <?php $no=1;
                                foreach($master as $m){
                                    if($m->jum>=50){?>
                                    <option value="<?= $m->id ?>"><?= $m->id.' || '.$m->kode.' || '.$m->nama ?></option>
                                <?php }}?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label style="font-size:large" for="kode">Lama Waktu :</label>
                        </div>
                        <div class="col-lg-9">
                            <div class="input-group">
                                <input type="number" class="form-control" id="lead" name="leadtime">
                                <div class="input-group-append">
                                    <select name="format" id="format" class="input-group-text">
                                        <option value="bulan">Bulan</option>
                                        <option value="hari">Hari</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-5">
                        <button type="button" onclick="submit()" class="btn btn-md btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="hasil" hidden>
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-header py-2" style="background-color:lightseagreen">
                    <h5 class="text-white"><b>Hasil Perhitungan Buffer Stock</b></h5>
                </div>
                <div class="card-body bg-light">
                    <div id="loading" class="text-center">
                        <div class="spinner-grow text-primary" role="status"></div>
                        <div class="spinner-grow text-info" role="status"></div>
                        <div class="spinner-grow text-secondary" role="status"></div>
                        <div class="spinner-grow text-warning" role="status"></div>
                        <div class="spinner-grow text-dark" role="status"></div>
                        <div class="spinner-grow text-danger" role="status"></div>
                        <div class="spinner-grow" style="color:crimson" role="status"></div>
                        <div class="spinner-grow" style="color:coral" role="status"></div>
                        <div class="spinner-grow" style="color:fuchsia" role="status"></div>
                    </div>
                    <div id="visible">
                    <table id="tabel" hidden class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Kemasan</th>
                                <th>Buffer Stock</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("ppic/part/footer");?>      
<script>
    $(document).ready(function(){
        $("#kode").selectize()
    })
</script>

<script>
    function submit(){
        document.getElementById("hasil").hidden=false;
        var kode = document.getElementById("kode").value;
        var lead = document.getElementById("lead").value;
        var format = document.getElementById("format").value;
        $.ajax({
            url: "<?php echo site_url('ppic/buffer_stock/tampil_buffer'); ?>",
                method: "POST",
                data: {
                    kode:kode,
                    lead:lead,
                    format:format,
                },
                async: true,
                dataType: 'json',
                success: function(html) {
                    if(document.getElementById("kode").value != "all"){
                    var data = '<h5 class="mb-3">Hasil Buffer stock dari <b>'+html.kode+' '+html.nama+'</b><br> dengan lead time <b>'+html.lead+'</b> sebagai berikut:</h5><div class="table-responsive"><table id="tabel" class="table table-bordered" width="100%"><thead><tr><th>Buffer Stock</th><th>Stock di Gudang saat ini</th></tr></thead><tbody><tr><td>'+html.buffer+' '+html.satuan+'</td><td>'+html.saldo+' '+html.satuan+'</td></tr></tbody></table></div>';
                    data+="<br><h5>Berdasarkan data diatas, stock minimum yang diperlukan untuk jangka waktu <b>"+html.lead;html.format;
                    data+="</b> kedepan sebesar: <b>"+html.buffer+" "+html.satuan+"</b></h5>";
                    document.getElementById("loading").innerHTML = data
                    document.getElementById("visible").hidden = true;
                }else{
                    console.log(html)
                        var data = '<h5 class="mb-3">Hasil Buffer stock dengan lead time <b>'+html[0].lead+'</b> Bulan sebagai berikut:</h5>';
                        document.getElementById("loading").innerHTML = data
                        $("#tabel").DataTable({
                            destroy:true,
                            data:html,
                            columns:[
                                {data:"kode"},
                                {data:"nama"},
                                {data:"buffer"}
                            ],
                            dom: 'lBftip',
                            buttons: [
                                'copy','excel','pdf'
                            ]
                        })
                        console.log(html);
                        document.getElementById("visible").hidden = false;
                        document.getElementById("tabel").hidden = false;
                    }
                }
        });
    }
</script>