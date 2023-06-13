<div class="modal fade" id="tambahmaster" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Tambah Master</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url("ppic/master/tambah")?>" method="post">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="kode">Kode :</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" onkeyup="filter_kode()" name="kode" id="kode" class="form-control" required>
                                <span class="text-danger" id="error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="nama">Nama Barang :</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="satuan">Satuan :</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" id="satuan" name="satuan" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="grup">Grup :</label>
                            </div>
                            <div class="col-lg-9">
                                <select onchange="filter_grup()" name="grup" id="grup" required>
                                    <option value disabled selected>Pilih Grup</option>
                                    <?php foreach($grup as $g){?>
                                    <option value="<?= $g->kdgrup ?>"><?= $g->kdgrup .". ". $g->namagrup ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="subgr">Sub Grup :</label>
                            </div>
                            <div class="col-lg-9">
                                <div id="subgrup">
                                    <select name="subgr" id="subgr" required>
                                        <option value disabled selected>Pilih Sub Grup</option>
                                        <?php foreach($subgrup as $g){?>
                                        <option value="<?= $g->kdsubgr ?>"><?= $g->kdsubgr .". ". $g->namasubgr ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
</div>

<script>
    $(document).ready(function(){
        $("#subgr").selectize();
        $("#grup").selectize();
    });
    function filter_kode(){
        var data = <?= json_encode($master) ?>;
        var status = true
        for(let i=0;i<data.length;i++){
            if(document.getElementById("kode").value == data[i].kode){
                status = false
            }
        }
        if(status==true){
            document.getElementById("submit").disabled = false
            document.getElementById("error").innerHTML = "" 
        }else{
            document.getElementById("submit").disabled = true
            document.getElementById("error").innerHTML = "Kode "+ document.getElementById("kode").value + " telah digunakan!" 
        }
    }
    function filter_grup(){
        var grup = document.getElementById("grup").value;
        $.ajax({
            dataType : "json",
            url : "<?= base_url('ppic/master/getsubgr') ?>",
            async : true,
            method : "post",
            data : {
                grup:grup
            },
            success: function(data){
                var text = ''
                text+='<select name="subgr" id="subgr" required>';
                text+='<option value disabled selected>Pilih Sub Grup</option>';
                for(let i=0;i<data.length;i++){
                    console.log(data[i].kdsubgr);
                    text+='<option value="'+data[i].kdsubgr+'">'+data[i].kdsubgr+' '+data[i].namasubgr+'</option>'
                }
                text+='</select>'
                $("#subgrup").html(text);
                $("#subgr").selectize();
            }
        })
    }
</script>