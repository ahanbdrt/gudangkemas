<form id="form" action="<?=base_url()?>ppic/master/hapus" method="post">
    <input type="text" id="hapusno" name="id" hidden>
</form>

<script>
    function hapus(id){
        document.getElementById('hapusno').value = id
        swal.fire({
            icon:"warning",
            title:"Konfirmasi",
            html:"data akan dihapus selamanya<br>Apakah anda yakin?",
            showCancelButton:true,
            confirmButtonColor:"red",
            confirmButtonText:"Hapus",
            cancelButtonText:"Batal",
        }).then(result=>{
            if(result.isConfirmed){
                document.getElementById("form").submit();
            }
        })
    }
</script>