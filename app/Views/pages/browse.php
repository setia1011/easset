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
    .page-item, .page-link {
        background-color: white;
    }
</style>

<div id="v-browse">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title"><?= $pagename;?></h3>
                <div class="nk-block-des text-soft">
                    <p>Browse aset</p>
                </div>
            </div>
            <div class="nk-block-head-content">
                <!-- <h3 class="nk-block-title page-title"><?= $pagename; ?></h3> -->
                <div class="nk-block-des text-soft">
                    <div class="form-control-wrap">
                        <div class="form-icon form-icon-right">
                            <em class="icon ni ni-search"></em>
                        </div>
                        <input type="text" class="form-control" v-model="search" placeholder="Search by nama">
                    </div>
                </div>
            </div>
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-sm-6 col-lg-3" v-for="(item, index) in items">
                <div class="gallery card card-bordered">
                    <?php if ($_SESSION['level'] == 'admin') { ?> <a :href="item.edit" class="edit-icon"><em class="icon ni ni-edit"></em></a> <?php } ?>
                    <span class="gallery-image popup-image" v-on:click="fetchDetails($event, item.id)" data-bs-toggle="modal" data-bs-target="#modalDetails">
                        <img class="w-100 rounded-top f-200" :src="item.foto" alt="">
                    </span>
                    <div class="gallery-body card-inner align-center justify-between flex-wrap g-2">
                        <div class="user-card">
                            <div class="user-info">
                                <span class="lead-text">{{ item.nama }}</span>
                                <span class="badge bg-danger">{{ item.jenis }}</span>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-p-0 btn-nofocus text-capitalize">
                                <span v-bind:class="[(item.jumlah > 0) ? 'text-primary' : 'text-danger']">{{ item.jumlah }} {{ item.satuan }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <span class="pagination justify-content-center justify-content-md-start" v-if="items !== null">
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
    </div><!-- .nk-block -->
    <div class="modal fade" tabindex="-1" id="modalDetails">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" ref="baka" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Detail</h5>
                </div>
                <div class="modal-body">
                    <div class="form-validate is-alter">
                        <div class="row gy-3 mb-3">
                            <span class="gallery-image">
                                <img class="w-100 rounded-top f-500" :src="details.foto" alt="">
                            </span>
                        </div>
                        <div class="row gy-3">
                            <div class="col-sm-6">
                                <div class="mt-3">
                                    <h4 class="product-title text-capitalize">{{ details.nama }}</h4>
                                    <span class="lead-text text-capitalize">
                                        <span style="width: 20px;">{{ details.uraian }}</span> 
                                    </span>
                                    <br>
                                    <span class="lead-text text-capitalize">
                                        <span class="d-sm-inline-block" style="width: 120px;"><em class="icon ni ni-check"></em> Merk</span>: {{ details.merk }}  
                                    </span> 
                                    <span class="lead-text text-capitalize">
                                        <span class="d-sm-inline-block" style="width: 120px;"><em class="icon ni ni-check"></em> Jenis</span>: {{ details.jenis }} 
                                    </span>
                                    <span class="lead-text text-capitalize">
                                        <span class="d-sm-inline-block" style="width: 120px;"><em class="icon ni ni-check"></em> Kondisi</span>: {{ details.kondisi }} 
                                    </span>
                                    <span class="lead-text text-capitalize">
                                        <span class="d-sm-inline-block" style="width: 120px;"><em class="icon ni ni-check"></em> Status/Stock</span>: {{ details.status }} ({{ details.jumlah }} {{ details.satuan }}) 
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12 mt-2">
                                        <div class="form-control-wrap number-spinner-wrap" style="width: 140px; float: right;">
                                            <button class="btn btn-icon btn-primary number-spinner-btn number-minus" data-number="minus">
                                                <em class="icon ni ni-minus"></em>
                                            </button>
                                            <input type="number" ref="qx" class="form-control number-spinner" :value="qty" :min="min" :max="details.jumlah">
                                            <button class="btn btn-icon btn-primary number-spinner-btn number-plus" data-number="plus">
                                                <em class="icon ni ni-plus"></em>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mt-2">
                                        <button type="submit" v-on:click="bookAset" class="btn btn-md" v-bind:class = "(bid !== null) ? 'btn-danger' : 'btn-primary'" style="float: right;">Book</button>
                                    </div>
                                    <div class="col-sm-12 mt-2">
                                        <!-- <div class="alert alert-success alert-icon">
                                            <em class="icon ni ni-check-circle"></em> <strong>asas</strong>
                                        </div> -->
                                        <div class="loading-info" style="float: right;" v-show="loading">
                                            <span><img src="<?= base_url('assets/images/utils/loading.svg'); ?>"> Processing..</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group mt-4">
                            <button type="submit" class="btn btn-lg btn-success">Create</button>
                            <button type="submit" class="btn btn-lg btn-warning">Update</button>
                        </div> -->
                        <!-- <div class="loading-info" v-show="loading">
                            <span v-if="mode === 'create'"><img src="<?= base_url('assets/images/utils/loading.svg'); ?>"> creating..</span>
                            <span v-if="mode === 'update'"><img src="<?= base_url('assets/images/utils/loading.svg'); ?>"> updating..</span>
                        </div> -->
                        <!-- <div class="login-info" v-show="linfo">
                            <div v-if="ainfo == 'User berhasil dibuat..' || ainfo == 'User berhasil diupdate..'" class="alert alert-success alert-icon">
                                <em class="icon ni ni-check-circle"></em> <strong>{{ ainfo }}</strong>
                            </div>
                            <div v-else-if="ainfo == 'Tidak ada perubahan data..'" class="alert alert-warning alert-icon">
                                <em class="icon ni ni-check-circle"></em> <strong>{{ ainfo }}</strong>
                            </div>
                            <div v-else class="alert alert-danger alert-icon">
                                <em class="icon ni ni-cross-circle"></em> <strong>{{ ainfo }}</strong>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->endSection() ?>