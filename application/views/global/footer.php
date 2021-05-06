            <?php $CI =& get_instance(); ?>
            <script type="text/javascript">
                const base_url = '<?php echo base_url();?>';
                let csrf_name = '<?php echo $CI->security->get_csrf_token_name(); ?>';
                let csrf_hash = '<?php echo $CI->security->get_csrf_hash(); ?>';
                const loggedINUserID = '<?php echo $this->session->userdata('id') ?>';
                const loggedINRoleID = '<?php echo $this->session->userdata('roleID') ?>';
                const loggedINRoleAccessList = JSON.parse('<?php echo $this->session->userdata('roleAccessList') ?>');
                const loggedINAccessList = JSON.parse('<?php echo $this->session->userdata('accessList') ?>');
            </script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
            <script type="text/javascript" src="<?php echo base_url();?>public/dist/build.js"></script>
        </div>
    </body>
</html>