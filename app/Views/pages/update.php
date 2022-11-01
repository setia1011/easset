<?php $this->extend('templates/main'); ?>

<?php $this->section('contents') ?>

<link rel="stylesheet" href="<?php echo base_url('assets/plugins/vue-select/vue-select.css'); ?>">

<style>
   /* vue-select */
   .vs__dropdown-menu li {
        margin-left: -2px;
    }
    .vs__no-options {
        text-align: left !important;
        padding-left: 8px;
    }
    .vs__search, .vs__search:focus {
        padding-top: 3px;
        padding-bottom: 3px;
        padding-left: 15px;
    }
    /* clear x symbol */
    .vs__clear {
        width: 20px;
        margin-bottom: 1px;
    }
    .vs__actions > svg {
        width: 20px;
        padding: 9px 0 0 0;
    }
    .vs__selected {
        padding: 0 0.25em 0 0.9em;
    }
</style>

<div id="v-update">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Update</h3>
                <div class="nk-block-des text-soft">
                    <p>Form update aset</p>
                </div>
            </div>
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="row gy-4">
            <div class="col-md-8">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <!-- <div class="card-head">
                            <h5 class="card-title">Header</h5>
                        </div> -->
                        <div id="form-pemasukan">
                            <div class="row g-4">
                                <input type="hidden" ref="aid" value="<?= $aid; ?>">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama</label>
                                        <div class="form-control-wrap">
                                            <input v-model="nama" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Uraian</label>
                                        <div class="form-control-wrap">
                                            <textarea v-model="uraian" class="form-control form-control-sm"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Merk</label>
                                        <div class="form-control-wrap">
                                            <input v-model="merk" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Jenis</label>
                                        <div class="form-control-wrap">
                                            <v-select 
                                                :disabled="dio.jenis === true" 
                                                label="jenis" 
                                                v-model="jenis" 
                                                :reduce="jenis => jenis.id" 
                                                :options="jenis_options" 
                                                placeholder="Choose jenis"
                                                @search="fetchOptJenis"
                                                @search:focus="fetchOptJenis" 
                                                @input="selectedOptJenis">
                                            </v-select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row row gy-3">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">Jumlah</label>
                                                <div class="form-control-wrap">
                                                    <input v-model="jumlah" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">Satuan</label>
                                                <div class="form-control-wrap">
                                                    <!-- <input v-model="satuan" type="text" class="form-control"> -->
                                                    <v-select 
                                                        :disabled="dio.satuan === true" 
                                                        label="satuan" 
                                                        v-model="satuan" 
                                                        :reduce="satuan => satuan.id" 
                                                        :options="satuan_options" 
                                                        placeholder="Choose satuan"
                                                        @search="fetchOptSatuan"
                                                        @search:focus="fetchOptSatuan" 
                                                        @input="selectedOptSatuan">
                                                    </v-select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Kondisi</label>
                                        <div class="form-control-wrap">
                                            <!-- <input v-model="kondisi" type="text" class="form-control"> -->
                                            <v-select 
                                                :disabled="dio.kondisi === true" 
                                                label="kondisi" 
                                                v-model="kondisi" 
                                                :reduce="kondisi => kondisi.id" 
                                                :options="kondisi_options" 
                                                placeholder="Choose kondisi"
                                                @search="fetchOptKondisi"
                                                @search:focus="fetchOptKondisi" 
                                                @input="selectedOptKondisi">
                                            </v-select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Foto</label>
                                        <div class="form-control-wrap">
                                            <div class="form-file">
                                                <input @change="uploadFoto" ref="foto" type="file" class="form-file-input">
                                                <label class="form-file-label">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <div class="form-control-wrap">
                                            <v-select 
                                                v-model="status" 
                                                :reduce="label => label.code" 
                                                :options="status_options"></v-select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" v-on:click="updateAset" class="btn btn-lg btn-primary">Save</button>
                                    </div>
                                </div>

                                <div class="loading-info" v-show="loading">
                                    <span><img src="<?= base_url('assets/images/utils/loading.svg'); ?>"> saving..</span>
                                </div>
                                <div class="login-info" v-show="linfo">
                                    <div v-if="ainfo == 'Berhasil menyimpan data aset'" class="alert alert-success alert-icon">
                                        <em class="icon ni ni-check-circle"></em> <strong>{{ ainfo }}</strong>
                                    </div>
                                    <div v-else class="alert alert-danger alert-icon">
                                        <em class="icon ni ni-cross-circle"></em> <strong>{{ ainfo }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="row g-gs">
                            <div class="col-sm-12 col-lg-12">
                                <div class="gallery card">
                                    <a class="gallery-image popup-image" :href="fotoUrl">
                                        <img class="w-100 rounded-top" v-if="fotoUrl" :src="fotoUrl" alt="">
                                    </a>
                                    <div class="gallery-body align-center justify-between flex-wrap g-2 mt-3">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">{{ nama }}</span>
                                                <span class="sub-text">{{ uraian }}</span>
                                                <div class="mt-3">
                                                    <span class="lead-text text-capitalize">
                                                        <span class="d-sm-inline-block" style="width: 80px;"><em class="icon ni ni-check"></em> Jenis</span>
                                                        <span class="text-muted">:</span>&nbsp; {{ jenis_text }}
                                                    </span>
                                                    <span class="lead-text text-capitalize">
                                                        <span class="d-sm-inline-block" style="width: 80px;"><em class="icon ni ni-check"></em> Merk</span>
                                                        <span class="text-muted">:</span>&nbsp; {{ merk }}
                                                    </span>
                                                    <span class="lead-text text-capitalize">
                                                        <span class="d-sm-inline-block" style="width: 80px;"><em class="icon ni ni-check"></em> Jumlah</span>
                                                        <span class="text-muted">:</span>&nbsp; {{ jumlah }} {{ satuan_text }}
                                                    </span>
                                                    <span class="lead-text text-capitalize">
                                                        <span class="d-sm-inline-block" style="width: 80px;"><em class="icon ni ni-check"></em> Kondisi</span>
                                                        <span class="text-muted">:</span>&nbsp; {{ kondisi_text }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="btn btn-outline-light bg-white d-sm-inline-flex mt-4"><em class="icon ni ni-list-check text-success"></em><span>total = {{ aset_count }}</span></div> -->
            </div>
        </div>
        
    </div><!-- .nk-block -->
</div>


<?php $this->endSection() ?>