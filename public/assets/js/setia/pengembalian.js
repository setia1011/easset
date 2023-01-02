Vue.component('paginate', VuejsPaginate);
Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#v-alokasi',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        loading: false,
        linfo: false,
        ainfo: null,
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
        userlev: null,
        opt_status: 'return',
        dio: {
            'kondisi': false
        },
        kondisi: null,
        kondisi_text: null,
        kondisi_options: [],
        status: null,
        status_options: [
            {label: 'Exist', code: 'exist'}, 
            {label: 'Ended', code: 'ended'},
        ],
        keterangan: null,
        pemakaian_his: []
    },
    watch: {
        search: _.debounce(
            function() {
               this.fetchBooks();
            }, 500
        ),
        opt_status: _.debounce(
            function() {
                this.currentPage = 1;
                this.fetchBooks();
            }, 100
        )
    },
    computed: {
        getPageCount: function() {
            return this.totalPage;
        }
    },
    mounted() {
        this.fetchBooks();
        this.fetchOptKondisi();
    },
    methods: {
        fetchOptKondisi: function(search) {
            axios.post('../ref/fetch-refs', JSON.stringify({
                ref: 'kondisi',
                search: search
            })).then(res => {
                console.log(res.data);
                this.kondisi_options = res.data;
            }).catch(err => {
                console.log(err);
            });
        },
        selectedOptKondisi: function(val) {
            this.kondisi = val;
            for (var i = 0; i < this.kondisi_options.length; i++) {
                if (this.kondisi_options[i].id === this.kondisi) {
                    this.kondisi_text = this.kondisi_options[i].kondisi;
                }   
            }
        },
        fetchBooks: function() {
            this.userlev = this.$refs.userlev.value;
            axios.post('../app/fetch-books', JSON.stringify({
                status: this.opt_status,
                userlev: this.userlev,
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
        clickCallback: function(pageNum) {
            this.currentPage = Number(pageNum);
            this.fetchBooks();
        },
        fetchDetails: function(e, v, b) {
            axios.post('../app/fetch-an-aset-v2', JSON.stringify({
                aid: v,
                bid: b,
                ref: 'alokasi'
            })).then(res => {
                console.log(res.data);
                if (res.data) {
                    this.details = res.data[0];
                    this.aid = res.data[0].id;
                    this.qty = res.data[0].book_qty;
                    this.bid = res.data[0].book_id;
                    this.kondisi = res.data[0].kondisi_id;
                    this.selectedOptKondisi(this.kondisi);
                    this.status = res.data[0].pemakaian_status;
                    this.keterangan = res.data[0].pemakaian_keterangan;
                    this.pemakaian_his = res.data[0].pemakaian;
                    console.log(this.pemakaian_his);
                }
            }).catch(err => {
                console.log(err);
            });
        },
        returnAset: function() {

        }
    }
});