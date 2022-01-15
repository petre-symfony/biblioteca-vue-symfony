<template>
	<div>
		<div v-for="publisher in publishers" :key="publisher['@id']" :class="[$style.component, 'card', 'm-2']">
			<p>{{ publisher.name }}</p>
		</div>
		<paginator
			v-if="!loading && lastPublishersPage > 1"
			:current-page="params.page"
			:last-items-page="lastPublishersPage"
			@change-current-page="updateCurrentPage($event.currentPage)"
		/>
	</div>
</template>

<script>
import { fetchPublishers } from '@/services/publishers-service'
import Paginator from '@/components/paginator'

export default {
	name: "publishers",
	components: {
		Paginator,
	},
	data(){
		return {
			publishers: [],
			loading: false,
			lastPublishersPage: 1,
			params: {
				page: 1
			}
		}
	},
	methods: {
		updateCurrentPage(currentPage) {
			this.params.page = currentPage
			this.loadPublishers()
		},
		async loadPublishers() {
			this.loading = true

			const response = await fetchPublishers(this.params)

			this.loading = false
			this.publishers = response.data['hydra:member']
			if (response.data['hydra:view']['hydra:last']) {
				const textLinkLastPage = response.data['hydra:view']['hydra:last']
				const textLastPage = /page=\d+/.exec(textLinkLastPage)
				this.lastPublishersPage = parseInt((/\d+/.exec(textLastPage[0]))[0])
			} else {
				this.lastPublishersPage = 1
			}
		}
	},
	created() {
		this.loadPublishers()
	}
}
</script>

<style lang="scss" module>
.component :global {

}
</style>
