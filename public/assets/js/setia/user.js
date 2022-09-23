Vue.component('paginate', VuejsPaginate);
Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#v-user',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        mode: 'create',
        loading: false,
        linfo: false,
        ainfo: null,
        search: "",
        items: null,
        action: null,
        totalUser: null,
        totalRows: null,
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
        uid: null,
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
            // console.log(this.level);
        },
        search: _.debounce(
            function() {
               this.fetchData();
            }, 500
        ),
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
        clearUserInfo: function() {
            this.uid = null;
            this.username = null;
            this.password = null;
            this.level = null;
            this.nama = null;
            this.email = null;
            this.jenis_id = null;
            this.nomor_id = null;
            this.status = null;
        },
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
                this.totalUser = res.data['totalUser'];
                this.totalRows = res.data['totalRows'];
                this.items = res.data['items'];
                this.totalPage = res.data['totalPage'];
                this.index = this.currentPage * this.perPage;
            }).catch(err => {
                console.log(err);
            });
        },
        createMode: function() {
            this.mode = 'create';
            this.clearUserInfo();
        },
        createUser: function(ref) {
            this.loading = true;
            axios.post('../user/create-user', JSON.stringify({
                mode: this.mode,
                uid: this.uid,
                username: this.username,
                password: this.password,
                level: this.level,
                nama: this.nama,
                email: this.email,
                jenis_id: this.jenis_id,
                nomor_id: this.nomor_id,
                status: this.status
            })).then(res => {
                if (res.data.message === 'User berhasil dibuat..' || res.data.message === 'User berhasil diupdate..') {
                    this.ainfo = res.data.message;
                    setTimeout(() => {
                        this.loading = true;
                        setTimeout(() => {
                            this.loading = false;
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
                            this.linfo = true;
                            setTimeout(() => {
                                this.linfo = false;
                                // this.modalCreateUser = false;
                                // const elem = this.$refs.baka;
                                // elem.click();
                            }, 1500);
                        }, 1000);
                    }, 1000);
                }
            }).catch(err => {
                console.log(err);
            });
        },
        editUser: function(uid) {
            this.uid = uid;
            this.mode = 'update';
            axios.post('../user/a-user', JSON.stringify({
                uid: uid
            })).then(res => {
                this.username = res.data.userInfo[0].username;
                this.nama = res.data.userInfo[0].nama;
                this.nomor_id = res.data.userInfo[0].nomor_id;
                this.email = res.data.userInfo[0].email;
                this.level = res.data.userInfo[0].level;
                this.jenis_id = res.data.userInfo[0].jenis_id;
                this.status = res.data.userInfo[0].status;
            }).catch(err => {
                console.log(err);
            });
        }
    }
});