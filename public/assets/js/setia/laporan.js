Vue.component('paginate', VuejsPaginate);
Vue.component('v-select', VueSelect.VueSelect);
Vue.use(DatePicker);
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
        opt_status: 'allocated',
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
        pemakaian_his: [],
        tstart: null,
        tend: null,
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
        ),
        tstart: function() {
            this.fetchBooks();
        },
        tend: function() {
            this.fetchBooks();
        }
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
        formatDate: function(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();
        
            if (month.length < 2) 
                month = '0' + month;
            if (day.length < 2) 
                day = '0' + day;
        
            return [year, month, day].join('-');
        },
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
            var tstart = null;
            if (this.tstart !== null) {
                tstart = this.formatDate(new Date(this.tstart));
            }
            var tend = null;
            if (this.tend !== null) {
                tend = this.formatDate(new Date(this.tend));
            }
            this.userlev = this.$refs.userlev.value;
            axios.post('../app/fetch-books', JSON.stringify({
                status: this.opt_status,
                userlev: this.userlev,
                search: this.search,
                perPage: this.perPage,
                currentPage: this.currentPage,
                tstart: tstart,
                tend: tend
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
        exportToCsv: function() {
            if (this.tstart !== null) {
                var tstart = this.formatDate(new Date(this.tstart));
            }
            if (this.tend !== null) {
                var tend = this.formatDate(new Date(this.tend));
            }
            this.userlev = this.$refs.userlev.value;
            axios.post('../app/export-to-csv', JSON.stringify({
                status: this.opt_status,
                userlev: this.userlev,
                search: this.search,
                perPage: this.perPage,
                currentPage: this.currentPage,
                tstart: tstart,
                tend: tend
            })).then(res => {
                var baseurl = this.$refs.baseurl.value;
                window.open(baseurl+'/uploads/laporan/aset.csv');
            }).catch(err => {
                console.log(err);
            });
        }
    }
});