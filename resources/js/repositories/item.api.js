import Axios from "../plugins/axios"

export const ItemPagination = (url, payload) => Axios.get(`/${url}`, payload)
export const store = (payload) => Axios.post('add-item', payload);