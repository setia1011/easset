Vue.component('paginate', VuejsPaginate);
Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#v-kondisi',
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
        kondisi: null,
        uraian: null,
        status_options: [
            {label: 'Aktif', code: 'aktif'}, 
            {label: 'Tidak Aktif', code: 'tidak aktif'},
        ],
        status: null,
        kid: null
    },
    watch: {
        mode: function() {
            if (this.mode === 'create') {
                this.resetForm();
            }
        },
        search: _.debounce(
            function() {
               this.fetchKondisi();
            }, 500
        ),
    },
    computed: {
        getPageCount: function() {
            return this.totalPage;
        }
    },
    mounted() {
        this.fetchKondisi();
        this.status = 'aktif';
    },
    methods: {
        clickCallback: function(pageNum) {
            this.currentPage = Number(pageNum);
            this.fetchKondisi();
        },
        fetchKondisi: function() {
            axios.post('../ref/all-kondisi-aset', JSON.stringify({
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
        saveKondisi: function() {
            if (this.kondisi && this.uraian && this.status) {
                this.loading = true;
                axios.post('../ref/save-kondisi-aset', JSON.stringify({
                    mode: this.mode,
                    kid: this.kid,
                    kondisi: this.kondisi,
                    uraian: this.uraian,
                    status: this.status
                })).then(res => {
                    if (res.data === 'Berhasil menyimpan data kondisi') {
                        this.ainfo = res.data;
                        setTimeout(() => {
                            this.loading = false;
                            this.linfo = true;
                            setTimeout(() => {
                                this.linfo = false;
                                this.fetchKondisi();
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
        editKondisi: function(kid) {
            this.mode = 'edit';
            this.kid = kid;
            axios.post('../ref/a-kondisi', JSON.stringify({
                kid: kid
            })).then(res => {
                this.kondisi = res.data.kondisiInfo[0].kondisi;
                this.uraian = res.data.kondisiInfo[0].uraian;
                this.status = res.data.kondisiInfo[0].status;
            }).catch(err => {
                console.log(err);
            });
        },
        resetForm: function() {
            this.mode = 'create';
            this.kid = null;
            this.kondisi = null,
            this.uraian = null;
            this.status = 'aktif';
        },
        delKondisi: function(kid) {
            axios.post('../ref/delete-kondisi', JSON.stringify({
                kid: kid
            })).then(res => {
                this.resetForm();
                this.fetchKondisi();
            }).catch(err => {
                console.log(err);
            });
        }
    }
});