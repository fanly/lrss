<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <ul>
                            <li v-for="name in names" :key="name">{{ name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "example",
        data () {
            return {
                names: []
            }
        },
        mounted() {
            let that = this
            // 12. 创建 Echo 监听
            window.Echo.private('App.User.3')
                .listen('RssCreatedEvent', (e) => {
                    that.names.push(e.name)
                });

            window.Echo.channel('public_channel')
                .listen('RssPublicEvent', (e) => {
                    that.names.push(e.name)
                });
        }
    }
</script>