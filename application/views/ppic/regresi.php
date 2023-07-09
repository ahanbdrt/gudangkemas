<?php 
$this->load->view("ppic/part/header");
if($this->session->userdata("role")=="ppic") {
    $this->load->view("ppic/part/menu");
}elseif($this->session->userdata("role")=="manager"){
    $this->load->view("manager/menu");
}
?>  
<title>Gudang Kemas | Regresi Linear</title>
</head>
<div class="container-fluid">
<div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-header py-2" style="background-color:lightseagreen">
                    <h5 class="text-white"><b>Keterangan</b></h5>
                </div>
                <div class="card-body bg-light">
                    <li>Beberapa barang tidak di tampilkan karena
                    fitur ini hanya berlaku untuk barang yang memiliki riwayat transaksi minimal 1 tahun transaksi keluar masuk</li>
                    <li>Periode digunakan untuk memperediksi barang keluar di beberapa bulan kedepan</li>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-header py-2" style="background-color:lightseagreen">
                    <h5 class="text-white"><b>Form Regresi Linear</b></h5>
                </div>
                <div class="card-body bg-light">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label style="font-size:large" for="kode">Barang :</label>
                        </div>
                        <div class="col-lg-9">
                            <select style="width:100%" name="kode" id="kode">
                                <option value disabled selected>Pilih Barang</option>
                                <option value="all">All</option>
                                <?php foreach($master as $m){
                                    if($m['jum']>=24){?>
                                    <option value="<?=$m['kode']?>"><?=$m['mkode'].' '.$m['nama']?></option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label style="font-size:large" for="kode">Periode :</label>
                        </div>
                        <div class="col-lg-3">
                            <select onchange="fil_bulan()" style="width:100%" name="tahun" id="tahun">
                                <?php if(date("m")!=12){?>
                                <option value="<?= date("Y")?>"><?= date("Y") ?></option>
                                <option value="<?= date("Y")+1?>"><?= date("Y")+1 ?></option>
                                <option value="<?= date("Y")+2?>"><?= date("Y")+2 ?></option>
                                <?php }else{ ?>
                                <option value="<?= date("Y")+1?>"><?= date("Y")+1 ?></option>
                                <option value="<?= date("Y")+2?>"><?= date("Y")+2 ?></option>
                                <option value="<?= date("Y")+3?>"><?= date("Y")+3 ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <select style="width:100%" name="bulan" id="bulan"></select>
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
                    <h5 class="text-white"><b>Hasil Prediksi Regresi Linear</b></h5>
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
                    <div id="visible1">
                        <table id="tabel1" class="table table-bordered w-100">
                            <thead></thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div id="visible2">
                        <table id="tabel2" class="table table-bordered w-100">
                            <thead></thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("ppic/part/footer")?>
<script>
    $(document).ready(function(){
        $("select").select2()
    });
</script>
<script>
    var now = new Date();
    var tahun = now.getFullYear()
    var bulan=["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
    var text = "";
    text+="<option value disabled selected>Pilih Bulan</option>";
    if(document.getElementById("tahun").value == tahun){
        for(let i=0;i<bulan.length;i++){
            if(i>now.getMonth()){
            text+="<option value="+Number(i+1)+">"+bulan[i]+"</option>"
            }
        }
        document.getElementById("bulan").innerHTML = text
    }

    function fil_bulan(){
        var now = new Date();
        var tahun = now.getFullYear();
        var bulan=["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        var text = ""
        text+="<option value disabled selected>Pilih Bulan</option>";
        if(document.getElementById("tahun").value == tahun){
            for(let i=0;i<bulan.length;i++){
                if(i>now.getMonth()){
                text+="<option value="+Number(i+1)+">"+bulan[i]+"</option>"
                }
            }
        }else{
            for(let i=0;i<bulan.length;i++){
                text+="<option value="+Number(i+1)+">"+bulan[i]+"</option>"
            }
        }
    document.getElementById("bulan").innerHTML = text
    }

    function submit(){
        document.getElementById("hasil").hidden = false;
        var kode =document.getElementById("kode").value;
        var tahun =document.getElementById("tahun").value;
        var bulan =document.getElementById("bulan").value;
        $.ajax({
            dataType:"json",
            method:"post",
            url:"<?=base_url('ppic/regresi/hasil')?>",
            data:{
                kode:kode,
                tahun:tahun,
                bulan:bulan
            },
            async:true,
            success:function(html){
                document.getElementById("loading").hidden = true;
                if(document.getElementById("kode").value != "all"){
                    document.getElementById("visible2").hidden=true
                    document.getElementById("visible1").hidden = false;
                    $("#tabel1").DataTable({
                        destroy:true,
                        paginate:false,
                        data:html,
                        columns:[
                            {title:"Kode",data:"kode"},
                            {title:"Nama Kemasan",data:"nama"},
                            {title:"Prediksi",data:"hasil"},
                        ],
                        dom: 'lBtp',
                        buttons:['copy','excel','pdf']
                    })
                }else{
                    document.getElementById("visible1").hidden=true
                    document.getElementById("visible2").hidden = false;
                    $("#tabel2").DataTable({
                        destroy:true,
                        data:html,
                        columns:[
                            {title:"No",data:"no"},
                            {title:"Kode",data:"kode"},
                            {title:"Nama Kemasan",data:"nama"},
                            {title:"Prediksi",data:"regresi"},
                            {title:"Satuan",data:"satuan"},
                        ],
                        dom: 'lBftip',
                        buttons:['copy','excel','pdf'],
                    });
                }
            }
        })
    }
</script>
