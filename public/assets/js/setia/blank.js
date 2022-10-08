var application = new Vue({
    el: '#app',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
    },
    watch: {
    },
    computed: {
    },
    mounted() {
    },
    methods: {
    }
});