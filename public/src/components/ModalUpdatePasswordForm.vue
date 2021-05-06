<template>
    <div>
        <b-modal id="bv-modal-update-password-form" hide-footer novalidate="true" @hide="cancelUpdatePasswordForm">
            <template #modal-title>
            Cambiar Contraseña
            </template>
            <div class="d-block">
                <div v-if="errors.length">
                    <p>Por favor, corrija el(los) siguiente(s) error(es):</p>
                    <ul class="errors-list">
                        <li class="label label-danger" :key="error" v-for="error in errors">{{ error }}</li>
                    </ul>
                </div>
                <b-form class="client__update-password-form">
                    <b-form-group label-for="password" label="Contraseña">
                        <b-form-input v-model="updatePasswordForm.password" type="password" class="form-control" id="password" placeholder="Contraseña"></b-form-input>
                    </b-form-group>
                    <b-form-group label-for="confirmPassword" label="Confirmar contraseña">
                        <b-form-input v-model="updatePasswordForm.confirmPassword" type="password" class="form-control" id="confirmPassword" placeholder="Contraseña"></b-form-input>
                    </b-form-group>
                    <b-button :disabled="actioned" @click.prevent="checkForm(function(){updatePassword()})" type="submit" variant="primary">
                        <b-spinner v-if="actioned" small></b-spinner>
                        Actualizar
                    </b-button>
                    <b-button @click.prevent="cancelUpdatePasswordForm" variant="danger">Cancelar</b-button>
                </b-form>

            </div>
        </b-modal>
    </div>
</template>
 

<script>
import repositories from '../repositories';

export default {
  name: 'ModalUpdatePasswordForm',
  props: ["updatePasswordForm", "updatePasswordUserId"],
  data () {
    return {
        errors:[],
        actioned: false
    }
  },
  methods: {
    checkForm: function(callback){
        this.errors = [];
        if(!this.updatePasswordForm.password){
            this.errors.push("Ingrese una contraseña");
        }
        if(this.updatePasswordForm.password != this.updatePasswordForm.confirmPassword){
            this.errors.push("Ambas contraseñas deben ser iguales");
        }
        if(!this.errors.length){
            callback();
        }
    },
    clearUpdatePasswordForm: function(){
        for(const item in this.updatePasswordForm){
            this.updatePasswordForm[item] = null;
        }
        this.errors = [];
    },
    cancelUpdatePasswordForm: function(){
        this.$bvModal.hide('bv-modal-update-password-form');
        this.clearUpdatePasswordForm();
    },
    updatePassword: async function(){
        this.actioned = true; 
        await repositories.updatePassword(this.updatePasswordUserId, this.updatePasswordForm);
        this.cancelUpdatePasswordForm();
        this.actioned = false;
      }
  }
}
</script>

<style lang="scss" scoped>
.errors-list{
    list-style-type: decimal;
    padding-left: 16px;
    color: red;
}
</style>