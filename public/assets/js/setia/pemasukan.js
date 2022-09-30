Vue.component('paginate', VuejsPaginate);
Vue.component('v-select', VueSelect.VueSelect);
var application = new Vue({
    el: '#v-pemasukan',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        dio: {
            'jenis': false,
            'satuan': false,
            'kondisi': false
        },
        nama: null,
        uraian: null,
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
        foto: null
    },
    watch: {
    },
    mounted() {
        this.fetchOptJenis();
    },
    methods: {
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
            // const formData = new FormData();
            // formData.append('ref', 'foto');
            // formData.append('foto', this.foto);
            // const headers = { 'Content-Type': 'multipart/form-data' };

            this.fotoUrl = URL.createObjectURL(this.foto);

            // axios.post('../konsul_chat', formData, { headers }).then((res) => {
            //     res.data.files; // binary representation of the file
            //     res.status; // HTTP status
            //     if (res.data.info === 'failed') {
            //         console.log('failed');
            //     } else {
            //         var fi = res.data.info.substring(0, 25);
            //         if (fi === 'Ukuran file terlalu besar') {
            //             alert(res.data.info);
            //         }
            //         console.log(res.data.info);
            //     }
            //     this.fetchChats();
            // });
        }
    }
});