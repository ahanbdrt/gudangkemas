<?php 
$this->load->view("ppic/part/header");
if($this->session->userdata("role")=="ppic") {
    $this->load->view("ppic/part/menu");
}elseif($this->session->userdata("role")=="manager"){
    $this->load->view("manager/menu");
}
?>  
<title>Gudang Kemas | Report All</title>
</head>
<div class="container-fluid"  >
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-header py-2" style="background-color:lightseagreen">
                    <h5 class="text-white"><b>Report Keseluruhan</b></h5>
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
                                    <input type="date" id="start" onchange="validasi_tanggal()" class="form-control mr-1"
                                        name="start" value="" required />
                                    <span class="input-group-addon ml-1 mr-1">to</span>
                                    <input type="date" id="end" onchange="validasi_tanggal()" value="<?= date("Y-m-d")?>" class="form-control ml-1" name="end"
                                        required />
                                </div>
                            </div>
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
                    <h5 class="text-white"><b>Hasil laporan menyeluruh</b></h5>
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
                    <div class="table-responsive">
                    <table class="table table-bordered table responsive" id="table" width="100%" hidden>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Sub Grup</th>
                                <th>Satuan</th>
                                <th>Saldo Awal</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Saldo Akhir</th>
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
</div>
<?php $this->load->view("ppic/part/footer");?>

<script>
    function validasi_tanggal(){
        var start = document.getElementById("start").value
        var end = document.getElementById("end").value
        if(Date.parse(start)>Date.parse(end)){
            if(end!=null){
            window.alert("Tanggal mulai lebih besar dari tanggal akhir!");
            var d = new Date()
            document.getElementById("start").value="0000-00-00";
            document.getElementById("end").value= d.Date();
            }
        }
    }
    function tampil(){
        var start = document.getElementById("start").value
        var end = document.getElementById("end").value
        document.getElementById("hasil").hidden=false;
        $.ajax({
            dataType:"json",
            method:"post",
            url:"<?php echo site_url("report/reportall/hasil")?>",
            data:{
                start:start,
                end:end,
            },
            async:true,
            success:function(html){
                document.getElementById("table").hidden = false;
                console.log(html)
                var text = '<h5>Laporan periode '+html[0].start+' s/d '+html[0].end+'</h5>';
                document.getElementById("loading").innerHTML = text
                $("#table").DataTable({
                    destroy:true,
                    data: html,
                    columns:[
                        {data : "no"},
                        {data : "kode"},
                        {data : "nama"},
                        {data : "namasubgr"},
                        {data : "satuan"},
                        {data : "saldo_awal"},
                        {data : "masuk"},
                        {data : "keluar"},
                        {data : "saldo_akhir"},
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