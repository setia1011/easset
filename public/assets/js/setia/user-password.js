var application = new Vue({
    el: '#v-pass',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        loading: false,
        linfo: false,
        ainfo: null,
        o_password: null,
        n_password: null,
        c_password: null,
        o_valid: false,
        n_valid: false,
        c_valid: false,
        x_valid: false
    },
    watch: {
        o_password: _.debounce(
            function() {
                this.validateoPass('o');
            }, 500
        ),
        n_password: _.debounce(
            function() {
                this.validatenPass('n');
            }, 500
        ),
        c_password: _.debounce(
            function() {
                this.validatecPass('c');
            }, 500
        )
    },
    mounted() {
    },
    methods: {
        validateoPass: function(v) {
            var password = null;
            if (v === 'o') { password = this.o_password; }
            axios.post('../auth/validate-pass', JSON.stringify({
                ref: v,
                password: password
            })).then(res => {
                if (v === 'o' && res.data === 'valid') { this.o_valid = true; } else { this.o_valid = false; }
            }).catch(err => {
                console.log(err);
            });
        },
        validatenPass: function(v) {
            var password = null;
            if (v === 'n') { password = this.n_password; }
            axios.post('../auth/validate-pass', JSON.stringify({
                ref: v,
                password: password
            })).then(res => {
                if (v === 'n' && res.data === 'valid') { this.n_valid = true; } else { this.n_valid = false; }
                this.confirmPass();
            }).catch(err => {
                console.log(err);
            });
        },
        validatecPass: function(v) {
            var password = null;
            if (v === 'c') { password = this.c_password; }
            axios.post('../auth/validate-pass', JSON.stringify({
                ref: v,
                password: password
            })).then(res => {
                if (v === 'c' && res.data === 'valid') { this.c_valid = true; } else { this.c_valid = false; }
                this.confirmPass();
            }).catch(err => {
                console.log(err);
            });
        },
        confirmPass: function(v) {
            if (this.n_valid || this.c_valid) {
                axios.post('../auth/confirm-pass', JSON.stringify({
                    n_password: this.n_password,
                    c_password: this.c_password
                })).then(res => {
                    if (res.data === 'valid') { this.x_valid = true; } else { this.x_valid = false; }
                }).catch(err => {
                    console.log(err);
                });
            }
        },
        updatePass: function() {
            if (this.o_valid && this.x_valid) {
                this.loading = true;
                axios.post('../auth/update-pass', JSON.stringify({
                    n_password: this.n_password,
                    c_password: this.c_password
                })).then(res => {
                    if (res.data === 'Berhasil update password') {
                        this.ainfo = res.data;
                        setTimeout(() => {
                            this.loading = false;
                            this.linfo = true;
                            setTimeout(() => {
                                this.linfo = false;
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
            }
        }
    }
});