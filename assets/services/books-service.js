import axios from 'axios'

export function fetchBooks(){

  return axios.get('/api/books')
}