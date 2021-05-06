<template>
  <div>
    <b-modal id="bv-modal-appointment-form" hide-footer novalidate="true" @hide="cancelAppointmentForm" @show="getAllClients">
    <template #modal-title>
      Citas
    </template>
    <div class="d-block">
      <div v-if="errors.length">
          <p>Por favor, corrija el(los) siguiente(s) error(es):</p>
          <ul class="errors-list">
              <li class="label label-danger" :key="error" v-for="error in errors">{{ error }}</li>
          </ul>
      </div>
      <b-form class="appointment__new-form">
          <b-form-group>
            <div><strong>Fecha y Hora de la Cita:</strong> {{appointmentForm.date}}</div>
          </b-form-group>
          <b-form-group label-for="filter" label="Filtrar cliente por">
            <b-form-input @keyup="filter" v-model="appointmentForm.filterBy" type="text" class="form-control" id="filter" placeholder="Filtre por Cédula, o el Nombre, o el Apellido"></b-form-input>
          </b-form-group>
          <b-form-group label-for="client" label="Seleccione el cliente">
            <b-form-select id="client" v-model="appointmentForm.userID" :options="appointmentForm.clientList" value-field="id" text-field="client"></b-form-select>
          </b-form-group>

          <b-button :disabled="actioned" @click.prevent="checkForm(function(){setNewAppointment()})" type="submit" variant="primary">
            <b-spinner v-if="actioned" small></b-spinner>
            Agendar
          </b-button>
          <b-button @click.prevent="cancelAppointmentForm" variant="danger">Cancelar</b-button>

          <b-form-group label="En caso de que el cliente no exista, presione el botón Agregar Cliente Nuevo">
            <b-button @click="$router.push('/clientes?showNewClientForm=true&appointmentDate='+appointmentForm.date)" variant="success">Agregar Cliente Nuevo</b-button>
          </b-form-group>
      </b-form>
      
    </div>
  </b-modal>
</div>
</template>

<script>
import repositories from '../repositories';

export default {
  name: 'ModalAppointmentForm',
  props: ["appointmentForm", "editingAppointment", "date"],
  data () {
    return {
      errors:[],
      clientList: [],
      actioned: false
    }
  },
  methods: {
    checkForm: function(callback){
        this.errors = [];
        if(!this.appointmentForm.userID){
            this.errors.push("Seleccione un cliente");
        }
        if(!this.errors.length){
            callback();
        }
    },
    clearAppointmentForm: function(){
      this.appointmentForm['filterBy'] = null;
      this.errors = [],
      this.appointmentForm['clientList'] = this.clientList;
    },
    cancelAppointmentForm: function(){
      this.$bvModal.hide('bv-modal-appointment-form');
      this.clearAppointmentForm();
    },
    getAllClients: async function(){
      const data = await repositories.getAllClients();
      this.clientList = data.response;
      this.clientList.forEach(item => {
        item['client'] = item.personalID + ' -> ' + item.name + ' ' + item.lastName1 + ' ' + item.lastName2;
        item['userID'] = item.id;
      });
      this.$set(this.appointmentForm, 'clientList', this.clientList);
    },
    filter: function(){
      this.appointmentForm['clientList'] =  this.clientList.filter((client) => {
          return client.personalID.toLowerCase().includes(this.appointmentForm.filterBy.toLowerCase()) ||
                client.name.toLowerCase().includes(this.appointmentForm.filterBy.toLowerCase()) ||
                client.lastName1.toLowerCase().includes(this.appointmentForm.filterBy.toLowerCase()) ||
                client.lastName2.toLowerCase().includes(this.appointmentForm.filterBy.toLowerCase());
      });
    },
    setNewAppointment: async function(){
      this.actioned = true;
      await repositories.addNewAppointment(this.appointmentForm);
      this.cancelAppointmentForm();
      const start = this.date.start;
      const end = this.date.end;
      this.$parent.fetchEvents({start, end});
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
