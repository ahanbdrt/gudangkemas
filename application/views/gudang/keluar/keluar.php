<?php 
    $this->load->view('gudang/part/header');
    $this->load->view('gudang/part/menu');?>
<title>Gudang Kemas | Transaksi Keluar</title>
</head>
<div class="container-fluid"  >
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color:lightseagreen">
                        <h3 class="text-white"><b>Transaksi Keluar</b></h3>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
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
                                <a id="tambah" href="<?=base_url()?>gudang/keluar/tambahkeluar" hidden class="mb-2 btn btn-sm" style="background-color:lightseagreen;color:white"><i class="fas fa-sm fa-plus"></i> Tambah transaksi keluar</a>
                            <table class="table table-bordered table-responsive" hidden width="100%" id="tabel" cellspacing="0">
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
                                        <th>Tanggal Terima</th>
                                        <th>Catatan</th>
                                        <th>Aksi</th>
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
<?php $this->load->view('gudang/part/footer');?>
<script>
    $(document).ready(function() {
        $.ajax( {
            dataType: 'json',
            url: "<?= base_url('gudang/keluar/getkeluar')?>",
            success: function ( html ) {
                document.getElementById('tabel').hidden=false
                document.getElementById('loading').hidden=true
                document.getElementById('tambah').hidden=false
                // console.log(html);
                $("#tabel").DataTable({
                    data: html,
                    columns:[
                        {data : "no"},
                        {data : "kode"},
                        {data : "nama"},
                        {data : "namagrup"},
                        {data : "namasubgr"},
                        {data : "noform"},
                        {data : "tglform"},
                        {data : "keluar"},
                        {data : "tgltrima"},
                        {data : "cat"},
                        {data : "aksi"},
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy','excel'
                    ]
                })
            }
        })
    })
</script>