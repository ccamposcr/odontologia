<template>
    <div>
        <b-modal id="bv-modal-client-form" hide-footer novalidate="true" @hide="cancelClientForm">
        <template #modal-title>
          Cliente
        </template>
        <div class="d-block">
          <div v-if="errors.length">
              <p>Por favor, corrija el(los) siguiente(s) error(es):</p>
              <ul class="errors-list">
                  <li class="label label-danger" :key="error" v-for="error in errors">{{ error }}</li>
              </ul>
          </div>
          <b-form class="client__new-form">
              <input type="hidden" v-model="clientForm.id">
              <b-form-group label-for="personalID" label="Cédula">
                <b-form-input @blur="checkIfClientAlreadyExists"  v-model="clientForm.personalID" type="text" class="form-control" id="personalID" placeholder="Cédula" :disabled="editingUser"></b-form-input>
              </b-form-group>
              <b-form-group label-for="name" label="Nombre">
                <b-form-input v-model="clientForm.name" type="text" class="form-control" id="name" placeholder="Nombre"></b-form-input>
              </b-form-group>
              <b-form-group label-for="lastName1" label="Primer Apellido">
                <b-form-input v-model="clientForm.lastName1" type="text" class="form-control" id="lastName1" placeholder="Primer Apellido"></b-form-input>
              </b-form-group>
              <b-form-group label-for="lastName2" label="Segundo Apellido">
                <b-form-input v-model="clientForm.lastName2" type="text" class="form-control" id="lastName1" placeholder="Segundo Apellido"></b-form-input>
              </b-form-group>
              <b-form-group label-for="phone" label="Teléfono" v-mask="'####-####'">
                <b-form-input v-model="clientForm.phone" type="text" class="form-control" id="phone" placeholder="Teléfono"></b-form-input>
              </b-form-group>
              <b-form-group label-for="email" label="Email">
                <b-form-input v-model="clientForm.email" type="email" class="form-control" id="email" placeholder="Email"></b-form-input>
              </b-form-group>
              <b-form-group label-for="address" label="Dirección">
                <b-form-input v-model="clientForm.address" type="text" class="form-control" id="address" placeholder="Dirección"></b-form-input>
              </b-form-group>

              <b-button :disabled="actioned" v-if="!editingUser" @click.prevent="checkForm(function(){setNewClient()})" type="submit" variant="primary">
                <b-spinner v-if="actioned" small></b-spinner>
                Agregar
              </b-button>
              <b-button :disabled="actioned" v-if="editingUser" @click.prevent="checkForm(function(){setEditedClient()})" type="submit" variant="primary">
                <b-spinner v-if="actioned" small></b-spinner>
                Guardar
              </b-button>
              <b-button @click.prevent="cancelClientForm" variant="danger">Cancelar</b-button>
          </b-form>
          
        </div>
      </b-modal>
    </div>
</template>
 

<script>
import repositories from '../repositories';

export default {
  name: 'ModalClientForm',
  props: ["clientForm", "editingUser"],
  data () {
    return {
      errors:[],
      URLparams: null,
      actioned: false
    }
  },
  mounted() {
    this.URLparams = this.$route.query;
  },
  methods: {
    checkForm: function(callback){
        this.errors = [];
        if(!this.clientForm.personalID){
            this.errors.push("Ingrese una identificación válida");
        }
        if(!this.clientForm.name){
            this.errors.push("Ingrese un nombre válido");
        }
        if(!this.clientForm.lastName1){
            this.errors.push("Ingrese un primer apellido válido");
        }
        if(!this.clientForm.lastName2){
            this.errors.push("Ingrese un segundo apellido válido");
        }
        if(!this.clientForm.phone){
            this.errors.push("Ingrese un teléfono válido");
        }
        if(!this.clientForm.email && !this.validEmail(this.clientForm.email)){
            this.errors.push("Ingrese un email válido");
        }
        if(!this.clientForm.address){
            this.errors.push("Ingrese una dirección válida");
        }
        if(!this.errors.length){
            callback();
        }
    },
    validEmail: function (email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
    showClientByPersonalID: async function(personalID){
        const data = await repositories.getClientBy('PersonalID', personalID);
        this.$emit('update:users', data.response);
    },
    setNewClient: async function(){
        this.actioned = true;
        const data = await repositories.addNewClient(this.clientForm);

        this.showClientByPersonalID(this.clientForm.personalID);
        this.cancelClientForm();

        this.actioned = false;
        if( this.URLparams.appointmentDate ){
          this.$router.push('/inicio?appointmentDate='+this.URLparams.appointmentDate+'&clientID='+data.clientID);
        }
    },
    setEditedClient: async function(){
        this.actioned = true;
        await repositories.editClient(this.clientForm);

        this.showClientByPersonalID(this.clientForm.personalID);
        this.$bvModal.hide('bv-modal-client-form');
        this.actioned = false;
    },
    clearClientForm: function(){
        for(const item in this.clientForm){
            this.clientForm[item] = null;
        }
        this.clientForm.roleID = '0';
        this.clientForm.status = '1';
        this.errors = [];
    },
    cancelClientForm: function(){
        this.$bvModal.hide('bv-modal-client-form');
        this.clearClientForm();
        if( this.URLparams.appointmentDate ){
          this.$router.push('/inicio?appointmentDate='+this.URLparams.appointmentDate);
        }
    },
    checkIfClientAlreadyExists: async function(){
     
      const data = await repositories.getClientBy('personalID', this.clientForm.personalID);
      const response = data.response;
      if( response.length ){
        this.showClientByPersonalID(this.clientForm.personalID);
        this.$bvModal.hide('bv-modal-client-form');
      }
      
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