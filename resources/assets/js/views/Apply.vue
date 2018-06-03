<template>
    <apply-list :apply="apply"
                v-on:listenToApplyListCurrentChangeEvent="handleApplyCurrentChange"
                v-on:listenToApplyListSizeChangeEvent="handleApplySizeChange">
    </apply-list>
</template>
<script>
import { fetchApplyList, postApply } from '../apis/apply'
import ApplyList from '../components/ApplyList'
export default {
  name: 'applylist',
  components: {
      ApplyList
  },
  data () {
    return {
        apply: null,
        apply_current_page: 1,
        apply_per_page: 3
    }
  },
  methods: {
      async getApplyList() {
          try {
              const response = await fetchApplyList({
                  per_page: this.apply_per_page,
                  current_page: this.apply_current_page,
                  from: 1
              })
              this.apply = response.apply
          } catch (e) {
              if (e === 401) {
                  this.$router.push({path: '/login'})
              }
          }
      },
        fetchData (to, from, next) {
          this.getApplyList()
        },
        handleRssShow (index, data) {
            console.log(index)
            console.log(data)
        },
        handleDingyue (index, data) {
            console.log(index)
            console.log(data)
        },
        handleApplySizeChange(val) {
            this.apply_per_page = val
            this.getApplyList()
        },
      handleApplyCurrentChange(val) {
          this._current_page = val
          this.getApplyList()
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