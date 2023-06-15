<div class="modal fade" id="hapuskeluar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" class="text-center">Hapus Transaksi Barang Masuk</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url("gudang/masuk/hapus")?>" method="post">
                    <div class="modal-body">
                        <input type="text" id="hapusno" name="no" hidden>
                        <input type="text" id="hapuskode" name="kode" hidden>
                        <input type="text" id="hapusqty" name="qty" hidden>
                        <h3 class="text-center">Data akan dihapus secara permanen!</h3><br>
                        <h5 class="text-center">Apakah anda yakin ingin mengahpus?</h5>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
</div>

<script>
    function hapuskeluar(no,kode,qty){
        document.getElementById('hapusno').value = no
        document.getElementById('hapuskode').value = kode
        document.getElementById('hapusqty').value = qty
    }
</script>