<template>
    <rss-list :rss="rss"
              v-on:listenToRssListCurrentChangeEvent="handleCurrentChange"
              v-on:listenToRssListSizeChangeEvent="handleSizeChange"></rss-list>
</template>
<script>
import { fetchList } from '../apis/rss'
import RssList from '../components/RssList'
export default {
  name: 'rsslist',
  components: {
      RssList
  },
  data () {
    return {
      rss: null,
      locked: false,
      has_more: true,
      next_cursor: 1,
      loading: true,
      showtop: false,
      hash_id: '',
      current_page: 1,
      per_page: 3
    }
  },
  methods: {
    async getList () {
        try {
            const response = await fetchList({
                per_page: this.per_page,
                current_page: this.current_page
            })
            this.rss = response.rss
        } catch (e) {
            if (e === 401) {
                this.$router.push({ path: '/login' })
            }
        }
    },
    fetchData (to, from, next) {
      this.getList()
    },
    handleRssShow (index, data) {
        console.log(index)
        console.log(data)
    },
    handleDingyue (index, data) {
        console.log(index)
        console.log(data)
    },
    handleSizeChange(val) {
        this.per_page = val
        this.getList()
    },
    handleCurrentChange(val) {
        this.current_page = val
        this.getList()
    }
  },
  beforeRouteEnter (to, from, next) {
    next(vm => {
    //   window.addEventListener('scroll', vm.scroll, false)
      vm.fetchData(to, from, next)
    })
  }
}
</script>
<style scoped lang="scss">

</style>