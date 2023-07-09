<?php 
    $this->load->view('ppic/part/header');
    $this->load->view('ppic/part/menu');
    ?>
<title>Gudang Kemas | Grup</title>
</head>
<div class="container-fluid"  >
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color:lightseagreen">
                        <h3 class="text-white"><b>Data Grup</b></h3>
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
                                <button id="tambah" hidden class="mb-2 btn btn-sm" style="background-color:lightseagreen;color:white" data-toggle="modal" data-target="#tambahgrup"><i class="fas fa-sm fa-plus"></i> Tambah Grup</button>
                                <table class="table table-bordered table-responsive" hidden width="100%" id="tabel_stock" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Grup</th>
                                        <th>Nama Grup</th>
                                        <th>Kode sub Grup</th>
                                        <th>Nama sub Grup</th>
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
<?php 
$this->load->view('ppic/part/footer');
$this->load->view('ppic/grup/tambahgrup');
$this->load->view('ppic/grup/editgrup');
$this->load->view('ppic/grup/hapusgrup');
?>
<?php if($this->session->flashdata("berhasil")){?>
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
        title: "<?= $this->session->flashdata("berhasil")?>",
        iconColor:'white',
        color:'white',
        customClass:{
            popup:"bg-success"
        }
    });
</script>
<?php } ?>
<?php if($this->session->flashdata("gagal")){?>
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
        title: "<?= $this->session->flashdata("gagal")?>",
        iconColor:'white',
        color:'white',
        customClass:{
            popup:"bg-danger"
        }
    });
</script>
<?php } ?>
<script>
    $(document).ready(function(){
        $.ajax( {
            dataType: 'json',
            url: "<?= base_url('ppic/grup/getgrup')?>",
            success: function ( html ) {
                document.getElementById('tabel_stock').hidden=false
                document.getElementById('loading').hidden=true
                document.getElementById('tambah').hidden=false
                $("#tabel_stock").DataTable({
                    data: html,
                    columns:[
                        {data : "no"},
                        {data : "kdgrup"},
                        {data : "namagrup"},
                        {data : "kdsubgr"},
                        {data : "namasubgr"},
                        {data : "aksi"},
                    ],
                    dom: 'lBftip',
                    buttons: [
                        'copy','excel','pdf'
                    ]
                    })
            }
        })
    })
</script>