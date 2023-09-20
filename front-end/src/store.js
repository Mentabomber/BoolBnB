import { reactive } from "vue";

export const store = reactive({
    local_host: 'http://localhost:8000',
    API_URL: 'http://localhost:8000/api/v1',
    user_email: undefined,
    user_name: undefined,
    user_surname: undefined,
    user_message: "",
    user_email_apartment_id: "",
    searched_address: undefined,
    searched_latitude: undefined,
    searched_longitude: undefined,
    apartments_filtered: [],
    services_list: [],
    apartmentsSearch: [],
    activeFilterServices: [],
    searchResult: [],
    token: "",
    // variabile per identificare nome in show message form senza cambiare user_name in pagina 
    name: undefined
});