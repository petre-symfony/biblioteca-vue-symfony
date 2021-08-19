import axios from 'axios'

export function fetchBooks(page){
  const params = {}

  if (page) {
    params.page = page
  }

  return axios.get('/api/books', {params})
}

export function fetchBooksByAuthor(authorLink, page=null){
  const params = {}

  params.authors=authorLink

  if (page) {
    params.page = page
  }

  return axios.get('/api/books', {params})
}