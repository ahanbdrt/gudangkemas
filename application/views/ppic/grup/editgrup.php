<div class="modal fade" id="editmodal" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Edit Grup</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url("ppic/grup/edit")?>" method="post">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="kode">Kode Grup:</label>
                            </div>
                            <div class="col-lg-9">
                                <select onchange="getkdsubgr()" style="width:100%" id="editkdgrup" name="kdgrup" required>
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
                                <input type="text" onkeyup="filter_subgr()" class="form-control" id="editkdsubgr" name="kdsubgr" required>
                                <span id="pesan" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="kode">Nama sub Grup:</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="namasubgr" id="editnamasubgr" required>
                            </div>
                        </div>
                    </div>
                    <input type="text" id="editid" name="id" hidden>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button id="submit" type="submit" id="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
</div>

<script>
    function edit(id,kdgrup,kdsubgr,namasubgr){
        document.getElementById("editid").value = id;
        document.getElementById("editkdgrup").value = kdgrup;
        document.getElementById("editkdsubgr").value = kdsubgr;
        document.getElementById("editnamasubgr").value = namasubgr;
        $(document).ready(function(){
        $("#editkdgrup").select2();
    })
    }
</script>

