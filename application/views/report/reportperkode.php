<?php 
$this->load->view("ppic/part/header");
if($this->session->userdata("role")=="ppic") {
    $this->load->view("ppic/part/menu");
}elseif($this->session->userdata("role")=="manager"){
    $this->load->view("manager/menu");
}
?>  
<title>Gudang Kemas | Report per Kode Barang</title>
</head>
<div class="container-fluid"  >
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-header py-2" style="background-color:lightseagreen">
                    <h5 class="text-white"><b>Report Per Kode Barang</b></h5>
                </div>
                <div class="card-body bg-light">
                    <div class="form-group-inner">
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label class="login2 pull-right pull-right-pro">Range
                                    Tanggal :</label>
                            </div>
                            <div class="col-lg-9">
    
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="date" id="start" class="form-control mr-1"
                                        name="start" value="" required />
                                    <span class="input-group-addon ml-1 mr-1">to</span>
                                    <input type="date" id="end" class="form-control ml-1" name="end"
                                        required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label style="font-size:large" for="kode">Barang :</label>
                        </div>
                        <div class="col-lg-9">
                            <select name="kode" id="kode">
                                <option value disabled selected>Pilih Barang</option>
                                <?php foreach($master as $m){?>
                                    <option value="<?= $m->id ?>"><?= $m->kode.' || '.$m->nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-5">
                        <button type="button" onclick="tampil()" class="btn btn-md btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="hasil" hidden>
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-header py-2" style="background-color:lightseagreen">
                    <h5 class="text-white"><b>Hasil laporan per kode barang</b></h5>
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
                    <table class="table table-bordered table responsive" id="table" width="100%" hidden>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>tglform</th>
                                <th>Noform</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Satuan</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("ppic/part/footer");?>
<script>
    $(document).ready(function(){
        $("#kode").selectize();
    })
</script>
<script>
    function tampil(){
        var start = document.getElementById("start").value
        var end = document.getElementById("end").value
        var kode = document.getElementById("kode").value
        document.getElementById("hasil").hidden=false;
        $.ajax({
            dataType:"json",
            method:"post",
            url:"<?php echo site_url("report/reportperkode/hasil")?>",
            data:{
                start:start,
                end:end,
                kode:kode
            },
            async:true,
            success:function(html){
                document.getElementById("table").hidden = false;
                console.log(html)
                var text = '<h5>Laporan kode barang: '+html[0].kode+' periode '+html[0].start+' s/d '+html[0].end+'</h5><br><h5>Dengan Saldo Awal: <b>'+html[0].saldo_awal+'</b></h5>';
                document.getElementById("loading").innerHTML = text
                $("#table").DataTable({
                    destroy:true,
                    data: html,
                    columns:[
                        {data : "no"},
                        {data : "tglform"},
                        {data : "noform"},
                        {data : "kode"},
                        {data : "nama"},
                        {data : "satuan"},
                        {data : "masuk"},
                        {data : "keluar"},
                        {data : "saldo"},
                    ],
                    dom: 'lBftip',
                    buttons: [
                        'copy','excel','print'
                    ]
                })
            }
        })
    }
</script>