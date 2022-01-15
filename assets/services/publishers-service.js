import axios from 'axios'

export function fetchPublishers(params={}){

	return axios.get('/api/publishers', {params})
}
