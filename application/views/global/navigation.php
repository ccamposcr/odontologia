<div class="navigation">
   <ul class="nav">
      <li class="nav__item" role="presentation"><a class="btn btn btn-secondary" href="<?php echo base_url(); ?>">Inicio</a></li>
      <li class="nav__item" role="presentation"><a class="btn btn btn-secondary" href="<?php echo base_url(); ?>clientes">Clientes</a></li>
      <?php
         if(in_array("7", json_decode($this->session->userdata('roleAccessList'))))
         {
            echo '<li class="nav__item" role="presentation" ><a class="btn btn btn-secondary" href="'. base_url() . 'register">Crear Usuarios</a></li>';
         }
         if(in_array("9", json_decode($this->session->userdata('roleAccessList'))))
         {
            echo '<li class="nav__item" role="presentation"><a class="btn btn btn-secondary" href="'. base_url() . 'clientes?showSystemUsers=true">Editar Usuarios</a></li>';
         }
         if(in_array("8", json_decode($this->session->userdata('roleAccessList'))))
         {
            echo '<li class="nav__item" role="presentation"><a class="btn btn btn-secondary" href="'. base_url() . 'administracion">Administrar</a></li>';
         }
         ?>
   </ul>
</div>

