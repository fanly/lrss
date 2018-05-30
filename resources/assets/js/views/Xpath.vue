<template>
    <el-table
    :data="lists"
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
</template>
<script>
import { fetchList } from '../apis/rss'
export default {
  name: 'couponlist',
  components: {
  },
  data () {
    return {
      lists: [],
      locked: false,
      has_more: true,
      next_cursor: 1,
      loading: true,
      showtop: false,
      hash_id: ''
    }
  },
  methods: {
    async getList () {
        const response = await fetchList()
        console.log(response)
        this.lists = response.data.data.list
        console.log(this.lists)
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