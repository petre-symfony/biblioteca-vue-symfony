<template>
  <div>
    <div v-for="book in books" :key="book['@id']" :class="[$style.component, 'card', 'm-2']">
      <p>{{ book.name }} <span v-if="book.volume"> - Volume {{ book.volume }}</span></p>
      <p v-if="book.subject">{{ book.subject }}</p>
      <div class="card-body d-flex flex-column content">
        <div class="details d-flex flex-column flex-md-row justify-content-md-center">
          <div class="card location-editors-summary">
            <div v-if="book.location" class="card location">
              <p>Locatie</p>
              <div class="card-body">{{ book.location }}</div>
            </div>
            <div
                v-if="book.publishers && book.publishers.length !== 0"
                class="card editors"
            >
              <p>Editors</p>
              <div class="card-body">
                <ul class="list-group list-group-flush">
                  <li
                      v-for="editor in book.publishers"
                      :key="editor['@id']"
                      class="list-group-item"
                  >
                    {{ editor.name }}
                  </li>
                </ul>
              </div>
              <button
                  type="button"
                  v-if="book.content"
                  class="btn btn-success"
                  data-bs-toggle="modal"
                  :data-bs-target="`#${book['@id'].replaceAll('/', '_')}`"
              >
                Click to see summary
              </button>
              <button
                  type="button"
                  v-else="!book.content"
                  class="btn btn-primary"
              >
                We have no summary details
              </button>
            </div>
            <!-- Modal -->
            <div
                class="modal fade"
                v-if="book.content"
                :id="`${book['@id'].replaceAll('/', '_')}`"
                data-bs-backdrop="static"
                data-bs-keyboard="false"
                tabIndex="-1"
                aria-hidden="true"
            >
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-body">
                    <h5>
                      {{ book.name }}
                      {{ book.volume ? ` volume ${book.volume}` : ''}}
                      {{ book.authors && book.authors.length > 0 ? ' - ' + book.authors[0].fullName : ''}}
                      {{ book.publishers && book.publishers.length > 0 ? ' - ' + book.publishers[0].name : '' }}
                      {{ book.bookPublishedYear ? ' - ' + book.bookPublishedYear : ''}}
                    </h5>
                    <tree :tree-data="getBookContentObject(book.content)" />
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card other-details">
            <p>Details</p>
            <div class="card-body">
              <ul class="list-group">
                <li
                    class="list-group-item"
                    v-if="book.volume && book.complete === true"
                >
                  We have all volumes
                </li>
                <li
                    class="list-group-item"
                    v-else-if="book.volume && book.complete === false"
                >
                  Some volumes are missing
                </li>
                <li
                    class="list-group-item"
                    v-if="book.firstPublishedYear"
                >
                  Fist time was published in {{ book.firstPublishedYear}}
                </li>
                <li
                    class="list-group-item"
                    v-if="book.bookPublishedYear"
                >
                  This book is published in {{ book.bookPublishedYear}}
                </li>
                <li
                    class="list-group-item"
                    v-if="book.pages"
                >
                  {{ book.pages }} pages
                </li>
                <li
                    class="list-group-item"
                    v-if="book.missingPages && book.missingPages === 'NONE'"
                >
                  No missing pages
                </li>
                <li
                    class="list-group-item"
                    v-else-if="book.missingPages && book.missingPages === 'n/a'"
                >
                  Unknown number of pages is missing
                </li>
                <li
                    class="list-group-item"
                    v-else="book.missingPages"
                >
                  {{ book.missingPages }} is missing
                </li>
                <li
                    class="list-group-item"
                    v-if="book.format"
                >
                  {{ book.format }}
                </li>
                <li
                    class="list-group-item"
                    v-if="book.ISBN"
                >
                  ISBN: {{ book.ISBN }}
                </li>
                <li
                    class="list-group-item"
                    v-if="book.other"
                >
                  {{ book.other }}
                </li>
                <li
                    class="list-group-item"
                    v-if="book.language"
                >
                  {{ book.language }}
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div
            v-if="book.authors && book.authors.length !== 0"
            class="card authors"
        >
          <p>Authors</p>
          <div class="card-body">
            <ul class="list-group flex-md-row flex-md-wrap justify-content-md-center">
              <li
                  v-for="author in book.authors"
                  :key="author['@id']"
                  class="list-group-item btn btn-primary"
                  @click="loadBooksByAuthor(author['@id'], 1)"
              >
                {{ author.fullName }}
              </li>
            </ul>
            <div>
              <button
                  v-if="params.authors"
                  class="btn btn-primary"
                  @click="getAllBooks"
              >
                Click to see all books
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <paginator
        v-if="!loading && lastBooksPage > 1"
        :current-page="params.page"
        :last-items-page="lastBooksPage"
        @change-current-page="updateCurrentPage($event.currentPage)"
    />
  </div>
</template>

<script>
import { fetchBooks, fetchBooksByAuthor } from '@/services/books-service'
import Paginator from '@/components/paginator'
import Tree from '@/components/treeBookContent'

export default {
  name: "books",
  components: {
    Paginator,
    Tree
  },
  data(){
    return {
      books: [],
      loading: false,
      lastBooksPage: 1,
      params: {
        authors: null,
        page: 1
      }
    }
  },
  methods: {
    getBookContentObject(stringBookContent) {
      const arrayBookContent = eval(stringBookContent)
      return arrayBookContent[0]
    },
    updateCurrentPage(currentPage) {
      this.params.page = currentPage
      this.loadBooks()
    },
    async loadBooks(){
      this.loading = true

      const response = await fetchBooks(this.params)

      this.loading = false
      this.books = response.data['hydra:member']
      if (response.data['hydra:view']['hydra:last']) {
        const textLinkLastPage = response.data['hydra:view']['hydra:last']
        const textLastPage = /page=\d+/.exec(textLinkLastPage)
        this.lastBooksPage = parseInt((/\d+/.exec(textLastPage[0]))[0])
      } else {
        this.lastBooksPage = 1
      }
    },
    loadBooksByAuthor(authorLink, currentPage=1){
      this.params.authors = authorLink
      this.params.page = currentPage


      this.loadBooks()
    },
    getAllBooks() {
      this.params.authors = null
      this.params.page = 1

      this.loadBooks()
    }
  },
  created() {
    this.loadBooks()
  }
}
</script>

<style lang="scss" module>
.component :global {
  p {
    margin: auto;
  }

  @media (min-width: 768px){
    .location-editors-summary {
      width: 20rem;
      margin-right: 0.5rem;
    }

    .other-details {
      width: 20rem;
      margin-left: 0.5rem;
    }

    .authors {
      width: 41rem;
      margin: 0.5rem auto
    }

    .authors .card-body div {
      text-align: center;
    }
  }
}
</style>