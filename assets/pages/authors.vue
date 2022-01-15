<template>
	<div>
		<div v-for="author in authors" :key="author['@id']" :class="[$style.component, 'card', 'm-2']">
			<p>{{ author.fullName }}</p>
		</div>
		<paginator
			v-if="!loading && lastAuthorsPage > 1"
			:current-page="params.page"
			:last-items-page="lastAuthorsPage"
			@change-current-page="updateCurrentPage($event.currentPage)"
		/>
	</div>
</template>

<script>
import { fetchAuthors } from '@/services/authors-service'
import Paginator from '@/components/paginator'

export default {
	name: "authors",
	components: {
		Paginator,
	},
	data(){
		return {
			authors: [],
			loading: false,
			lastAuthorsPage: 1,
			params: {
				page: 1
			}
		}
	},
	methods: {
		updateCurrentPage(currentPage) {
			this.params.page = currentPage
			this.loadAuthors()
		},
		async loadAuthors() {
			this.loading = true

			const response = await fetchAuthors(this.params)

			this.loading = false
			this.authors = response.data['hydra:member']
			if (response.data['hydra:view']['hydra:last']) {
				const textLinkLastPage = response.data['hydra:view']['hydra:last']
				const textLastPage = /page=\d+/.exec(textLinkLastPage)
				this.lastAuthorsPage = parseInt((/\d+/.exec(textLastPage[0]))[0])
			} else {
				this.lastAuthorsPage = 1
			}
		}
	},
	created() {
		this.loadAuthors()
	}
}
</script>

<style lang="scss" module>
.component :global {

}

</style>
