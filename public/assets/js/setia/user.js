Vue.component('paginate', VuejsPaginate);
Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#v-user',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        loading: false,
        linfo: false,
        ainfo: null,
        search: "",
        items: null,
        action: null,
        totalPage: null,
        currentPage: 1,
        perPage: 8,
        page: null,
        jenis_id_options: [
            {label: 'NIK', code: 'nik'}, 
            {label: 'NIP', code: 'nip'},
            {label: 'NIM', code: 'nim'},
            {label: 'KTA', code: 'kta'}
        ],
        level_options: [
            {label: 'Admin', code: 'admin'}, 
            {label: 'Client', code: 'client'},
        ],
        status_options: [
            {label: 'Aktif', code: 'aktif'}, 
            {label: 'Tidak Aktif', code: 'tidak aktif'},
        ],
        username: null,
        password: null,
        level: null,
        nama: null,
        email: null,
        jenis_id: null,
        nomor_id: null,
        status: null
    },
    watch: {
        level: function() {
            console.log(this.level);
        }
    },
    computed: {
        getPageCount: function() {
            return this.totalPage;
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        clickCallback: function(pageNum) {
            this.currentPage = Number(pageNum);
            this.fetchData();
        },
        fetchData: function() {
            axios.post('../user/all-users', JSON.stringify({
                data: {
                    search: this.search,
                    perPage: this.perPage,
                    currentPage: this.currentPage
                }
            })).then(res => {
                // console.log(res.data);
                this.items = res.data['items'];
                res.data['items'].forEach(e => {
                    if (e.kode_bc_eselon3) {
                        this.checkedWilayah.push(e.id_wilayah);
                    }
                });
                this.totalPage = res.data['totalPage'];
                this.index = this.currentPage * this.perPage;
            }).catch(err => {
                console.log(err);
            });
        },
        selectedLevel: function(v) {
            this.level = v.code;
        },
        selectedJenisId: function(v) {
            this.jenis_id = v.code;
        },
        selectedStatus: function(v) {
            this.status = v.code;
        },
        createUser: function() {
            this.loading = true;
            axios.post('../user/create-user', JSON.stringify({
                username: this.username,
                password: this.password,
                level: this.level,
                nama: this.nama,
                email: this.email,
                jenis_id: this.jenis_id,
                nomor_id: this.nomor_id,
                status: this.status
            })).then(res => {
                if (res.data.message === 'User berhasil dibuat..') {
                    this.ainfo = res.data.message;
                    setTimeout(() => {
                        this.loading = true;
                        setTimeout(() => {
                            this.loading = false;
                            this.loading
                            this.linfo = true;
                            setTimeout(() => {
                                this.linfo = false;
                                // close modal
                                const elem = this.$refs.baka;
                                elem.click();
                                // update data user
                                this.fetchData();
                            }, 1500);
                        }, 1000);
                    }, 1000);
                } else {
                    this.ainfo = res.data.message;
                    setTimeout(() => {
                        this.loading = true;
                        setTimeout(() => {
                            this.loading = false;
                            this.loading
                            this.linfo = true;
                            setTimeout(() => {
                                this.linfo = false;
                                // this.modalCreateUser = false;
                                const elem = this.$refs.baka;
                                elem.click();
                            }, 1500);
                        }, 1000);
                    }, 1000);
                }
            }).catch(err => {
                console.log(err);
            });
        },
    }
});