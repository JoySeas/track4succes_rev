<!-- All Jquery -->
<!-- ============================================================== -->

<!-- Bootstrap tether Core JavaScript -->
<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="js/waves.js"></script>
<!--Menu sidebar -->
<script src="js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<!--Custom JavaScript -->
<script src="js/custom.min.js"></script>
<script src="assets/plugins/toast-master/js/jquery.toast.js"></script>
<!-- Chart JS -->
<script src="assets/plugins/bootstrap-table/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
<script src="assets/plugins/bootstrap-table/dist/bootstrap-table-locale-all.min.js"></script>
<script src="assets/plugins/bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script src="js/bootstrap-table.init.js"></script>
<script src="js/toastr.js"></script>
<script>
// $.toast({
//     heading: 'Welcome to Monster admin',
//     text: 'Use the predefined ones, or specify a custom position object.',
//     position: 'top-right',
//     loaderBg: '#ff6849',
//     icon: 'info',
//     hideAfter: 3000,
//     stack: 6
// });
</script>
<!-- Sweet-Alert  -->
<!-- <script src="assets/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script> -->
<!-- <script src="assets/plugins/sweetalert2/sweet-alert.init.js"></script> -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

<script src="assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<!--Custom JavaScript -->
<script src="assets/plugins/moment/moment.js"></script>
<script src="assets/plugins/wizard/jquery.steps.min.js"></script>
<script src="assets/plugins/wizard/jquery.validate.min.js"></script>

<script src="assets/plugins/sweetalert/sweetalert.min.js"></script>
<script src="assets/plugins/wizard/steps.js"></script>

<script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

<script src="assets/plugins/chartist-js/dist/chartist.min.js"></script>
<script src="assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
<script src="assets/plugins/echarts/echarts-all.js"></script>
<!-- <script src="assets/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script> -->
<script src="assets/plugins/tableHeadFixer.js"></script>
<script src="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
<script src="assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB9N071f-dwiyVB3WtyD3KH1LySx4bf6HA"></script>
<script src="assets/gmaps/gmaps.js"></script>
<script src="assets/plugins/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
<script src="js/mask.init.js"></script>

<script type="text/javascript">
    $(document).on('show.bs.modal', '.modal', function () {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
    var zIndex = Math.max.apply(null, Array.prototype.map.call(document.querySelectorAll('*'), function(el) {
      return +el.style.zIndex;
    })) + 10;
    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal:visible').length && $(document.body).addClass('modal-open');
    });
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="assets/plugins/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
    </script>