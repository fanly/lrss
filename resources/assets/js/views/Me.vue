<template>
    <div>
        <el-card class="box-card">
            <p>yemeishu@126.comm</p>
        </el-card>
        <div>
            <rss-list
                    :rss="rss"
                    v-on:listenToRssListCurrentChangeEvent="handleRssCurrentChange"
                    v-on:listenToRssListSizeChangeEvent="handleRssSizeChange">
            </rss-list>
        </div>
        <div>
            <apply-list :apply="apply"
                        v-on:listenToApplyListCurrentChangeEvent="handleApplyCurrentChange"
                        v-on:listenToApplyListSizeChangeEvent="handleApplySizeChange">
            </apply-list>
        </div>
    </div>
</template>

<script>
    import { getUserInfo } from '../apis/login'
    import { fetchList } from '../apis/rss'
    import { fetchApplyList, postApply } from '../apis/apply'
    import RssList from '../components/RssList'
    import ApplyList from '../components/ApplyList'

    export default {
        name: "me",
        components: {
            RssList,
            ApplyList
        },
        data () {
            return {
                rss: null,
                apply: null,
                rss_current_page: 1,
                rss_per_page: 3,
                apply_current_page: 1,
                apply_per_page: 3
            }
        },
        methods: {
            async getRssList() {
                try {
                    const response = await fetchList({
                        per_page: this.rss_per_page,
                        current_page: this.rss_current_page,
                        from: 1
                    })
                    this.rss = response.rss
                } catch (e) {
                    if (e === 401) {
                        this.$router.push({path: '/login'})
                    }
                }
            },
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
            fetchData(to, from, next) {
                this.getRssList()
                this.getApplyList()
            },
            handleRssShow(index, data) {
                console.log(index)
                console.log(data)
            },
            handleDingyue(index, data) {
                console.log(index)
                console.log(data)
            },
            handleRssSizeChange(val) {
                this.rss_per_page = val
                this.getRssList()
            },
            handleRssCurrentChange(val) {
                this.rss_current_page = val
                this.getRssList()
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

<style scoped>

</style>