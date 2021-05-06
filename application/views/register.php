
<div class="container">
   
   <h3>Crear Usuarios</h3>
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
   

   <div class="panel panel-default">
      <div class="panel-body">
         <?php
            $attributes = array('role' => 'form', 'method' => 'post');
            echo form_open('register/validation', $attributes);
         ?>
            <div class="form-group">
               <label>Seleccione el rol del usuario</label>
               <select class="form-control" name="roleID" value="<?php echo set_value('roleID'); ?>">
                  <?php foreach ($roleList as $key => $value): ?>
                     <option value="<?= $value->id; ?>" ><?= $value->role; ?></option>
                  <?php endforeach; ?>
               </select>
               <span class="text-danger"><?php echo form_error('roleID'); ?></span>
            </div>
            <div class="form-group">
               <label>Ingrese la cédula del usuario</label>
               <input type="text" name="personalID" class="form-control" value="<?php echo set_value('personalID'); ?>" />
               <span class="text-danger"><?php echo form_error('personalID'); ?></span>
            </div>
            <div class="form-group">
               <label>Ingrese el nombre del usuario</label>
               <input type="text" name="name" class="form-control" value="<?php echo set_value('name'); ?>" />
               <span class="text-danger"><?php echo form_error('name'); ?></span>
            </div>
            <div class="form-group">
               <label>Ingrese el primer apellido del usuario</label>
               <input type="text" name="lastName1" class="form-control" value="<?php echo set_value('lastName1'); ?>" />
               <span class="text-danger"><?php echo form_error('lastName1'); ?></span>
            </div>
            <div class="form-group">
               <label>Ingrese un segundo apellido del usuario</label>
               <input type="text" name="lastName2" class="form-control" value="<?php echo set_value('lastName2'); ?>" />
               <span class="text-danger"><?php echo form_error('lastName2'); ?></span>
            </div>
            <!--<div class="form-group">
               <label>Ingrese su correo electrónico</label>
               <input type="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>" />
               <span class="text-danger"><?php echo form_error('email'); ?></span>
            </div>-->
            <div class="form-group">
               <label>Ingrese una contraseña</label>
               <input type="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>" />
               <span class="text-danger"><?php echo form_error('password'); ?></span>
            </div>
            <div class="form-group">
               <label>Confirmar contraseña</label>
               <input type="password" name="confirmPassword" class="form-control" value="<?php echo set_value('confirmPassword'); ?>" />
               <span class="text-danger"><?php echo form_error('confirmPassword'); ?></span>
            </div>
            <div class="form-group">
               <input type="submit" name="register" value="Crear" class="btn btn-primary" />
            </div>
         </form>
      </div>
   </div>
</div>
 