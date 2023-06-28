
            <!-- Footer -->
            <footer class="sticky-footer bg-white mt-3">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; PT. INDOSAR 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih Logout jika ingin mengakhiri sesi.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url()?>auth/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?=base_url()?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=base_url()?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=base_url()?>assets/js/sb-admin-2.min.js"></script>

     <!-- Page level plugins -->
    <script src="<?=base_url()?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url()?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url()?>assets/vendor/datatables/dataTables.buttons.min.js"></script>
    <script src="<?= base_url()?>assets/vendor/datatables/buttons.flash.min.js"></script>
    <script src="<?= base_url()?>assets/vendor/datatables/jszip.min.js"></script>
    <script src="<?= base_url()?>assets/vendor/datatables/pdfmake.min.js"></script>
    <script src="<?= base_url()?>assets/vendor/datatables/vfs_fonts.js"></script>
    <script src="<?= base_url()?>assets/vendor/datatables/buttons.html5.min.js"></script>
    <script src="<?= base_url()?>assets/vendor/datatables/buttons.print.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?=base_url()?>assets/js/demo/datatables-demo.js"></script>

    <!-- selectize -->
    <script src="<?=base_url()?>assets/vendor/selectize/selectize.min.js"></script>

    <!-- sweetalert  -->
    <!-- <script src="<?= base_url()?>assets/vendor/sweetalert2/sweetalert2.min.js"></script> -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
