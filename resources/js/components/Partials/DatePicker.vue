<template>
    <b-container id="date-picker">
        <b-row v-if="errors.length > 0">
            <b-col md="12">
                <div class="alert alert-danger" v-for="error in errors" role="alert">
                    <p>{{error}}</p>
                </div>
            </b-col>
        </b-row>
        <b-row v-if="success">
            <b-col md="12">
                <div class="alert alert-success" role="alert">
                    <p>Event successfully added.</p>
                </div>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <label for="event-name">Event</label>
                <b-form-input id="event-name" v-model="event_name" type="text"></b-form-input>
            </b-col>
        </b-row>
        <!-- <b-row>
            <b-col md="12">
                <label>Color</label>
                <v-color-picker
                    v-model="color"
                    :hide-canvas="false"
                    :hide-inputs="false"
                    :hide-mode-switch="true"
                    :mode="'hexa'"
                    :show-swatches="false"
                    class="mx-auto"
                    >
                </v-color-picker>
            </b-col> -->
        </b-row>
        <b-row>
            <v-app id="date-picker-fields">
                <b-col md="6" class="event-startdate-grp">
                    <label for="event-startdate">Start</label>
                    <v-menu
                        ref="startMenu"
                        v-model="startMenu"
                        :close-on-content-click="false"
                        :return-value.sync="start"
                        :top="true"
                        :right="true"
                        transition="scale-transition"
                        min-width="290px"
                        offset-y>
                        <template v-slot:activator="{ on }">
                            <v-text-field v-model="start" readonly v-on="on"></v-text-field>
                        </template>
                        <v-date-picker v-model="start" no-title scrollable>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="startMenu = false">Cancel</v-btn>
                            <v-btn text color="primary" @click="$refs.startMenu.save(start)">OK</v-btn>
                        </v-date-picker>
                    </v-menu>
                </b-col>
                <b-col md="6" class="event-enddate-grp">
                    <label>End</label>
                    <v-menu
                        ref="endMenu"
                        v-model="endMenu"
                        :close-on-content-click="false"
                        :return-value.sync="end"
                        :top="true"
                        :right="true"
                        transition="scale-transition"
                        min-width="290px"
                        offset-y>
                        <template v-slot:activator="{ on }">
                            <v-text-field v-model="end" readonly v-on="on"></v-text-field>
                        </template>
                        <v-date-picker v-model="end" no-title scrollable>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="endMenu = false">Cancel</v-btn>
                            <v-btn text color="primary" @click="$refs.endMenu.save(end)">OK</v-btn>
                        </v-date-picker>
                    </v-menu>
                </b-col>
            </v-app>
        </b-row>
        <b-row>
            <b-col md="12" id="days-fields">
                <v-checkbox v-model="days" label="Mon" value="Monday"></v-checkbox>
                <v-checkbox v-model="days" label="Tue" value="Tuesday"></v-checkbox>
                <v-checkbox v-model="days" label="Wed" value="Wednesday"></v-checkbox>
                <v-checkbox v-model="days" label="Thu" value="Thursday"></v-checkbox>
                <v-checkbox v-model="days" label="Fri" value="Friday"></v-checkbox>
                <v-checkbox v-model="days" label="Sat" value="Saturday"></v-checkbox>
                <v-checkbox v-model="days" label="Sun" value="Sunday"></v-checkbox>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12" class="text-right">
                <v-app>
                    <v-btn large color="primary" @click="submitEvent" :class="submitting ? 'submitting' : ''">
                        <i class="fa fa-spinner fa-spin" v-show="submitting"></i>
                        {{submitting ? 'Saving' : 'Save'}}
                    </v-btn>
                </v-app>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    export default {
        name: 'DatePicker',
        data() {
            return {
                event_name: '',
                startMenu: false,
                start: this.moment().startOf('month').format('YYYY-MM-DD'),
                endMenu: false,
                end: this.moment().endOf('month').format('YYYY-MM-DD'),
                color: '#04ce04b8',
                days: [],
                errors: [],
                success: false,
                submitting: false
            }
        },
        methods: {
            submitEvent() {
                this.success = false;
                this.errors = [];

                if(this.event_name === '') {
                    this.errors.push('Event name is empty.');
                }

                const sdate = this.moment(this.start);
                const edate = this.moment(this.end);
                if(edate.diff(sdate, 'days') < 0) {
                    this.errors.push('Start Date must not overlap End Date.');
                }

                if(this.errors.length > 0) {
                    window.scrollTo(0, 0);
                    return;
                }

                this.submitting = true;

                let data = {
                    name: this.event_name,
                    start_date: this.start,
                    end_date: this.end,
                    color: this.color
                };

                if(this.days.length > 0) {
                    data['days'] = this.days;
                }

                axios.post('/api/event/save', data)
                    .then(response => {
                        if(response.data.result) {
                            this.$store.commit('SET_CALENDAR_EVENTS', response.data.events);
                            window.scrollTo(0, 0);
                            this.success = true;
                        }
                        this.submitting = false;
                        this.resetFields();
                    });
            },
            resetFields() {
                this.event_name = '';
                this.start = this.moment().format('YYYY-MM-DD');
                this.end = this.moment().format('YYYY-MM-DD');
                this.color = '#2196F3';
                this.days =  [];
            }
        }
    }
</script>
