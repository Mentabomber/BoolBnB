import { reactive } from 'vue'

export const storeFilter = reactive({
    loading: false,
    apartmentsall: [],
    apartFiltered: [],
    searchParams: null

});