<div class="modal fade" id="tambahgrup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Tambah Grup</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url("ppic/grup/tambah")?>" method="post">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="kode">Kode Grup:</label>
                            </div>
                            <div class="col-lg-9">
                                <select onchange="getkdsubgr()" id="grup" name="kdgrup" required>
                                    <option value disabled selected>Pilih Grup</option>
                                    <?php foreach($grup as $g){?>
                                        <option value="<?= $g->kdgrup?>"><?= $g->kdgrup.". ".$g->namagrup?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="kode">Kode sub Grup:</label>
                            </div>
                            <div class="col-lg-9">
                                <span id="ket"></span>
                                <input type="text" onkeyup="filter_subgr()" class="form-control" id="kdsubgr" name="kdsubgr" required>
                                <span id="pesan" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="kode">Nama sub Grup:</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="namasubgr" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button id="submit" type="submit" id="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
</div>

<script>
    $(document).ready(function(){
        $("#grup").selectize();
    })
</script>

<script>
    function getkdsubgr(){
        document.getElementById("kdsubgr").value = document.getElementById("grup").value
        document.getElementById("submit").disabled = true
        document.getElementById("ket").innerHTML = "Tambahkan huruf seperti contoh: "+document.getElementById("grup").value+"A"
    }
    function filter_subgr(){
        var data = <?= json_encode($subgr)?>;
        var status=true;
        for(let i=0;i<data.length;i++){
            if(document.getElementById("kdsubgr").value == data[i].kdsubgr){
                status=false
            }
        }
        if(status==true){
            if(document.getElementById("kdsubgr").value == document.getElementById("grup").value){
            document.getElementById("submit").disabled = true
            }else{
                document.getElementById("submit").disabled = false
            }
            document.getElementById("pesan").innerHTML = ""
        }else{
            document.getElementById("submit").disabled = true
            document.getElementById("pesan").innerHTML = "Kode "+document.getElementById("kdsubgr").value+" telah digunakan!"
        }
    }
</script>

