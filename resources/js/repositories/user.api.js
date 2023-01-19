import Axios from "../plugins/axios"

export const Self = () => Axios.get('self')
export const login = (payload) => Axios.post('login', payload)
export const PatientPagination = (url, payload) => Axios.get(`/${url}`, payload)

export const store = (payload) => Axios.post('new-patient', payload);