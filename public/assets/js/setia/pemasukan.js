Vue.component('paginate', VuejsPaginate);
Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#v-pemasukan',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        loading: false,
        linfo: false,
        ainfo: null,
        dio: {
            'jenis': false,
            'satuan': false,
            'kondisi': false
        },
        status: 'available',
        status_options: [
            {label: 'Available', code: 'available'}, 
            {label: 'Not Available', code: 'not available'},
        ],
        nama: null,
        uraian: null,
        merk: null,
        jenis: null,
        jenis_text: null,
        jenis_options: [],
        jumlah: null,
        satuan: null,
        satuan_text: null,
        satuan_options: [],
        kondisi: null,
        kondisi_text: null,
        kondisi_options: [],
        fotoUrl: "images/add-image.png",
        foto: null,
        aset_count: null
    },
    watch: {
    },
    mounted() {
        this.fetchOptJenis();
        this.fetchAset();
    },
    methods: {
        fetchAset: function() {
            axios.post('../app/fetch-aset', JSON.stringify({
            })).then(res => {
                console.log(res.data);
                this.aset_count = res.data.length;
            }).catch(err => {
                console.log(err);
            });
        },
        fetchOptJenis: function(search) {
            axios.post('../ref/fetch-refs', JSON.stringify({
                ref: 'jenis',
                search: search
            })).then(res => {
                console.log(res.data);
                this.jenis_options = res.data;
            }).catch(err => {
                console.log(err);
            });
        },
        selectedOptJenis: function(val) {
            this.jenis = val;
            for (var i = 0; i < this.jenis_options.length; i++) {
                if (this.jenis_options[i].id === this.jenis) {
                    this.jenis_text = this.jenis_options[i].jenis;
                }   
            }
        },
        fetchOptSatuan: function(search) {
            axios.post('../ref/fetch-refs', JSON.stringify({
                ref: 'satuan',
                search: search
            })).then(res => {
                console.log(res.data);
                this.satuan_options = res.data;
            }).catch(err => {
                console.log(err);
            });
        },
        selectedOptSatuan: function(val) {
            this.satuan = val;
            for (var i = 0; i < this.satuan_options.length; i++) {
                if (this.satuan_options[i].id === this.satuan) {
                    this.satuan_text = this.satuan_options[i].satuan;
                }   
            }
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
        uploadFoto: function() {
            this.foto = this.$refs.foto.files[0];
            this.fotoUrl = URL.createObjectURL(this.foto);
        },
        rekamAset: function() {
            this.loading = true;
            const formData = new FormData();
            formData.append('foto', this.foto);
            formData.append('nama', this.nama);
            formData.append('uraian', this.uraian);
            formData.append('merk', this.merk);
            formData.append('jenis', this.jenis);
            formData.append('jumlah', this.jumlah);
            formData.append('satuan', this.satuan);
            formData.append('kondisi', this.kondisi);
            formData.append('status', this.status);
            const headers = { 'Content-Type': 'multipart/form-data' };
            axios.post('../app/rekam-aset', formData, { headers }).then((res) => {
                if (res.data === 'Berhasil menyimpan data aset') {
                    this.ainfo = res.data;
                    setTimeout(() => {
                        this.loading = false;
                        this.linfo = true;
                        setTimeout(() => {
                            this.linfo = false;
                            this.fetchAset();
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
            });
        }
    }
});