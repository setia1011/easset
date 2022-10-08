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
                <h3 class="nk-block-title page-title"><?= $pagename; ?></h3>
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
                    <a class="gallery-image popup-image" :href="item.foto">
                        <img class="w-100 rounded-top" :src="item.foto" alt="">
                    </a>
                    <div class="gallery-body card-inner align-center justify-between flex-wrap g-2">
                        <div class="user-card">
                            <div class="user-info">
                                <span class="lead-text">{{ item.nama }}</span>
                                <span class="sub-text">{{ item.jenis }}</span>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-p-0 btn-nofocus text-capitalize">
                                <span v-bind:class="[(item.jumlah > 0) ? 'text-success' : 'text-danger']">{{ item.jumlah }} {{ item.satuan }}</span>
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
</div>


<?php $this->endSection() ?>