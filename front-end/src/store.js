import { reactive } from "vue";

export const store = reactive({
    local_host: 'http://localhost:8000',
    API_URL: 'http://localhost:8000/api/v1',
    user_email: undefined,
    user_name: undefined,
    user_surname: undefined,
    user_message: "",
    user_email_apartment_id: "",
});