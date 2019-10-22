<template>
    <b-container id="calendar-area">
        <b-row>
            <b-col md="4">
                <date-picker></date-picker>
            </b-col>
            <b-col md="8">
                <div class="text-right">
                    <a href="#" class="clear-events-link" @click.prevent="clearCalendarEvents">Clear Events</a>
                </div>
                <calendar></calendar>
            </b-col>
        </b-row>
        <confirm-delete></confirm-delete>
    </b-container>
</template>

<script>
    export default {
        name: 'Dashboard',
        data() {
            return {}
        },
        mounted() {
            this.getAllEvents();
        },
        methods: {
            getAllEvents() {
                axios.get('/api/events')
                    .then(response => {
                        if(response.data.result) {
                            this.$store.commit('SET_CALENDAR_EVENTS', response.data.events);
                        }
                    });
            },
            clearCalendarEvents() {
                this.$store.dispatch('OPEN_CONFIRM_DELETE_MODAL');
            }
        }
    }
</script>
