<!-- Vendor js -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/custombox/custombox.min.js"></script>

<!-- Plugin js-->
<?php if (!empty($load_select2)): ?>
<script src="<?= base_url('assets/libs/select2/select2.min.js'); ?>"></script>
<?php endif; ?>
<script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>

<!-- Validation init js-->
<script src="<?= base_url(); ?>assets/js/pages/form-validation.init.js"></script>

<!-- App js -->
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

</body>
</html>