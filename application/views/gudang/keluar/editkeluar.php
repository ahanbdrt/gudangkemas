<div class="modal fade" id="editkeluar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Transaksi Barang Keluar</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url("gudang/keluar/edit")?>" method="post">
                    <div class="modal-body">
                        <input type="text" id="no" name="no" hidden>
                        <input type="text" id="kodelama" name="kodelama" hidden>
                        <input type="text" id="qtylama" name="qtylama" hidden>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="tglform">Tanggal Form :</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="date" name="tglform" id="tglform" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="noform">No Form :</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" name="noform" id="noform" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="kode">Nama barang :</label>
                            </div>
                            <div class="col-lg-9">
                                <select id="kode" disabled class="form-control" name="kode">
                                    <option value disabled selected>Pilih barang</option>
                                    <?php foreach($master as $m){?>                               
                                        <option value="<?= $m->id?>"><?= $m->kode." || ". $m->nama?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="qty">Jumlah masuk :</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" id="qty" name="qty" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="tgltrima">Tanggal Terima :</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="date" class="form-control" id="tgltrima" name="tgltrima">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label style="font-size:large" for="cat">Catatan :</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="cat" name="cat">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
</div>

<script>
    function edit(tglform,noform,kode,keluar,tgltrima,cat,no){
        document.getElementById('no').value = no
        document.getElementById('tglform').value = tglform
        document.getElementById('noform').value = noform
        document.getElementById('kode').value = kode
        document.getElementById('kodelama').value = kode
        document.getElementById('qty').value = keluar
        document.getElementById('qtylama').value = keluar
        document.getElementById('tgltrima').value = tgltrima
        document.getElementById('cat').value = cat
    }
</script>