import Axios from "../plugins/axios"

export const Services = () => Axios.get('get-service')
export const searchService = (payload) => Axios.post('search-service', payload)