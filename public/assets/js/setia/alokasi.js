Vue.component('paginate', VuejsPaginate);
var application = new Vue({
    el: '#v-alokasi',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        loading: false,
        details: [],
        bid: null,
        aid: null,
        min: 0,
        qty: 0,
        items: [],
        search: null,
        totalData: null,
        totalRows: null,
        totalPage: null,
        perPage: 5,
        currentPage: 1,
        userlev: null
        
    },
    watch: {
        search: _.debounce(
            function() {
               this.fetchBooks();
            }, 500
        )
    },
    computed: {
        getPageCount: function() {
            return this.totalPage;
        }
    },
    mounted() {
        this.fetchBooks();
    },
    methods: {
        fetchBooks: function() {
            this.userlev = this.$refs.userlev.value;
            axios.post('../app/fetch-books', JSON.stringify({
                userlev: this.userlev,
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
            this.fetchBooks();
        },
        fetchDetails: function(e, v, b) {
            axios.post('../app/fetch-an-aset', JSON.stringify({
                aid: v,
                bid: b
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
        allocated: function() {
            axios.post('../app/allocation', JSON.stringify({
                aid: this.aid,
                bid: this.bid,
                oqty: this.qty,
                nqty: this.$refs.qx.value
            })).then(res => {
                console.log(res.data);
            }).catch(err => {
                console.log(err);
            });
        }
    }
});