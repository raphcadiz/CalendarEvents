<template>
    <b-modal v-model="showModal" centered ok-only no-close-on-esc no-close-on-backdrop hide-header-close title="Confirm Delete">
        <div v-html="modalMessage"></div>
        <template slot="modal-footer">
            <b-button variant="info" @click="clearCalendarEvents">Proceed</b-button>
            <b-button @click="$store.dispatch('CLOSE_CONFIRM_DELETE_MODAL')">Cancel</b-button>
        </template>
    </b-modal>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        name: "ConfirmDelete",
        data() {
            return {
                modalMessage: 'Are you sure to delete all events?',
                showModal: false
            }
        },
        computed: {
            ...mapState({
                show_confirm_delete_modal: 'show_confirm_delete_modal',
            })
        },
        watch: {
            show_confirm_delete_modal: function (state) {
                this.showModal = state;
            }
        },
        methods: {
            clearCalendarEvents() {
                axios.post('/api/events/clear')
                    .then(response => {
                        if(response.data.result) {
                            this.$store.commit('SET_CALENDAR_EVENTS', []);
                            this.$store.dispatch('CLOSE_CONFIRM_DELETE_MODAL');
                        }
                    });
            }
        }
    }
</script>
