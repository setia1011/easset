Vue.component('paginate', VuejsPaginate);
Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#v-browse',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        search: null,
        items: [],
        totalData: null,
        totalRows: null,
        totalPage: null,
        currentPage: 1,
        perPage: 5,
    },
    watch: {
        search: _.debounce(
            function() {
               this.fetchAset();
            }, 500
        )
    },
    computed: {
        getPageCount: function() {
            return this.totalPage;
        }
    },
    mounted() {
        this.fetchAset();
    },
    methods: {
        fetchAset: function() {
            axios.post('../app/fetch-aset', JSON.stringify({
                search: this.search,
                perPage: this.perPage,
                currentPage: this.currentPage
            })).then(res => {
                // console.log(res.data.items);
                // this.items = res.data.items;
                this.totalUser = res.data['totalData'];
                this.totalRows = res.data['totalRows'];
                this.items = res.data['items'];
                this.totalPage = res.data['totalPage'];
                this.index = this.currentPage * this.perPage;
            }).catch(err => {
                console.log(err);
            });
        },
        clickCallback: function(pageNum) {
            this.currentPage = Number(pageNum);
            this.fetchAset();
        },
    }
});