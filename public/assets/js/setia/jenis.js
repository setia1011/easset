Vue.component('paginate', VuejsPaginate);
Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#v-jenis',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        mode: 'create',
        loading: false,
        linfo: false,
        search: "",
        items: [],
        totalUser: null,
        totalRows: null,
        totalPage: null,
        currentPage: 1,
        perPage: 8,
        page: null,
        ainfo: null,
        jenis: null,
        uraian: null,
        status_options: [
            {label: 'Aktif', code: 'aktif'}, 
            {label: 'Tidak Aktif', code: 'tidak aktif'},
        ],
        status: null,
        jid: null
    },
    watch: {
        mode: function() {
            if (this.mode === 'create') {
                this.resetForm();
            }
        },
        search: _.debounce(
            function() {
               this.fetchJenis();
            }, 500
        ),
    },
    computed: {
        getPageCount: function() {
            return this.totalPage;
        }
    },
    mounted() {
        this.fetchJenis();
        this.status = 'aktif';
    },
    methods: {
        clickCallback: function(pageNum) {
            this.currentPage = Number(pageNum);
            this.fetchJenis();
        },
        fetchJenis: function() {
            axios.post('../ref/all-jenis-aset', JSON.stringify({
                data: {
                    search: this.search,
                    perPage: this.perPage,
                    currentPage: this.currentPage
                }
            })).then(res => {
                // console.log(res.data);
                this.totalUser = res.data['totalUser'];
                this.totalRows = res.data['totalRows'];
                this.items = res.data['items'];
                this.totalPage = res.data['totalPage'];
                this.index = this.currentPage * this.perPage;
            }).catch(err => {
                console.log(err);
            });
        },
        saveJenis: function() {
            if (this.jenis && this.uraian && this.status) {
                this.loading = true;
                axios.post('../ref/save-jenis-aset', JSON.stringify({
                    mode: this.mode,
                    jid: this.jid,
                    jenis: this.jenis,
                    uraian: this.uraian,
                    status: this.status
                })).then(res => {
                    if (res.data === 'Berhasil menyimpan data jenis') {
                        this.ainfo = res.data;
                        setTimeout(() => {
                            this.loading = false;
                            this.linfo = true;
                            setTimeout(() => {
                                this.linfo = false;
                                this.fetchJenis();
                            }, 1500);
                        }, 1000);
                    } else {
                        this.ainfo = res.data;
                        setTimeout(() => {
                            this.loading = false;
                            this.linfo = true;
                            setTimeout(() => {
                                this.linfo = false;
                            }, 1500);
                        }, 1000);
                    }
                }).catch(err => {
                    console.log(err);
                });
            } else {
                console.log('null');
            }
        },
        editJenis: function(jid) {
            this.mode = 'edit';
            this.jid = jid;
            axios.post('../ref/a-jenis', JSON.stringify({
                jid: jid
            })).then(res => {
                this.jenis = res.data.jenisInfo[0].jenis;
                this.uraian = res.data.jenisInfo[0].uraian;
                this.status = res.data.jenisInfo[0].status;
            }).catch(err => {
                console.log(err);
            });
        },
        resetForm: function() {
            this.mode = 'create';
            this.jid = null;
            this.jenis = null,
            this.uraian = null;
            this.status = 'aktif';
        }
    }
});