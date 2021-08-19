<template>
  <nav>
    <ul :class="[$style.component, 'pagination']">
      <li class="page-item">
        <button
            class="page-link"
            :disabled="currentPage === 1"
            @click="goToFirstPage"
        >
          First(1)
        </button>
      </li>
      <li class="page-item">
        <button
            class="page-link"
            :disabled="currentPage === 1"
            @click="goToPreviousPage"
        >
          Previous
        </button>
      </li>
      <li
          class="page-item"
          v-for="i in [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]"
      >
        <button
            :class="['page-link', i === 0 ? 'active' : '']"
            v-if="currentPage + i <= lastItemsPage"
            @click="goToPage(i)"
        >
          {{ currentPage + i }}
        </button>
      </li>
      <li class="page-item">
        <button
            class="page-link"
            :disabled="currentPage === lastItemsPage"
            @click="goToNextPage"
        >
          Next
        </button>
      </li>
      <li class="page-item">
        <button
            class="page-link"
            :disabled="currentPage === lastItemsPage"
            @click="goToLastPage"
        >
          Last({{this.lastItemsPage}})
        </button>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: "paginator",
  props: {
    lastItemsPage: {
      type: Number,
      required: true
    },
    currentPage: {
      type: Number,
      default: 1
    }
  },
  methods: {
    goToFirstPage() {
      this.$emit('change-current-page', {
        currentPage: 1
      })
    },
    goToPreviousPage() {
      if (this.currentPage - 1 >= 1) {
        this.$emit('change-current-page', {
          currentPage: this.currentPage - 1
        })
      }
      return
    },
    goToNextPage() {
      if (this.currentPage + 1 <= this.lastItemsPage) {
        this.$emit('change-current-page', {
          currentPage: this.currentPage + 1
        })
      }
      return
    },
    goToLastPage() {
      this.$emit('change-current-page', {
        currentPage: this.lastItemsPage
      })
    },
    goToPage(i) {
      if (i > 0) {
        this.$emit('change-current-page', {
          currentPage: this.currentPage + i
        })
      }
      return
    }
  },
}
</script>

<style lang="scss" module>
.component :global {
  justify-content: center;

  button:disabled {
    background: #dddddd;
  }

  button.active {
    background: #00ff00;
  }
}
</style>