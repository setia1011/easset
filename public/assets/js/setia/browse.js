Vue.component('paginate', VuejsPaginate);
Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#v-browse',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        loading: false,
        search: null,
        items: [],
        totalData: null,
        totalRows: null,
        totalPage: null,
        currentPage: 1,
        perPage: 8,
        details: [],
        bid: null,
        aid: null,
        min: 0,
        qty: 0
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
                this.totalUser = res.data['totalData'];
                this.totalRows = res.data['totalRows'];
                this.items = res.data['items'];
                this.totalPage = res.data['totalPage'];
                this.index = this.currentPage * this.perPage;
            }).catch(err => {
                console.log(err);
            });
        },
        fetchDetails: function(e, v) {
            axios.post('../app/fetch-an-aset', JSON.stringify({
                aid: v
            })).then(res => {
                console.log(res.data);
                if (res.data) {
                    this.details = res.data[0];
                    this.aid = res.data[0].id;
                    this.qty = res.data[0].book_qty;
                    this.bid = res.data[0].book_id;
                }
            }).catch(err => {
                console.log(err);
            });
        },
        clickCallback: function(pageNum) {
            this.currentPage = Number(pageNum);
            this.fetchAset();
        },
        bookAset: function() {
            if (this.aid) {
                this.loading = true;
                axios.post('../app/book-an-aset', JSON.stringify({
                    aid: this.aid,
                    qty: this.$refs.qx.value
                })).then(res => {
                    console.log(res.data);
                    if (res.data.length > 0) {
                        console.log(res.data);
                        this.bid = res.data[0].id;
                        this.qty = res.data[0].book_qty;
                    } else {
                        this.bid = null;
                        this.qty = 0;
                    }
                    this.loading = false;
                }).catch(err => {
                    console.log(err);
                    this.loading = false;
                });
            }
        },
        checkQty: function(c) {
            console.log(1);
        }
    }
});