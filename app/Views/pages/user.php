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

<div id="v-user">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Users Lists</h3>
                <div class="nk-block-des text-soft">
                    <p>You have total 2,595 users.</p>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                            <li class="nk-block-tools-opt">
                                <div class="drodown">
                                    <button type="button" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddUser">
                                        <em class="icon ni ni-plus"></em>
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div><!-- .toggle-wrap -->
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="card card-bordered card-stretch">
            <div class="card-inner-group">
                <div class="card-inner position-relative card-tools-toggle">
                    <div class="card-title-group">
                        <div class="card-tools">
                            <div class="form-inline flex-nowrap gx-3">
                                <div class="form-wrap w-100px">
                                    Test
                                </div>
                                <div class="btn-wrap">
                                    Test 2
                                </div>
                            </div><!-- .form-inline -->
                        </div><!-- .card-tools -->
                        <div class="card-tools me-n1">
                            <ul class="btn-toolbar gx-1">
                                <li>
                                    <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                                </li><!-- li -->
                            </ul><!-- .btn-toolbar -->
                        </div><!-- .card-tools -->
                    </div><!-- .card-title-group -->
                    <div class="card-search search-wrap" data-search="search">
                        <div class="card-body">
                            <div class="search-content">
                                <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                <input type="text" class="form-control border-transparent form-focus-none" placeholder="Search by user or email">
                                <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                            </div>
                        </div>
                    </div><!-- .card-search -->
                </div><!-- .card-inner -->
                <div class="card-inner p-0">
                    <div class="nk-tb-list nk-tb-ulist is-compact">
                        <div class="nk-tb-item nk-tb-head">
                            <div class="nk-tb-col"><span class="sub-text">Nama</span></div>
                            <div class="nk-tb-col tb-col-md"><span class="sub-text">Level</span></div>
                            <div class="nk-tb-col tb-col-sm"><span class="sub-text">Email</span></div>
                            <div class="nk-tb-col tb-col-md"><span class="sub-text">Jenis ID</span></div>
                            <div class="nk-tb-col tb-col-md"><span class="sub-text">Nomor ID</span></div>
                            <div class="nk-tb-col tb-col-md"><span class="sub-text">Created</span></div>
                            <div class="nk-tb-col"><span class="sub-text">Status</span></div>
                            <div class="nk-tb-col nk-tb-col-tools text-end"></div>
                        </div><!-- .nk-tb-item -->
                        <div class="nk-tb-item" v-for="(item, index) in items">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-name">
                                        <span class="tb-lead">{{ item.nama }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span>{{ item.level }}</span>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span>{{ item.email }}</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span>{{ item.jenis_id }}</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span>{{ item.nomor_id }}</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span>{{ item.created_at }}</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="tb-status" v-bind:class="{'text-success': item.status == 'aktif', 'text-danger': item.status == 'tidak aktif'}">{{ item.status}}</span>
                            </div>
                            <div class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-2">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                    <li><a href="#"><em class="icon ni ni-repeat"></em><span>Orders</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
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
                <!-- <div class="card-inner">
                    <ul class="pagination justify-content-center justify-content-md-start">
                        <li class="page-item"><a class="page-link" href="#">Prev</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                        <li class="page-item"><a class="page-link" href="#">7</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </div> -->
            </div><!-- .card-inner-group -->
        </div><!-- .card -->
    </div><!-- .nk-block -->

    <!-- Modal Content Code -->
    <div class="modal fade" tabindex="-1" id="modalAddUser">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" ref="baka" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Create user</h5>
                </div>
                <div class="modal-body">
                    <div class="form-validate is-alter">
                        <div class="row gy-3">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <div class="form-control-wrap">
                                        <input v-model="username" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <div class="form-control-wrap">
                                        <input v-model="password" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-label">Level</label>
                            <div class="form-control-wrap">
                                <v-select @input="selectedLevel" :options="level_options"></v-select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama</label>
                            <div class="form-control-wrap">
                                <input v-model="nama" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <div class="form-control-wrap">
                                <input v-model="email" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row gy-3">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Jenis ID</label>
                                    <div class="form-control-wrap">
                                        <v-select @input="selectedJenisId" :options="jenis_id_options"></v-select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">No. ID</label>
                                    <div class="form-control-wrap">
                                        <input v-model="nomor_id" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-label">Status</label>
                            <div class="form-control-wrap">
                                <v-select @input="selectedStatus" :options="status_options"></v-select>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" v-on:click="createUser" class="btn btn-lg btn-primary">Submit</button>
                        </div>
                        <div class="loading-info" v-show="loading">
                            <img src="<?= base_url('assets/images/utils/loading.svg'); ?>"> submitting..
                        </div>
                        <div class="login-info" v-show="linfo">
                            <div v-if="ainfo == 'User berhasil dibuat..'" class="alert alert-success alert-icon">
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
</div>


<?php $this->endSection() ?>