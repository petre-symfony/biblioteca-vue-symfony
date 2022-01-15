import axios from 'axios'

export function fetchAuthors(params={}){

	return axios.get('/api/authors', {params})
}
