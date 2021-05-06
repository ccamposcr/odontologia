<div class="welcome">
    <div class="row">
        <div class="col-md-2">
            <a href="<?php echo base_url(); ?>inicio" class="welcome__logo">
                <img width="100px" src="<?php echo base_url(); ?>public/images/logo.jpg"/>
            </a>
        </div>
        <div class="col-md-10">
            <div class="welcome__body">
                <h5 class="welcome__name">Bienvenido: <?php echo $this->session->userdata('fullname')?></h5>
                <a class="btn btn btn-danger" href="<?php echo base_url(); ?>logout">Desconectarse</a>
            </div>
        </div>
    </div>
</div>
