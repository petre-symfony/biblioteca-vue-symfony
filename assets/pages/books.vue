<template>
  <div>
    <div v-for="book in books" :class="[$style.component, 'card', 'm-2']">
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
                      class="list-group-item"
                  >
                    {{ editor.name }}
                  </li>
                </ul>
              </div>
              <a
                  href="#"
                  v-if="book.content"
                  class="btn btn-success"
              >
                Click to see summary
              </a>
              <a
                  href="#"
                  v-else="!book.content"
                  class="btn btn-primary"
              >
                We have no summary details
              </a>
            </div>
          </div>
          <div class="card other-details">
            <p>Details</p>
            <div class="card-body">
              <ul class="list-group">
                <li
                    class="list-group-item"
                    v-if="book.complete && book.complete === true"
                >
                  We have all volumes
                </li>
                <li
                    class="list-group-item"
                    v-else-if="book.complete && book.complete === false"
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
                  class="list-group-item btn btn-primary"
                  @click="loadBooksByAuthor(author['@id'], 1)"
              >
                {{ author.fullName }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <paginator
        v-if="!loading && lastBooksPage > 1"
        :current-page="currentPage"
        :last-items-page="lastBooksPage"
        @change-current-page="updateCurrentPage($event.currentPage)"
    />
  </div>
</template>

<script>
import { fetchBooks, fetchBooksByAuthor } from '@/services/books-service'
import Paginator from '@/components/paginator'

export default {
  name: "books",
  components: {
    Paginator,
  },
  data(){
    return {
      books: [],
      loading: false,
      lastBooksPage: 1,
      currentPage: 1,
      authorLink: null
    }
  },
  methods: {
    updateCurrentPage(currentPage) {
      this.currentPage = currentPage
      if (!this.authorLink) {
        this.loadBooks(this.currentPage)
      } else {
        this.loadBooksByAuthor(this.authorLink, this.currentPage)
      }

    },
    async loadBooks(){
      this.loading = true
      const response = await fetchBooks(this.currentPage)

      this.loading = false
      this.books = response.data['hydra:member']
      if (response.data['hydra:view']['hydra:last']) {
        const textLinkLastPage = response.data['hydra:view']['hydra:last']
        const textLastPage = /page=\d+/.exec(textLinkLastPage)
        this.lastBooksPage = parseInt((/\d+/.exec(textLastPage[0]))[0])
      }
    },
    async loadBooksByAuthor(authorLink, currentPage){
      this.loading = true
      this.authorLink = authorLink;
      const response = await fetchBooksByAuthor(authorLink, currentPage)

      this.loading = false
      this.books = response.data['hydra:member']

      if (response.data['hydra:view']['hydra:last']) {
        const textLinkLastPage = response.data['hydra:view']['hydra:last']
        const textLastPage = /page=\d+/.exec(textLinkLastPage)
        this.lastBooksPage = parseInt((/\d+/.exec(textLastPage[0]))[0])
      } else {
        this.lastBooksPage = 1
      }
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
  }
}
</style>