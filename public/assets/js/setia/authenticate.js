var application = new Vue({
    el: '#login',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        loading: false,
        linfo: false,
        ainfo: null,
        username: null,
        password: null
    },
    watch: {
    },
    mounted() {
    },
    methods: {
        showMessage: function() {
            console.log(34);
        },
        auth: function() {
            this.loading = true;
            axios.post('../auth/authenticate', JSON.stringify({
                username: this.username,
                password: this.password
            })).then(res => {
                if (!_.isEmpty(res.data.userInfo)) {
                    if (res.data.userInfo['credential'] == 1) {
                        this.ainfo = "Berhasil login..";
                        setTimeout(() => {
                            this.loading = true;
                            setTimeout(() => {
                                this.loading = false;
                                this.loading
                                this.linfo = true;
                                setTimeout(() => {
                                    this.linfo = false;
                                    window.location.replace('/');
                                }, 1500);
                            }, 1000);
                        }, 1000);
                    } else {
                        this.ainfo = "Username dan/atau password tidak valid!";
                        setTimeout(() => this.loading = false, 1000);
                    }
                } else {
                    this.ainfo = "Username dan/atau password tidak valid!";
                    setTimeout(() => {
                        this.loading = true;
                        setTimeout(() => {
                            this.loading = false;
                            this.loading
                            this.linfo = true;
                            setTimeout(() => {
                                this.linfo = false;
                            }, 1500);
                        }, 1000);
                    }, 1000);
                }
                
            }).catch(err => {
                console.log(err);
            });
        }
    }
});