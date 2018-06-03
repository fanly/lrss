<template>
    <el-container>
        <el-header>
            <el-menu
                :default-active="activeIndex"
                class="el-menu-demo"
                mode="horizontal"
                @select="handleSelect"
                background-color="#545c64"
                text-color="#fff"
                active-text-color="#ffd04b">
                <el-menu-item index="0">RSS 列表</el-menu-item>
                <el-menu-item index="1">订阅列表</el-menu-item>
                <el-menu-item index="2">我的</el-menu-item>
            </el-menu>
        </el-header>
        <el-main>
            <el-card class="box-card">
                <div slot="header" class="clearfix">
                    <span>操作</span>
                    <el-button style="float: right; padding: 3px 0" type="text" @click="dialogFormVisible = true">如果没有你要的，点此发起申请制作</el-button>
                </div>
                <router-view></router-view>
            </el-card>
            <el-dialog title="申请创建 RSS" :visible.sync="dialogFormVisible">
                <el-form :model="form" :rules="formRules">
                    <el-form-item label="链接" :label-width="formLabelWidth" prop="url">
                        <el-input v-model="form.url" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="更新时间" :label-width="formLabelWidth" prop="interval">
                        <el-select v-model="form.interval" placeholder="选择RSS更新间隔时间">
                            <el-option label="一个小时" value="1"></el-option>
                            <el-option label="两个小时" value="2"></el-option>
                            <el-option label="四个小时" value="4"></el-option>
                            <el-option label="八个小时" value="8"></el-option>
                            <el-option label="半天" value="12"></el-option>
                        </el-select>
                    </el-form-item>
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogFormVisible = false">取 消</el-button>
                    <el-button type="primary" @click="submitForm">确 定</el-button>
                </div>
            </el-dialog>
        </el-main>
    </el-container>
</template>
<script>
    import { postApply } from '../apis/apply'
    import { validateURL } from '../utils/validate'
    export default {
        data() {
            const checkUrl = (rule, value, callback) => {
                if (!value) {
                    callback(new Error('链接不能为空'))
                }
                if (!validateURL(value)) {
                    callback(new Error('输入正确格式的 url'))
                } else {
                    callback()
                }
            }

            return {
                activeIndex: '0',
                routes: [
                    '/',
                    '/apply',
                    'me'
                ],
                dialogFormVisible: false,
                formLabelWidth: '140px',
                form: {
                    url: '',
                    interval: '1'
                },
                formRules: {
                    url: [{required: true, validator: checkUrl, trigger: 'blur' }]
                }
            };
        },
        methods: {
            handleSelect(key, keyPath) {
                this.$router.push({'path': this.routes[key]})
            },
            submitForm () {
                this.post()
            },
            async post () {
                try {
                    const response = await postApply(this.form)
                    this.dialogFormVisible = false
                    this.$router.push({ path: '/me' })
                } catch (e) {
                    if (e === 401) {
                        this.$router.push({ path: '/login' })
                    }
                }
            }
        }
    }
</script>
<style scoped>
    .add_button {
        float:right;
    }
    .box-card {
        width: 100%;
    }
</style>