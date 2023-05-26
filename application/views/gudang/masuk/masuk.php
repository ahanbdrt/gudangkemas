<?php 
    $this->load->view('gudang/part/header');
    $this->load->view('gudang/part/menu');
    ?>
<title>Gudang Kemas | Transaksi Masuk</title>
</head>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-success py-3">
                        <h3 class="text-white"><b>Transaksi Masuk</b></h3>
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
                                <a id="tambah" href="<?= base_url("gudang/masuk/tambahmasuk")?>" hidden class="mb-2 btn btn-sm btn-success"><i class="fas fa-sm fa-plus"></i> Tambah transaksi masuk</a>
                            <table class="table table-bordered table-responsive" hidden width="100%" id="tabel" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>No Form</th>
                                        <th>Tanggal Form</th>
                                        <th>Jumlah</th>
                                        <th>Suplier</th>
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
<?php $this->load->view('gudang/masuk/editmasuk');?>
<?php $this->load->view('gudang/masuk/hapusmasuk');?>
<script>
    $(document).ready(function() {
        $.ajax( {
            dataType: 'json',
            url: "<?= base_url('gudang/masuk/getmasuk')?>",
            success: function ( html ) {
                document.getElementById('tabel').hidden=false
                document.getElementById('loading').hidden=true
                document.getElementById('tambah').hidden=false
                console.log(html);
                $("#tabel").DataTable({
                    data: html,
                    columns:[
                        {data : "no"},
                        {data : "kode"},
                        {data : "nama"},
                        {data : "noform"},
                        {data : "tglform"},
                        {data : "masuk"},
                        {data : "suplai"},
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
<?php if($this->session->flashdata("berhasil")){ ?>
    <script>
        const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: "success",
                    title: '<?= $this->session->flashdata("berhasil")?>',
                    iconColor:'white',
                    color:'white',
                    customClass:{
                        popup:'bg-success'
                    }
                }) 
    </script>
<?php } ?>
<?php if($this->session->flashdata("gagal")){ ?>
    <script>
        const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: "error",
                    title: '<?= $this->session->flashdata("gagal")?>',
                    iconColor:'white',
                    color:'white',
                    customClass:{
                        popup:'bg-danger'
                    }
                }) 
    </script>
<?php } ?>