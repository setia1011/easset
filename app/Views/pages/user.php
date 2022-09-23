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
                    <p>You have <b>{{ totalRows }}</b> of total <b>{{ totalUser }}</b> users.</p>
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
                                    <button type="button" class="btn btn-icon btn-success" v-on:click="createMode" data-bs-toggle="modal" data-bs-target="#modalAddUser">
                                        <em class="icon ni ni-user-add"></em>
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
                                    <em class="icon ni ni-user-list"></em>
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
                                <input type="text" class="form-control border-transparent form-focus-none" v-model="search" placeholder="Search by nama">
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
                                <span 
                                    class="tb-status" 
                                    v-bind:class="{'text-success': item.status == 'aktif', 'text-danger': item.status == 'tidak aktif'}">{{ item.status}}</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <button 
                                    type="button" 
                                    v-on:click="editUser(item.id)" 
                                    class="btn btn-icon btn-secondary btn-table-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalAddUser">
                                        <!-- <em class="icon ni ni-pen2"></em> -->
                                        <em class="icon ni ni-account-setting"></em>
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
            </div><!-- .card-inner-group -->
        </div><!-- .card -->
    </div><!-- .nk-block -->

    <!-- Modal Content Code -->
    <div class="modal fade" tabindex="-1" id="modalAddUser">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" ref="baka" v-on:click="createMode" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title" v-if="mode === 'create'">Create user (<em class="icon ni ni-user-add"></em>)</h5>
                    <h5 class="modal-title" v-if="mode === 'update'">Update user (<em class="icon ni ni-account-setting"></em>)</h5>
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
                                        <v-select 
                                            v-model="jenis_id"
                                            :reduce="label => label.code" 
                                            :options="jenis_id_options">
                                        </v-select>
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
                        <div class="row mt-2">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Level</label>
                                    <div class="form-control-wrap">
                                        <v-select 
                                            v-model="level" 
                                            :reduce="label => label.code" 
                                            :options="level_options">
                                        </v-select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
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
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" v-if="mode === 'create'" v-on:click="createUser" class="btn btn-lg btn-success">Create</button>
                            <button type="submit" v-if="mode === 'update'" v-on:click="createUser" class="btn btn-lg btn-warning">Update</button>
                        </div>
                        <div class="loading-info" v-show="loading">
                            <span v-if="mode === 'create'"><img src="<?= base_url('assets/images/utils/loading.svg'); ?>"> creating..</span>
                            <span v-if="mode === 'update'"><img src="<?= base_url('assets/images/utils/loading.svg'); ?>"> updating..</span>
                        </div>
                        <div class="login-info" v-show="linfo">
                            <div v-if="ainfo == 'User berhasil dibuat..' || ainfo == 'User berhasil diupdate..'" class="alert alert-success alert-icon">
                                <em class="icon ni ni-check-circle"></em> <strong>{{ ainfo }}</strong>
                            </div>
                            <div v-else-if="ainfo == 'Tidak ada perubahan data..'" class="alert alert-warning alert-icon">
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