<template>
  <div class="client">
    <b-button variant="info" v-if="!systemUsersInterface" @click="showSearchClientModal">Buscar Cliente</b-button>
    <b-button variant="success" v-if="!systemUsersInterface && checkAccessList('agregar cliente')"  @click="showClientFormModal">Agregar Cliente Nuevo</b-button>
    <b-button variant="primary" :disabled="actioned" v-if="!systemUsersInterface" @click="showAllClients">
      <b-spinner v-if="actioned" small></b-spinner>
      Ver todos los Clientes
    </b-button>

    <div v-show="users.length">
      <ul class="client__list">
        <li class="list__user" v-bind:key="user.id" v-for="user in users">
          <p v-if="user.personalID"><strong>C&eacute;dula:</strong> {{ user.personalID }}</p>
          <p v-if="user.name"><strong>Nombre:</strong> <span class="user__name">{{ user.name }} {{ user.lastName1 }} {{ user.lastName2 }}</span></p>
          <p v-if="user.phone" ><strong>Tel&eacute;fono:</strong> {{ user.phone }}</p>
          <p v-if="user.email"><strong>Email:</strong> {{ user.email }}</p>
          <p v-if="user.address"><strong>Direcci&oacute;n:</strong> {{ user.address }}</p>
          <p v-if="user.role"><strong>Rol:</strong> {{ user.role }}</p>
          <div class="user__options">
            <b-button v-if="!systemUsersInterface && checkAccessList('editar cliente')" @click="fillEditClientForm(user.id)" variant="info">Editar Cliente</b-button>
            <b-button v-if="!systemUsersInterface && checkAccessList('agregar caso')" @click="showLegalCaseForm(user.id)" variant="success">Agregar Caso</b-button>
            <b-button :disabled="actioned" v-if="!systemUsersInterface" @click="showLegalCases(user.id)" variant="primary">
              <b-spinner v-if="actioned" small></b-spinner>
              Ver Casos
            </b-button>
            <b-button v-if="user.role != 'Administrador' && systemUsersInterface && checkAccessList('eliminar usuarios')" @click="deleteUser(user.id)" variant="danger">Eliminar Usuario</b-button>
            <b-button v-if="systemUsersInterface" @click="updatePassword(user.id)" variant="success">Cambiar Contraseña</b-button>
          </div>

          <div v-if="legalCases[user.id]">
            <ul class="user__legal-cases">
              <li class="legal-cases__case" v-bind:key="legalCase.id" v-for="legalCase in legalCases[user.id]">
                <p v-if="legalCase.internalCode"><strong>Número de expediente:</strong> {{ legalCase.internalCode }}</p>
                <p v-if="legalCase.subject"><strong>Naturaleza de expediente:</strong> {{ legalCase.subject }}</p>
                <p v-if="legalCase.judicialStatus"><strong>Estado judicial:</strong> {{ legalCase.judicialStatus }}</p>
                <p v-if="legalCase.administrativeStatus"><strong>Estado administrativo:</strong> {{ legalCase.administrativeStatus }}</p>
                <p v-if="legalCase.location"><strong>Ubicación del expediente:</strong> {{ legalCase.location }}</p>
                <p v-if="legalCase.nextNotification"><strong>Fecha de siguiente pago:</strong> {{legalCase.nextNotification}}</p>
                <div class="case__options">
                  <b-button v-if="checkAccessList('editar caso')" @click="fillLegalCaseForm(legalCase.legalCaseID, user.id)" variant="info">Editar Caso</b-button>
                  <b-button :disabled="actioned" @click="showLegalCaseNotes(legalCase.legalCaseID)" variant="primary">
                    <b-spinner v-if="actioned" small></b-spinner>
                    Ver notas
                  </b-button>
                </div>

                <div v-if="legalCaseNotes[legalCase.legalCaseID]">
                  
                  <ul class="legal-cases__notes">
                    <li class="notes__note" v-bind:key="legalCaseNote.id" v-for="legalCaseNote in legalCaseNotes[legalCase.legalCaseID]">
                      <p v-if="legalCaseNote.note"><strong>Nota:</strong> {{ legalCaseNote.note }}</p>
                      <p v-if="legalCaseNote.name"><strong>Hecha por:</strong> {{ legalCaseNote.name }} {{ legalCaseNote.lastName1 }} {{ legalCaseNote.lastName2 }}</p>
                      <p v-if="legalCaseNote.date"><strong>Fecha:</strong> {{ legalCaseNote.date }}</p>
                    </li>
                  </ul>
                  <span v-if="legalCaseNotes[legalCase.legalCaseID] && !legalCaseNotes[legalCase.legalCaseID].length">No hay notas</span>
                </div>

              </li>
            </ul>
          </div>
          <span v-if="legalCases[user.id] && !legalCases[user.id].length">No hay casos</span>

        </li>
      </ul>
    </div>

    <modal-client-form :client-form="clientForm" :editing-user="editingUser" :users.sync="users"></modal-client-form>
    <modal-search-form :search-client-form="searchClientForm" :users.sync="users"></modal-search-form>
    <modal-legal-case-form :legal-case-form="legalCaseForm" :editing-legal-case="editingLegalCase" :static-data="staticData" :legal-case-user-id="legalCaseUserId" :today="today"></modal-legal-case-form>
    <modal-update-password-form :update-password-form="updatePasswordForm" :update-password-user-id="updatePasswordUserId"></modal-update-password-form>
  </div>
</template>

<script>
import ModalClientForm from './ModalClientForm.vue';
import ModalSearchForm from './ModalSearchForm.vue';
import ModalLegalCaseForm from './ModalLegalCaseForm.vue';
import ModalUpdatePasswordForm from './ModalUpdatePasswordForm.vue';
import repositories from '../repositories';
import global from '../global';

export default {
  name: 'Client',
  components: {ModalClientForm, ModalSearchForm, ModalLegalCaseForm, ModalUpdatePasswordForm},
  data () {
    return {
      staticData:{
        judicialStatusList: [],
        subjectList: [],
        administrativeStatusList: [],
        locationList: []
      },
      users: [],
      clientForm:{
        id:null,
        personalID:null,
        name: null,
        lastName1: null,
        lastName2: null,
        phone: null,
        email: null,
        address: null,
        roleID:'0',
        status: '1'
      },
      legalCaseForm:{
        id: null,
        internalCode: null,
        subjectID: null,
        userID: null,
        judicialStatusID: null,
        administrativeStatusID: null,
        note: null,
        nextNotification: null,
        legalCaseID: null,
        locationID: null
      },
      searchClientForm:{
        personalID: null,
        name: null,
        lastName1: null,
        lastName2: null,
        searchBy: 'personalID'
      },
      updatePasswordForm:{
        password: null,
        confirmPassword: null
      },
      legalCases: [],
      editingLegalCase: false,
      legalCaseUserId: null,
      today: '',
      editingUser: false,
      legalCaseNotes: [],
      locationStaticData: {'999': 'Archivo'},
      systemUsersInterface: false,
      updatePasswordUserId: null,
      actioned: false
    }
  },
  created(){
    this.getStaticDataFromDB();
  },
  mounted() {
    const params = this.$route.query;
    this.loadDataFromURLParams(params);
  },
  methods: {
    checkAccessList: function(action){
      return global.checkAccessList(action);
    },
    getStaticDataFromDB: async function(){

      const judicialStatusListData = await repositories.getJudicialStatusList();
      this.staticData.judicialStatusList = judicialStatusListData.response;

      const subjectListData = await repositories.getSubjectList();
      this.staticData.subjectList = subjectListData.response;
      
      const administrativeStatusListData = await repositories.getAdministrativeStatusList();
      this.staticData.administrativeStatusList = administrativeStatusListData.response;

      const locationListData = await repositories.getClientBy('roleID !=', '0');
      this.staticData.locationList = locationListData.response;

      this.staticData.locationList.forEach(item => {
        item['location'] = item.name + ' ' + item.lastName1 + ' ' + item.lastName2;  
      });
      this.staticData.locationList.push({'location': this.locationStaticData['999'], 'id': '999'});
    },
    showAllClients: async function(){
      this.actioned = true;
      this.resetClientVars();

      const data = await repositories.getAllClients();
      this.users = data.response;
      this.actioned = false;
    },
    showAllUsers: async function(){
      this.resetClientVars();

      const data = await repositories.getAllUsers();
      this.users = data.response;
    },
    showSearchClientModal: function(){
      this.$bvModal.show('bv-modal-search-form');
    },
    showClientFormModal: function(){
      if( this.checkAccessList('agregar cliente') ){
        this.editingUser = false;
        this.$bvModal.show('bv-modal-client-form');
      }
    },
    showLegalCases: async function(userID){      
      this.actioned = true;  
      const data = await repositories.getLegalCasesBy('userID', userID);
      data.response.forEach(item => {
        item['location'] = item.locationID != '999' ? item.location = item.name + ' ' + item.lastName1 + ' ' + item.lastName2 : this.locationStaticData['999'];
      });
      this.$set(this.legalCases, userID, data.response);
      this.actioned = false;
    },
    fillEditClientForm: async function(id){
      if( this.checkAccessList('editar cliente') ){
        const data = await repositories.getClientBy('id', id);
        const response = data.response;
        if( response.length ){
          this.clientForm = response[0];
          this.editingUser = true;
          this.$bvModal.show('bv-modal-client-form');
        }
      }
    },
    fillLegalCaseForm: async function(legalCaseID, userID){
      if( this.checkAccessList('editar caso') ){
        this.legalCaseUserId = userID;
        const data = await repositories.getLegalCasesBy('id', legalCaseID);
        const response = data.response;
        if( response.length ){
          this.legalCaseForm = response[0];
          this.legalCaseForm['id'] = legalCaseID;
          this.editingLegalCase = true;
          this.$bvModal.show('bv-modal-legal-case-form');
        }
      }
    },
    showLegalCaseNotes: async function(legalCaseID){
      this.actioned = true;
      const data = await repositories.getLegalCaseNotesBy('legalCaseID', legalCaseID);
      this.$set(this.legalCaseNotes, legalCaseID, data.response);
      this.actioned = false;
    },
    resetClientVars: function(){
      this.legalCases = [];
      this.legalCaseNotes = [];
    },
    showLegalCaseForm: async function(userID){
      if( this.checkAccessList('agregar caso') ){
        this.editingLegalCase = false;
        this.legalCaseUserId = userID;
        this.$bvModal.show('bv-modal-legal-case-form');
      }
    },
    loadDataFromURLParams: async function(params){
      if(params.userID){
        const clientData = await repositories.getClientBy('id', params.userID);
        const response = clientData.response;
        if( response.length ){
          this.users = response;
        }
      }
      if(params.legalCaseID){
        const legalCasedata = await repositories.getLegalCasesBy('id', params.legalCaseID);
        const response = legalCasedata.response;
        if( response.length ){
          legalCasedata.response.forEach(item => {
            item['location'] = item.locationID != '999' ? item.location = item.name + ' ' + item.lastName1 + ' ' + item.lastName2 : this.locationStaticData['999'];
          });
          this.$set(this.legalCases, params.userID, legalCasedata.response);
        }
      }
      if(params.showNewClientForm){
        if( this.checkAccessList('agregar cliente') ){
          this.showClientFormModal();
        }else{
          window.location.href = base_url + 'denied';
        }
      }

      if(params.showSystemUsers){
        if( this.checkAccessList('administrar') ){
          this.systemUsersInterface = true;
          this.showAllUsers();
        }else{
          window.location.href = base_url + 'denied';
        }
      }
    },
    deleteUser: async function(userID){
      const data = {};
      data['id'] = userID;
      await repositories.deleteUser(data);
      this.showAllUsers();
    },
    updatePassword: async function(userID){
      this.updatePasswordUserId = userID;
      this.$bvModal.show('bv-modal-update-password-form');
    }
  }
}
</script>

<style lang="scss" scoped>
  .client{
    .btn{
      margin-right: 10px;
      margin-bottom: 10px;
      &:last-child{
        margin-right: 0;
      }
    }
    &__list{
      list-style-type: none;
      padding: 0;
      margin-top: 30px;
    }
    .list{
      &__user{
        background-color: #fafafa;
        margin-bottom: 15px;
        padding: 15px;
        p{
          margin-bottom: 0;
        }
      }
    }
    .user{
      &__legal-cases{
        list-style-type: none;
        padding: 0;
        display: flex;
        flex-wrap: wrap;
        background-color: #e4e4e4;
        margin-top: 30px;
      }
      &__name{
        font-size: 20px;
        font-weight: bold;
      }
      &__options{
        margin-top: 30px;
      }
    }
    .legal-cases{
      &__case{
        padding: 15px;
        flex: 1 1 50%;
        border-bottom: 1px solid gray;

        &:nth-child(odd){
          border-right: 1px solid gray;
        }
      }
      &__notes{
        list-style-type: none;
        padding: 0;
        background-color: #fafafa;
        margin-top: 30px;
      }
    }
    .case{
      &__options{
        margin-top: 30px;
      }
    }
    .notes{
      &__note{
        padding: 15px;
        border-bottom: 1px solid gray;
        &:last-child{
          border-bottom: none;
        }
      }
    }
  }
</style>
