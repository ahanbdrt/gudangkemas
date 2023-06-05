<?php
$this->load->view('gudang/part/header');
$this->load->view('gudang/part/menu');
?>
<title>Gudang Kemas | Transaksi Keluar</title>
</head>
<div class="container-fluid"   id="alert"></div>
<div class="container-fluid"  >
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-12">
                <div class="card shadow mb-3">
                    <div class="card-header bg-danger py-2">
                        <h5 class="text-white"><b>Nomor Transaksi Barang Keluar</b></h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="tglform">Tanggal Form :</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="date" value="<?= date("Y-m-d")?>" name="tglform" id="tglform" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="noform">No Form :</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" name="noform" id="noform" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="container-fluid"  >
    <button class="btn btn-sm mb-3" id="plus" onclick="plus()" style="background-color:lightseagreen;color:white"><i class="fas fa-plus fa-sm"></i></button>
    <button class="btn btn-sm mb-3" id="minus" disabled onclick="minus()" style="background-color:lightseagreen;color:white"><i class="fas fa-minus fa-sm"></i></button>
    <h5></h5>
</div>
        <div class="container-fluid"  >
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-12">
                    <div class="card shadow mb-3">
                        <div class="card-header py-2" style="background-color:lightseagreen">
                            <h5 class="text-white"><b>Data Transaksi Barang Keluar 1</b></h5>
                        </div>
                        <div class="card-body bg-light">
                                <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label style="font-size:large" for="kode0">Nama barang :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <select class="kode" id="kode0" name="kode0" required>
                                                        <option value disabled selected>Pilih Barang</option>
                                                    <?php foreach($master as $m){?>
                                                        <option value="<?= $m->id?>"><?= $m->kode." || ". $m->nama?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label style="font-size:large" for="qty0">Jumlah masuk :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="text" id="qty0" name="qty0" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label style="font-size:large" for="tgltrima0">Tanggal terima :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" class="form-control" id="tgltrima0" name="tgltrima0" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label style="font-size:large" for="cat0">Catatan :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" id="cat0" name="cat0" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php for($i=0;$i<25;$i++){?>
        <div id="destination<?=$i?>"></div>
        <?php } ?>
        <div class="container-fluid"  >
            <div class="row justify-content-between ml-2 mr-2">
                <a href="<?= base_url("gudang/keluar") ?>" class="btn btn-secondary">Kembali</a>
                <button onclick="submitall()" class="btn btn-success">Submit</button>
            </div>
        </div>
    <input type="text" hidden value="0" id="count">
<?php $this->load->view('gudang/part/footer');?>

<script>
    $(document).ready(function(){
        $("#kode0").selectize();
    })
    function plus(){
    let count = document.getElementById('count').value;
    let i = Number(count);
    var d = document.getElementById("destination"+i);
    var copy = '<div class="container-fluid"  ><div class="row"><div class="col-md-1"></div><div class="col-md-12"><div class="card shadow mb-3"><div class="card-header py-2" style="background-color:lightseagreen"><h5 class="text-white"><b>Data Transaksi Masuk'+' '+Number(i+2)+'</b></h5></div><div class="card-body bg-light"><div class="row mb-3"><div class="col-lg-3"><label style="font-size:large" for="kode'+Number(i+1)+'">Nama barang :</label></div><div class="col-lg-9"><select id="kode'+Number(i+1)+'" name="kode'+Number(i+1)+'" required><option disabled value selected>Pilih Barang</option><?php foreach($master as $m){?><option value="<?= $m->id?>"><?= $m->kode." || ". $m->nama?></option><?php } ?></select></div></div><div class="row mb-3"><div class="col-lg-3"><label style="font-size:large" for="qty'+Number(i+1)+'">Jumlah masuk :</label></div><div class="col-lg-9"><input type="text" id="qty'+Number(i+1)+'" name="qty'+Number(i+1)+'" class="form-control" required></div></div><div class="row mb-3"><div class="col-lg-3"><label style="font-size:large" for="tgltrima'+Number(i+1)+'">Tanggal terima :</label></div><div class="col-lg-9"><input type="date" class="form-control" id="tgltrima'+Number(i+1)+'" name="tgltrima'+Number(i+1)+'" required></div></div><div class="row mb-3"><div class="col-lg-3"><label style="font-size:large" for="cat'+Number(i+1)+'">Catatan :</label></div><div class="col-lg-9"><input type="text" class="form-control" id="cat'+Number(i+1)+'" name="cat'+Number(i+1)+'" required></div></div></div></div></div></div></div></div>';
    d.innerHTML += copy;
    document.getElementById('count').value = parseInt(i+1);
    document.getElementById('minus').disabled = false;
    if(parseInt(i+1)>=19){
        document.getElementById('plus').disabled = true;
    }
    $("#kode"+Number(i+1)).selectize();
    }

    function minus(){
        var count = document.getElementById('count').value
        var i = count-1
        var d = document.getElementById("destination"+i);
        document.getElementById('count').value = i;
        d.innerHTML = null;
        document.getElementById('plus').disabled = false;
        if(i<=0){
            document.getElementById('minus').disabled = true;
        }
    }

    function submitall(){
        var index = document.getElementById('count').value
        var tglform = document.getElementById('tglform').value
        var noform = document.getElementById('noform').value
        var kode=[]
        var qty=[]
        var tgltrima=[]
        var status = true;
        for(let i=0;i<=index;i++){
            kode[i]=document.getElementById("kode"+i).value;
            qty[i]=document.getElementById("qty"+i).value;
            tgltrima[i]=document.getElementById("tgltrima"+i).value;
            if(document.getElementById("kode"+i).value=="" || document.getElementById("qty"+i).value=="" || document.getElementById("tgltrima"+i).value=="" || document.getElementById('noform').value==""){
                status=false;
            }
        }
        if(status == false){
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
                    icon: "warning",
                    title: "Pastikan semua form terisi!",
                    iconColor:'white',
                    color:'white',
                    customClass:{
                        popup:'bg-warning'
                    }
                }) 
        }else{

            $.ajax({
                url: "<?php echo site_url('gudang/masuk/store'); ?>",
                method: "POST",
                data: {
                    index:index,
                    tglform:tglform,
                    noform:noform,
                    kode:kode,
                    qty: qty,
                    tgltrima:tgltrima,
                },
                async: true,
                dataType: 'json',
                success: function(html) {
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
                            title: "Berhasil ditambahkan!",
                            iconColor:'white',
                            color:'white',
                            customClass:{
                                popup:"bg-success"
                            }
                        });
                        
                        $('.kode').each(function(index, element) {
                            element.selectize && element.selectize.clear()
                        });
                        document.getElementById('noform').value="";
                        document.getElementById('kode0').value="";
                        document.getElementById('qty0').value="";
                        document.getElementById('suplier0').value="";
                        document.getElementById('cat0').value="";

                        var count = document.getElementById("count").value
                        for(let i=0;i<=count;i++){
                            document.getElementById("destination"+i).innerHTML=""
                        }
                        document.getElementById("count").value = 0;
                        document.getElementById("minus").disabled = true;
                        
                    },
                    error: function (xhr, textStatus, exceptionThrown) {
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
                            title: "Gagal ditambahkan!",
                            iconColor:'white',
                            color:'white',
                            customClass:{
                                popup:"bg-danger"
                            }
                        })   
                    }
            })
        }
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>