<template>
  <div class="p-0">
    <TopBar :user="user" :is_admin="is_admin" :lang="lang"/>
    <router-view :user="user" :is_admin="is_admin"></router-view>
  </div>
</template>

<script>
    import UserCircle from './UserCircle';
    import TopBar from './TopBar';

    export default {
        name: "App",

        props: [
            'user',
            'is_admin',
            'lang'
        ],

        components: {
            UserCircle,
            TopBar
        },

        created() {
            this.title = this.$route.meta.title;

            window.axios.interceptors.request.use(
                (config) => {
                    if (typeof this.user.api_token !== 'undefined') {
                        if (config.method === 'get') {
                            let sign = config.url.indexOf('?')==-1 ? '?' : '&';
                            config.url = config.url + sign + 'api_token=' + this.user.api_token;
                        } else {
                            config.data = {
                                ...config.data,
                                api_token: this.user.api_token
                            };
                        }
                    }

                    return config;
                }
            )
        },

        data: function () {
            return {
                title: '',
            }
        },

        watch: {
            $route(to, from) {
                this.title = to.meta.title;
            },

            title() {
                document.title = this.title + ' | 2emotions'
            }
        }
    }
</script>

<style scoped>

</style>