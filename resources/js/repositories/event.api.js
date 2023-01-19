import Axios from "../plugins/axios"

export const EventPagination = (url, payload) => Axios.get(`/${url}`, payload)
export const addAppointment = (payload) => Axios.post('add-appointment', payload);
export const acceptAppointment = (id) => Axios.put('update-status'+ `/${id}`);