<template>
    <el-container>
        <el-main>
            <el-card class="box-card">
                <div slot="header" class="clearfix">
                    <span>操作</span>
                    <el-button style="float: right; padding: 3px 0" type="text">如果没有你要的，点此发起申请制作</el-button>
                </div>
                <div>
                    <el-table
                        :data="list"
                        stripe
                        style="width: 100%">
                        <el-table-column
                        prop="id"
                        label="ID"
                        width="90">
                        </el-table-column>
                        <el-table-column
                        prop="url"
                        label="链接">
                        </el-table-column>
                        <el-table-column
                        prop="urldesc"
                        label="简要描述"
                        width="180">
                        </el-table-column>
                        <el-table-column label="操作">
                        <template slot-scope="scope">
                            <el-button
                            size="mini"
                            @click="handleRssShow(scope.$index, scope.row)">查看 RSS</el-button>
                            <el-button
                            size="mini"
                            type="success"
                            @click="handleDingyue(scope.$index, scope.row)">订阅</el-button>
                        </template>
                        </el-table-column>
                    </el-table>
                </div>
            </el-card>
        </el-main>
        <el-footer>
            <el-pagination
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page="current_page"
                :page-sizes="page_sizes"
                :page-size="per_page"
                layout="total, sizes, prev, pager, next, jumper"
                :total="total"
                class="right">
            </el-pagination>
        </el-footer>
    </el-container>
</template>
<script>
import { fetchList } from '../apis/rss'
export default {
  name: 'couponlist',
  components: {
  },
  data () {
    return {
      list: [],
      locked: false,
      has_more: true,
      next_cursor: 1,
      loading: true,
      showtop: false,
      hash_id: '',
      current_page: 1,
      per_page: 3,
      page_sizes: [3, 20, 30, 40],
      total: 0
    }
  },
  methods: {
    async getList () {
        const response = await fetchList({
            per_page: this.per_page,
            current_page: this.current_page
        })
        let rss = response.data.data.rss
        let data = response.data.data.rss.data
        if (data instanceof Array) {
            this.list = data
        } else {
            this.list = Object.values(data)
        }
        this.current_page = Number(rss.current_page)
        this.per_page = Number(rss.per_page)
        this.total = Number(rss.total)
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
        console.log(`每页 ${val} 条`)
        this.per_page = val
        this.getList()
    },
    handleCurrentChange(val) {
        console.log(`当前页: ${val}`)
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
    .right {
        float: right;
    }
</style>