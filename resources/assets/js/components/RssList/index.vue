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
                        <el-table-column
                                label="RSS 地址"
                                width="180">
                            <template slot-scope="scope">
                                <el-tag size="medium">feed/{{ scope.row.id }}</el-tag>
                            </template>
                        </el-table-column>
                        <el-table-column label="操作">
                            <template slot-scope="scope">
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
    export default {
        computed: {
            total () {
                if (this.rss == null) {
                    return 0
                }

                return Number(this.rss.total)
            },
            current_page () {
                if (this.rss == null) {
                    return 0
                }

                return Number(this.rss.current_page)
            },
            per_page () {
                if (this.rss == null) {
                    return 0
                }

                return Number(this.rss.per_page)
            },
            list () {
                if (this.rss == null) {
                    return []
                }

                return (this.rss.data instanceof Array) ? this.rss.data : Object.values(this.rss.data);
            }
        },
        props: {
            rss: {
                type: Object,
                default: null
            }
        },
        data() {
            return {
                page_sizes: [3, 20, 30, 40]
            }
        },
        methods: {
            handleRssShow (index, data) {
                console.log(index)
                console.log(data)
            },
            handleDingyue (index, data) {
                console.log(index)
                console.log(data)
            },
            handleSizeChange(val) {
                this.$emit('listenToRssListSizeChangeEvent', val)
            },
            handleCurrentChange(val) {
                this.$emit('listenToRssListCurrentChangeEvent', val)
            }
        }
    }
</script>

<style scoped>
    .right {
        float: right;
    }
</style>