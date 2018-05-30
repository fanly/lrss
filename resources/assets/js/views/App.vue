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
                <el-menu-item index="0">Home</el-menu-item>
                <el-menu-item index="1">Xpath</el-menu-item>
                <el-menu-item index="2">登录</el-menu-item>
            </el-menu>
        </el-header>
        <el-main>
            <router-view></router-view>
        </el-main>
    </el-container>
</template>
<script>
    export default {
        data() {
            return {
                activeIndex: '1',
                routes: [
                    'home',
                    'xpath',
                    'login'
                ]
            };
        },
        methods: {
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
                this.$router.push({'path': this.routes[key]})
            }
        }
    }
</script>