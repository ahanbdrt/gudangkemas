<?php 
    $this->load->view('gudang/part/header');
    if($this->session->userdata("role")=="gudang"){
        $this->load->view('gudang/part/menu');
    }
    if($this->session->userdata("role")=="ppic"){
        $this->load->view('ppic/part/menu');
    }elseif($this->session->userdata("role")=="manager"){
        $this->load->view('manager/menu');
    }
    ?>
<title>Gudang Kemas | Beranda</title>
</head>
<div class="container-fluid"  >
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color:lightseagreen">
                        <h3 class="text-white"><b>Stock Gudang</b></h3>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div id="loading_stock" class="text-center">
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
                            <table class="table table-bordered table-responsive" hidden width="100%" id="tabel_stock" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Satuan</th>
                                        <th>Saldo</th>
                                        <th>Grup</th>
                                        <th>Sub Grup</th>
                                        <th>Tanggal Dibuat</th>
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
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color:lightseagreen">
                        <h3 class="text-white"><b>Riwayat Transaksi</b></h3>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div id="loading_riwayat" class="text-center">
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
                            <table class="table table-bordered table-responsive" hidden width="100%" id="tabel_riwayat" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Grup</th>
                                        <th>Sub Grup</th>
                                        <th>No Form</th>
                                        <th>Tanggal Form</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
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
    </div>
</div>
<?php $this->load->view('gudang/part/footer');?>
<script>
    $(document).ready(function() {
        $.ajax( {
            dataType: 'json',
            url: "<?=base_url('home/gethome')?>",
            success: function ( html ) {
                // console.log(html);
                document.getElementById('tabel_stock').hidden=false
                document.getElementById('loading_stock').hidden=true
                $("#tabel_stock").DataTable({
                    data: html,
                    columns:[
                        {data : "id"},
                        {data : "kode"},
                        {data : "nama"},
                        {data : "satuan"},
                        {data : "saldo"},
                        {data : "namagrup"},
                        {data : "namasubgr"},
                        {data : "tglmas"}
                    ],
                    dom: 'lBftip',
                    buttons: [
                        'copy','excel'
                    ]
                })
            }
        })
    })
</script>
<script>
    $(document).ready(function() {
        $.ajax( {
            dataType: 'json',
            url: "<?=base_url('home/getriwayat')?>",
            success: function ( html ) {
                // console.log(html);
                document.getElementById('tabel_riwayat').hidden=false
                document.getElementById('loading_riwayat').hidden=true
                $("#tabel_riwayat").DataTable({
                    data: html,
                    columns:[
                        {data : "no"},
                        {data : "kode"},
                        {data : "nama"},
                        {data : "namagrup"},
                        {data : "namasubgr"},
                        {data : "noform"},
                        {data : "tglform"},
                        {data : "qty"},
                        {data : "ket"}
                    ],
                    dom: 'lBftip',
                    buttons: [
                        'copy','excel'
                    ]
                })
            }
        })
    })
</script>