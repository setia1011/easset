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
        search: '',
        perPage: 5,
        currentPage: null
    },
    watch: {
    },
    computed: {
    },
    mounted() {
        this.fetchBooks();
    },
    methods: {
        fetchBooks: function() {
            axios.post('../app/fetch-books', JSON.stringify({
                ref: 'all',
                search: this.search,
                perPage: this.perPage,
                currentPage: this.currentPage
            })).then(res => {
                console.log(res.data);
                this.items = res.data;
                // this.totalUser = res.data['totalData'];
                // this.totalRows = res.data['totalRows'];
                // this.items = res.data['items'];
                // this.totalPage = res.data['totalPage'];
                // this.index = this.currentPage * this.perPage;
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
    }
});