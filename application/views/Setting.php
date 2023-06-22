<?php 
$this->load->view("ppic/part/header");
if($this->session->userdata("role")=="ppic") {
    $this->load->view("ppic/part/menu");
}elseif($this->session->userdata("role")=="manager"){
    $this->load->view("manager/menu");
}else{
    $this->load->view("gudang/menu");
}
?>  
<div class="container-fluid">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color:lightseagreen">
                        <h3 class="text-white"><b>Setting</b></h3>
                    </div>
                    <div class="card-body bg-light">
                        <form method="post" action="<?=base_url()?>setting/update">
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label class="login2 pull-right pull-right-pro">Username :</label>
                            </div>
                                <div class="col-lg-9">
                                <input class="form-control" hidden type="text" name="id" value="<?=$this->session->userdata("user_id")?>">
                                <input class="form-control" type="text" name="username" value="<?=$this->session->userdata("username")?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label class="login2 pull-right pull-right-pro">Password :</label>
                            </div>
                                <div class="col-lg-9">
                                <input class="form-control" type="password" name="Password">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success btn-md" type="submit">Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("ppic/part/footer");?>

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
