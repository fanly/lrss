<template>
    <el-container>
        <el-main>
            <el-card class="box-card">
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
                                prop="interval"
                                label="更新间隔时间"
                                width="180">
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
                if (this.apply == null) {
                    return 0
                }

                return Number(this.apply.total)
            },
            current_page () {
                if (this.apply == null) {
                    return 0
                }

                return Number(this.apply.current_page)
            },
            per_page () {
                if (this.apply == null) {
                    return 0
                }

                return Number(this.apply.per_page)
            },
            list () {
                if (this.apply == null) {
                    return []
                }

                return (this.apply.data instanceof Array) ? this.apply.data : Object.values(this.apply.data);
            }
        },
        props: {
            apply: {
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
            handleapplyShow (index, data) {
                console.log(index)
                console.log(data)
            },
            handleDingyue (index, data) {
                console.log(index)
                console.log(data)
            },
            handleSizeChange(val) {
                this.$emit('listenToApplyListSizeChangeEvent', val)
            },
            handleCurrentChange(val) {
                this.$emit('listenToApplyListCurrentChangeEvent', val)
            }
        }
    }
</script>

<style scoped>
    .right {
        float: right;
    }
</style>