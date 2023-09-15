import { reactive } from 'vue'

export const store = reactive({
    loading: false,
    apartments: [],
    user_email: undefined,
    user_name: undefined
});