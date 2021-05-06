<template>
  <div class="inicio">
    <v-row>
      <v-col>
        <v-sheet height="64">
          <v-toolbar
            flat
          >
            <v-btn
              outlined
              class="mr-4"
              color="grey darken-2"
              @click="setToday"
            >
              Hoy
            </v-btn>
            <v-btn
              fab
              text
              small
              color="grey darken-2"
              @click="prev"
            >
              <v-icon small>
                mdi-chevron-left
              </v-icon>
            </v-btn>
            <v-btn
              fab
              text
              small
              color="grey darken-2"
              @click="next"
            >
              <v-icon small>
                mdi-chevron-right
              </v-icon>
            </v-btn>
            <v-toolbar-title v-if="$refs.calendar">
              {{ $refs.calendar.title }}
            </v-toolbar-title>
            <v-spacer></v-spacer>

            <v-menu
              bottom
              right
            >
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  outlined
                  color="grey darken-2"
                  v-bind="attrs"
                  v-on="on"
                >
                  <span>{{ typeToLabel[type] }}</span>
                  <v-icon right>
                    mdi-menu-down
                  </v-icon>
                </v-btn>
              </template>
              <v-list>
                <v-list-item @click="type = 'week'">
                  <v-list-item-title>Semana</v-list-item-title>
                </v-list-item>
                <v-list-item @click="type = 'month'">
                  <v-list-item-title>Mes</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>

          </v-toolbar>
        </v-sheet>
        <v-sheet height="800">
          <v-calendar
            ref="calendar"
            :events="events"
            color="primary"
            :type="type"
            v-model="value"
            @change="fetchEvents"
            @click:event="showEvent"
            @click:time="showAppointmentModal"
            interval-count="14"
            first-time="06:00"
          >
            <template v-slot:day-body="{ date, week }">
              <div
                class="v-current-time"
                :class="{ first: date === week[0].date }"
                :style="{ top: nowY }"
              ></div>
            </template>
          </v-calendar>

          <v-menu
            v-model="selectedOpen"
            :close-on-content-click="false"
            :activator="selectedElement"
            offset-x
          >
            <v-card
              color="grey lighten-4"
              min-width="350px"
              flat
            >
              <v-toolbar
                :color="selectedEvent.color"
                dark
              >
                <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-card-text>
                <span v-html="selectedEvent.details"></span>
              </v-card-text>
              <v-card-actions>
                <v-btn
                  text
                  color="secondary"
                  @click="selectedOpen = false"
                >
                  Cerrar
                </v-btn>
                <v-btn
                  depressed
                  color="primary"
                  :href="selectedEvent.href"
                  v-if="selectedEvent.type=='notification'"
                >
                  Ir al caso
                </v-btn>
                <v-btn
                  depressed
                  color="error"
                  @click="cancelAppointment(selectedEvent.appointmentID)"
                  v-if="checkAccessList('eliminar cita') && selectedEvent.type=='appointment'"
                >
                  Eliminar Cita
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-menu>

        </v-sheet>
      </v-col>
    </v-row>

    <modal-appointment-form :editing-appointment="editingAppointment" :appointment-form="appointmentForm" :date="date"></modal-appointment-form>
  </div>
</template>

<script>
  import ModalAppointmentForm from './ModalAppointmentForm.vue';
  import repositories from '../repositories';
  import global from '../global';

  export default {
    name: 'Inicio',
    components: {ModalAppointmentForm},
    data () {
      return{
        value: '',
        today: '',
        events: [],
        selectedOpen: false,
        selectedElement: null,
        selectedEvent: {},
        type: 'week',
        typeToLabel: {
          month: 'Mes',
          week: 'Semana'
        },
        ready: false,
        appointmentForm: {
          date: null,
          userID: null,
          filterBy: null,
          clientList: []
        },
        editingAppointment: false,
        date:{
          start: null,
          end: null
        }
      }
    },
    computed: {
      cal () {
        return this.ready ? this.$refs.calendar : null
      },
      nowY () {
        return this.cal ? this.cal.timeToY(this.cal.times.now) + 'px' : '-10px'
      },
    },
    mounted () {
      this.$refs.calendar.checkChange();
      this.ready = true;
      this.scrollToTime();
      this.updateTime();
      this.$refs.calendar.scrollToTime('08:00');
      const params = this.$route.query;
      this.loadDataFromURLParams(params);
    },
    methods: {
      checkAccessList: function(action){
        return global.checkAccessList(action);
      },
      setToday: function() {
        this.value = '';
      },
      prev: function() {
        this.$refs.calendar.prev();
      },
      next: function() {
        this.$refs.calendar.next();
      },
      fetchEvents: async function({ start, end }) {
        this.date.start = start;
        this.date.end = end;

        const startDate = this.date.start.date;
        const endDate = this.date.end.date;

        const dataLegalCases = await repositories.getLegalCasesByDateRange('nextNotification', startDate, endDate);
        const responseLegalCases = dataLegalCases.response;

        if( responseLegalCases.length ){
          responseLegalCases.forEach(item => {
            item['name'] = 'Cobro -> N.Exp: ' + item.internalCode + ' -> ' + item.userName + ' ' + item.lastName1;
            item['details'] = 'Siguiente pago: '+ item.start +'<br/>Número de expediente: ' + item.internalCode + '<br/>Cliente: ' + item.userName + ' ' + item.lastName1 + ' ' + item.lastName2;
            item['href'] = base_url + 'clientes?userID=' + item.userID + '&legalCaseID=' + item.legalCaseID;
            item['color'] = 'orange';
            item['type'] = 'notification';
          });
        }

        const dataAppointments = await repositories.getAppointmentsByDateRange('date', startDate, endDate);
        const responseAppointments = dataAppointments.response;

        if( responseAppointments.length ){
          responseAppointments.forEach(item => {
            item['name'] = 'Cita -> ' + item.userName + ' ' + item.lastName1;
            item['details'] = 'Cita: '+ item.date + '<br/>Cliente: ' + item.userName + ' ' + item.lastName1 + ' ' + item.lastName2;
            item['start'] = item.date;
            item['color'] = 'green';
            item['type'] = 'appointment';
          });
        }

        const response = responseLegalCases.concat(responseAppointments);

        this.events = response;
      },
      showEvent: function ({ nativeEvent, event }) {
        const open = () => {
          this.selectedEvent = event
          this.selectedElement = nativeEvent.target
          setTimeout(() => {
            this.selectedOpen = true
          }, 10)
        }

        if (this.selectedOpen) {
          this.selectedOpen = false
          setTimeout(open, 10)
        } else {
          open()
        }

        nativeEvent.stopPropagation()
      },
      getCurrentTime: function() {
        return this.cal ? this.cal.times.now.hour * 60 + this.cal.times.now.minute : 0
      },
      scrollToTime: function() {
        const time = this.getCurrentTime()
        const first = Math.max(0, time - (time % 30) - 30)
        this.cal.scrollToTime(first)
      },
      updateTime: function () {
        setInterval(() => this.cal.updateTimes(), 60 * 1000)
      },
      showAppointmentModal: function({ date, hour }){
        if( this.checkAccessList('agendar cita') ){
          this.$set(this.appointmentForm, 'date', date + ' ' + hour +':00');
          this.$bvModal.show('bv-modal-appointment-form');
        }
      },
      cancelAppointment: async function(appointmentID){
        await repositories.cancelAppointment({id:appointmentID});
        const start = this.date.start;
        const end = this.date.end;
        this.fetchEvents({start, end});
        this.selectedOpen = false;
      },
      loadDataFromURLParams: async function(params){
        if(this.checkAccessList('agendar cita') && params.appointmentDate){
          this.$set(this.appointmentForm, 'date', params.appointmentDate);
          this.$bvModal.show('bv-modal-appointment-form');
        }
        if(this.checkAccessList('agendar cita') && params.clientID){
          this.$set(this.appointmentForm, 'userID', params.clientID);
        }
      }
    }
  }
</script>

<style lang="scss">
  .v-current-time {
    height: 2px;
    background-color: #ea4335;
    position: absolute;
    left: -1px;
    right: 0;
    pointer-events: none;
    &.first::before {
      content: '';
      position: absolute;
      background-color: #ea4335;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      margin-top: -5px;
      margin-left: -6.5px;
    }
  }
  .v-calendar-daily__day-interval{
    cursor: pointer;
  }
</style>