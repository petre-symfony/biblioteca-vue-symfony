import axios from 'axios'

export function fetchBooks(page){
  const params = {}

  if (page) {
    params.page = page
  }

  return axios.get('/api/books', {params})
}