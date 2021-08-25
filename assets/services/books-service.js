import axios from 'axios'

export function fetchBooks(params={}){

  return axios.get('/api/books', {params})
}