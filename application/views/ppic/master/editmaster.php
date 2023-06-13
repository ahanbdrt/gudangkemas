<div class="modal fade" id="editmaster" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Edit Master</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url("ppic/master/update")?>" method="post">
                    <div class="modal-body">
                        <input type="text" name="id" id="editid" hidden>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="kode">Kode :</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" onkeyup="filter_kode()" readonly name="kode" id="editkode" class="form-control" required>
                                <span class="text-danger" id="error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="nama">Nama Barang :</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" name="nama" id="editnama" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="satuan">Satuan :</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" id="editsatuan" name="satuan" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="grup">Grup :</label>
                            </div>
                            <div class="col-lg-9">
                                <select style="width:100%" name="grup" id="editgrup" required>
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
                                    <select style="width:100%" name="subgr" id="editsubgr">
                                        <?php foreach($subgrup as $sg){?>
                                        <option value="<?= $sg->kdsubgr ?>"><?= $sg->kdsubgr .". ". $sg->namasubgr ?></option>
                                        <?php } ?>
                                    </select>
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
    function editmaster(kode,satuan,nama,grup,subgr,id,namagrup,namasubgrup){
        document.getElementById("editid").value = id
        document.getElementById("editkode").value = kode
        document.getElementById("editsatuan").value = satuan
        document.getElementById("editnama").value = nama
        document.getElementById("editsubgr").value = subgr
        document.getElementById("editgrup").value = grup
        $(document).ready(function() {
        $("#editgrup").select2()
        $("#editsubgr").select2()
        })
    }
</script>
