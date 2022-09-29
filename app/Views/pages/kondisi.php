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

<div id="v-kondisi">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Kondisi</h3>
                <div class="nk-block-des text-soft">
                    <p>Manajamen referensi kondisi aset</p>
                </div>
            </div>
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-lg-4">
                <div class="btn btn-sm mb-4 btn-secondary text-uppercase" v-on:click="resetForm"><em class="icon ni ni-update"></em></div>
                <div class="btn btn-sm mb-4 text-uppercase" v-bind:class="[(mode === 'create') ? 'btn-info' : 'btn-warning']">{{ mode }}</div>
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div id="form-jenis">
                            <div class="form-group">
                                <label class="form-label">Kondisi</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" v-model="kondisi">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Uraian</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control form-control-sm" v-model="uraian"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="form-control-wrap">
                                    <v-select 
                                        v-model="status" 
                                        :reduce="label => label.code" 
                                        :options="status_options"></v-select>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" v-if="mode === 'create'" v-on:click="saveKondisi" class="btn btn-info">Save</button>
                                <button type="submit" v-if="mode === 'edit'" v-on:click="saveKondisi" class="btn btn-warning">Save</button>
                            </div>
                            <div class="loading-info" v-show="loading">
                                <span><img src="<?= base_url('assets/images/utils/loading.svg'); ?>"> saving..</span>
                            </div>
                            <div class="login-info" v-show="linfo">
                                <div v-if="ainfo == 'Berhasil menyimpan data kondisi'" class="alert alert-success alert-icon">
                                    <em class="icon ni ni-check-circle"></em> <strong>{{ ainfo }}</strong>
                                </div>
                                <div v-else-if="ainfo == 'Tidak ada perubahan data kondisi'" class="alert alert-warning alert-icon">
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
            <div class="col-lg-8">
                <div class="card card-bordered h-100">
                    <div class="card-inner">
                        <!-- <div class="card-head">
                            <h5 class="card-title">Table</h5>
                        </div> -->
                        <div class="nk-fmg-search">
                            <em class="icon ni ni-search"></em>
                            <input type="text" v-model="search" class="form-control border-transparent form-focus-none w-40" placeholder="Cari jenis aset">
                        </div>
                        <div class="border-bottom mb-4 w-40"></div>
                        <div>
                            <div class="card-inner p-0">
                                <div class="nk-tb-list nk-tb-ulist is-compact">
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span class="sub-text">Kondisi</span></div>
                                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Uraian</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Status</span></div>
                                        <div class="nk-tb-col nk-tb-col-tools text-end"></div>
                                    </div><!-- .nk-tb-item -->
                                    <div class="nk-tb-item" v-for="(item, index) in items">
                                        <div class="nk-tb-col">
                                            <div class="user-card">
                                                <div class="user-name">
                                                    <span class="tb-lead">{{ item.kondisi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            <span>{{ item.uraian }}</span>
                                        </div>
                                        <div class="nk-tb-col">
                                            <span 
                                                class="tb-status" 
                                                v-bind:class="{'text-success': item.status == 'aktif', 'text-danger': item.status == 'tidak aktif'}">{{ item.status}}</span>
                                        </div>
                                        <div class="nk-tb-col tb-col-md" style="text-align: right;">
                                            <button 
                                                type="button" 
                                                v-on:click="editKondisi(item.id)" 
                                                class="btn btn-sm btn-icon btn-warning btn-table-sm">
                                                    <em class="icon ni ni-edit"></em>
                                            </button>
                                            <button 
                                                type="button" 
                                                v-on:click="delKondisi(item.id)" 
                                                class="btn btn-sm btn-icon btn-danger btn-table-sm">
                                                    <em class="icon ni ni-trash"></em>
                                            </button>
                                        </div>
                                    </div><!-- .nk-tb-item -->
                                </div><!-- .nk-tb-list -->
                            </div><!-- .card-inner -->
                            <span class="card-inner pagination justify-content-center justify-content-md-start" v-if="items !== null">
                                <paginate 
                                    first-last-button
                                    :page-count="getPageCount" 
                                    :page-range="3" 
                                    :margin-pages="1" 
                                    :click-handler="clickCallback" 
                                    :disabled-class="'disabled'"
                                    :active-class="'active'"
                                    :prev-link-class="'page-link'"
                                    :prev-text="'<'" 
                                    :next-link-class="'page-link'"
                                    :next-text="'＞'"
                                    :container-class="'pagination'" 
                                    :page-class="'page-item'"
                                    :page-link-class="'page-link'">
                                </paginate>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .nk-block -->
</div>


<?php $this->endSection() ?>