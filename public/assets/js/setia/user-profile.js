Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#v-profile',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        loading: false,
        linfo: false,
        ainfo: null,
        uid: null,
        items: [],
        username: null,
        nama: null,
        jenis_id: null,
        nomor_id: null,
        email: null,
        level: null,
        registered_at: null,
        status: null,
        jenis_id_options: [
            {label: 'NIK', code: 'nik'}, 
            {label: 'NIP', code: 'nip'},
            {label: 'NIM', code: 'nim'},
            {label: 'KTA', code: 'kta'}
        ],
    },
    watch: {
    },
    mounted() {
        this.uid = this.$refs.uid.value;
        this.fetchUserInfo();
    },
    methods: {
        fetchUserInfo: function() {
            axios.post('../user/a-user', JSON.stringify({
                uid: this.uid
            })).then(res => {
                if (!_.isEmpty(res.data.userInfo)) {
                    this.username = res.data.userInfo[0].username;
                    this.nama = res.data.userInfo[0].nama;
                    this.jenis_id = res.data.userInfo[0].jenis_id;
                    this.nomor_id = res.data.userInfo[0].nomor_id;
                    this.email = res.data.userInfo[0].email;
                    this.level = res.data.userInfo[0].level;
                    this.registered_at = res.data.userInfo[0].created_at;
                    this.status = res.data.userInfo[0].status;
                };

                console.log(res.data);
                
            }).catch(err => {
                console.log(err);
            });
        },
        updateUser: function() {
            this.loading = true;
            axios.post('../user/update-user', JSON.stringify({
                uid: this.uid,
                username: this.username,
                nama: this.nama,
                email: this.email,
                jenis_id: this.jenis_id,
                nomor_id: this.nomor_id
            })).then(res => {
                console.log(res.data);
                if (res.data.message === 'Profile berhasil diupdate..') {
                    this.ainfo = res.data.message;
                    setTimeout(() => {
                        this.loading = false;
                        this.linfo = true;
                        setTimeout(() => {
                            this.linfo = false;
                        }, 1500);
                    }, 1000);
                } else {
                    this.ainfo = res.data.message;
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
        }
    }
});