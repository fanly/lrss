<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span>操作</span>
            <el-button style="float: right; padding: 3px 0" type="text">如果没有账号，点此注册</el-button>
        </div>
        <div>
            <el-input
                placeholder="请输入email"
                type="email"
                v-model="email">
            </el-input>
            <el-input
                placeholder="请输入密码"
                type="password"
                v-model="password">
            </el-input>
            <el-button size="medium" @click="loginClick">登录</el-button>
        </div>
    </el-card>
</template>
<script>
    export default {
        name: 'login',
        components: {
        },
        data () {
            return {
                load_text: '数据加载中',
                email: '',
                password: ''
            }
        },
        methods: {
            loginClick () {
                console.log(this.email + this.password)
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