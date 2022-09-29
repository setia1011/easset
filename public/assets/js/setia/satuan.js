Vue.component('paginate', VuejsPaginate);
Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#v-satuan',
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
        satuan: null,
        uraian: null,
        status_options: [
            {label: 'Aktif', code: 'aktif'}, 
            {label: 'Tidak Aktif', code: 'tidak aktif'},
        ],
        status: null,
        sid: null
    },
    watch: {
        mode: function() {
            if (this.mode === 'create') {
                this.resetForm();
            }
        },
        search: _.debounce(
            function() {
               this.fetchSatuan();
            }, 500
        ),
    },
    computed: {
        getPageCount: function() {
            return this.totalPage;
        }
    },
    mounted() {
        this.fetchSatuan();
        this.status = 'aktif';
    },
    methods: {
        clickCallback: function(pageNum) {
            this.currentPage = Number(pageNum);
            this.fetchSatuan();
        },
        fetchSatuan: function() {
            axios.post('../ref/all-satuan-aset', JSON.stringify({
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
        saveSatuan: function() {
            if (this.satuan && this.uraian && this.status) {
                this.loading = true;
                axios.post('../ref/save-satuan-aset', JSON.stringify({
                    mode: this.mode,
                    sid: this.sid,
                    satuan: this.satuan,
                    uraian: this.uraian,
                    status: this.status
                })).then(res => {
                    if (res.data === 'Berhasil menyimpan data satuan') {
                        this.ainfo = res.data;
                        setTimeout(() => {
                            this.loading = false;
                            this.linfo = true;
                            setTimeout(() => {
                                this.linfo = false;
                                this.fetchSatuan();
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
        editSatuan: function(sid) {
            this.mode = 'edit';
            this.sid = sid;
            axios.post('../ref/a-satuan', JSON.stringify({
                sid: sid
            })).then(res => {
                this.satuan = res.data.satuanInfo[0].satuan;
                this.uraian = res.data.satuanInfo[0].uraian;
                this.status = res.data.satuanInfo[0].status;
            }).catch(err => {
                console.log(err);
            });
        },
        resetForm: function() {
            this.mode = 'create';
            this.sid = null;
            this.satuan = null,
            this.uraian = null;
            this.status = 'aktif';
        },
        delSatuan: function(sid) {
            axios.post('../ref/delete-satuan', JSON.stringify({
                sid: sid
            })).then(res => {
                this.fetchSatuan();
            }).catch(err => {
                console.log(err);
            });
        }
    }
});