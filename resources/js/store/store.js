export default function() {
    return new Vuex.Store({
        state: {
            calendar_events: [],
            show_confirm_delete_modal: false
        },
        mutations: {
            SET_CALENDAR_EVENTS: (state, data) => {
                state.calendar_events = data;
            },
            SET_CONFIRM_DELETE_MODAL: (state, data) => {
                state.show_confirm_delete_modal = data;
            },
        },
        actions: {
            OPEN_CONFIRM_DELETE_MODAL: ({commit}) => {
                commit('SET_CONFIRM_DELETE_MODAL', true);
            },
            CLOSE_CONFIRM_DELETE_MODAL: ({commit}) => {
                commit('SET_CONFIRM_DELETE_MODAL', false);
            },
        },
        getters: {
            GET_CALENDAR_EVENTS: (state) => {
                return state.calendar_events;
            },
        }
    });
}
