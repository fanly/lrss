<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span>操作</span>
            <el-button style="float: right; padding: 3px 0" type="text">如果没有账号，点此注册</el-button>
        </div>
        <el-form :model="loginForm" status-icon :rules="loginRules" ref="loginForm" label-width="100px" class="demo-ruleForm">
            <el-form-item label="Email" prop="email">
                <el-input type="email" v-model="loginForm.email" autoComplete="on" placeholder="请输入您的邮箱"></el-input>
            </el-form-item>
            <el-form-item label="密码" prop="password">
                <el-input type="password" v-model="loginForm.password" auto-complete="off" @keyup.enter.native="handleLogin" placeholder="请输入密码"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" style="width:100%;margin-bottom:30px;" :loading="loading" @click.native.prevent="handleLogin">登录/注册</el-button>
            </el-form-item>
        </el-form>
    </el-card>
</template>
<script>
    import { isValidateEmail } from '../utils/validate'
    export default {
        name: 'login',
        components: {
        },
        data () {
            const validateEmail = (rule, value, callback) => {
            if (!isValidateEmail(value)) {
                callback(new Error('Please enter the correct email'))
            } else {
                callback()
            }
            }
            const validatePassword = (rule, value, callback) => {
            if (value.length < 6) {
                callback(new Error('The password can not be less than 6 digits'))
            } else {
                callback()
            }
            }
            return {
                loginForm: {
                    email: 'yemeishu@126.com',
                    password: 'nihaoma'
                },
                loginRules: {
                    email: [{ required: true, trigger: 'blur', validator: validateEmail }],
                    password: [{ required: true, trigger: 'blur', validator: validatePassword }]
                },
                passwordType: 'password',
                loading: false,
                showDialog: false
            }
        },
        methods: {
            handleLogin() {
                console.log('handleLogin')
                this.$refs.loginForm.validate(valid => {
                    if (valid) {
                        this.loading = true
                        this.$store.dispatch('LoginByEmail', this.loginForm).then(() => {
                            this.loading = false
                            this.$router.push({ path: '/' })
                        }).catch(() => {
                            this.loading = false
                        })
                    } else {
                        console.log('error submit!!')
                        return false
                    }
                })
            }
        },
        beforeRouteEnter (to, from, next) {
            next(vm => {
                // vm.fetchData(to, from, next)
            })
        },
        beforeRouteLeave (to, from, next) {
            window.removeEventListener('scroll', this.scroll, false)
            window.localStorage.setItem('booklist-scrolltop', document.body.scrollTop)
            next()
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<!--<style scoped lang="scss">-->
    <!--@import '~style/booklist';-->
<!--</style>-->