<template>
    <div id="calendar">
        <v-sheet height="64">
            <v-toolbar flat color="white">
                <v-btn outlined class="mr-4" @click="setToday">
                    Today
                </v-btn>
                <v-btn fab text small @click="prev">Prev</v-btn>
                <v-spacer></v-spacer>
                <v-toolbar-title>{{ title }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn fab text small @click="next">Next</v-btn>
            </v-toolbar>
        </v-sheet>
        <v-sheet height="600">
            <v-calendar ref="calendar"
                v-model="focus"
                color="primary"
                :events="events"
                :event-color="getEventColor"
                :event-margin-bottom="3"
                :now="today"
                :type="type"
                @change="updateRange">
            </v-calendar>
        </v-sheet>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import { moment } from 'moment';

    export default {
        name: 'Calendar',
        data() {
            return {
                today: this.moment().format('YYYY-MM-DD'),
                focus: this.moment().format('YYYY-MM-DD'),
                type: 'month',
                start: null,
                end: null,
                events: [],
            }
        },
        watch: {
            calendar_events: function(data) {
                const $this = this;

                if(data.length > 0) {
                    data.forEach(function(item){
                        $this.events.push(item);
                    });
                } else {
                    this.events = [];
                }
            }
        },
        computed: {
            ...mapGetters({
                calendar_events: 'GET_CALENDAR_EVENTS'
            }),
            title: function() {
                const { start, end } = this
                if (!start) {
                    let today_date = new Date();
                    const m = today_date.toLocaleString('default', { month: 'long' });
                    return m + ' ' + today_date.getFullYear();
                }

                let date = new Date(start.date);
                const m = date.toLocaleString('default', { month: 'long' });
                return m + ' ' + date.getFullYear();
            }
        },
        mounted() {
            this.$refs.calendar.checkChange();
        },
        methods: {
            getEventColor(event) {
                return event.color;
            },
            setToday () {
                this.focus = this.today;
            },
            prev () {
                this.$refs.calendar.prev();
            },
            next () {
                this.$refs.calendar.next();
            },
            updateRange ({ start, end }) {
                this.start = start
                this.end = end
            }
        }
    }
</script>

<style>
    .v-event {
        color: #fff;
        text-transform: capitalize;
    }
</style>
