
<div class="container login">
   <div class="row justify-content-center">
      <div class="col-md-12 login__logo-wrap">
         <a href="<?php echo base_url(); ?>inicio" class="login__logo">
            <img width="100px" src="<?php echo base_url(); ?>public/images/logo.jpg"/>
         </a>
      </div>
      <div class="col-md-6">
         <h3>Ingreso</h3>
         
         <div class="panel panel-default">
            <div class="panel-body">
               <?php
                  if($this->session->flashdata('message'))
                  {
                        echo '
                        <div class="alert alert-success">
                           '.$this->session->flashdata("message").'
                        </div>
                        ';
                  }
                  ?>
               <?php
                  $attributes = array('role' => 'form', 'method' => 'post');
                  echo form_open('login/validation', $attributes);
               ?>
                  <div class="form-group">
                     <label>Ingrese su Cédula</label>
                     <input type="text" name="personalID" class="form-control" value="<?php echo set_value('personalID'); ?>" />
                     <span class="text-danger"><?php echo form_error('personalID'); ?></span>
                  </div>

                  <div class="form-group">
                     <label>Ingrese su Contraseña</label>
                     <input type="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>" />
                     <span class="text-danger"><?php echo form_error('password'); ?></span>
                  </div>
                  
                  <div class="form-group">
                     <input type="submit" name="login" value="Login" class="btn btn-primary" />
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>