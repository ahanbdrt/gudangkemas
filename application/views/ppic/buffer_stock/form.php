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
                    Beberapa barang tidak di tampilkan karena
                    fitur ini hanya berlaku untuk barang yang memiliki riwayat transaksi minimal 1 tahun
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
                                <?php foreach($master as $m){
                                    if($m->jum>=12){?>
                                    <option value="<?= $m->id ?>"><?= $m->kode.' || '.$m->nama ?></option>
                                <?php }}?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label style="font-size:large" for="kode">Lead Time :</label>
                        </div>
                        <div class="col-lg-9">
                            <div class="input-group">
                                <input type="number" class="form-control" id="lead" name="leadtime">
                                <div class="input-group-append">
                                    <span class="input-group-text">Bulan</span>
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
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("ppic/part/footer");?>      
<script>
    $(document).ready(function(){
        $("select").selectize()
    })
</script>

<script>
    function submit(){
        document.getElementById("hasil").hidden=false;
        var kode = document.getElementById("kode").value;
        var lead = document.getElementById("lead").value;
        $.ajax({
            url: "<?php echo site_url('ppic/buffer_stock/tampil_buffer'); ?>",
                method: "POST",
                data: {
                    kode:kode,
                    lead:lead,
                },
                async: true,
                dataType: 'json',
                success: function(html) {
                    var options = { year: 'numeric', month: 'long', day: 'numeric' };
                    var d  = new Date();
                    var bulan = Number(lead);
                    var t = d.getFullYear();
                    if (Number(d.getMonth()+bulan) > 11) {
                        var current = new Date(t +(d.getMonth()+bulan)/12 ,(d.getMonth()+bulan)%12 , d.getDate());
                    } else {
                        var current = new Date(t, d.getMonth()+bulan, d.getDate());
                    }
                    var data = '<h5 class="mb-3">Hasil Buffer stock dari kode <b>'+html.kode+'</b> dengan lead time <b>'+html.lead+'</b> Bulan sebagai berikut:</h5><div class="table-responsive"><table id="tabel" class="table table-bordered" width="100%"><thead><tr><th>Buffer Stock</th><th>Stock di Gudang saat ini</th></tr></thead><tbody><tr><td>'+html.buffer+' '+html.satuan+'</td><td>'+html.saldo+' '+html.satuan+'</td></tr></tbody></table></div>';
                    data+="<br><span>Berdasarkan data diatas, stock minimum yang diperlukan pada:<br> <b>"+d.toLocaleDateString("ID", options)+"</b> sampai <b>"+current.toLocaleDateString("ID", options)+"</b><br>Sebesar: <b>"+html.buffer+" "+html.satuan+"</b></span>"
                    document.getElementById("loading").innerHTML = data
                    // console.log(html)
                }
        });
    }
</script>