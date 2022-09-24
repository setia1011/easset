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

<div id="v-profile">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Profile</h3>
                <div class="nk-block-des text-soft">
                    <p>Personal information, like your name and ID, that you use on e-asset.</p>
                </div>
            </div>
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="card-head">
                    <h5 class="card-title"><em class="icon ni ni-user-check"></em></h5>
                </div>
                <div class="gy-3">
                    <div class="row g-3 align-center">
                        <div class="col-lg-4">
                            <input type="hidden" ref="uid" value="<?= $_SESSION['id']; ?>">
                            <div class="form-group">
                                <label class="form-label" for="site-name">Username</label>
                                <span class="form-note text-not-italic">{{ username }}</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" disabled v-model="username">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Nama</label>
                                <span class="form-note text-not-italic">{{ nama }}</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" v-model="nama">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">ID</label>
                                <span class="form-note text-uppercase text-not-italic">{{ jenis_id }} {{ nomor_id }}</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="row gy-3">
                                        <div class="col-sm-6">
                                            <v-select 
                                                v-model="jenis_id"
                                                :reduce="label => label.code" 
                                                :options="jenis_id_options">
                                            </v-select>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" v-model="nomor_id">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <span class="form-note text-not-italic">{{ email }}</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" v-model="email">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Level</label>
                                <span class="form-note text-not-italic">{{ level }}</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" disabled v-model="level">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Registered At</label>
                                <span class="form-note text-not-italic">{{ registered_at }}</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" disabled v-model="registered_at">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <span class="form-note text-not-italic">{{ status }}</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" disabled v-model="status">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-lg-8 offset-lg-4">
                            <div class="form-group mt-2">
                                <button type="submit" v-on:click="updateUser" class="btn btn-mid btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-lg-8 offset-lg-4">
                            <div class="loading-info" v-show="loading">
                                <span><img src="<?= base_url('assets/images/utils/loading.svg'); ?>"> updating..</span>
                            </div>
                            <div class="login-info" v-show="linfo">
                                <div v-if="ainfo == 'Profile berhasil diupdate..'" class="alert alert-success alert-icon">
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
    </div><!-- .nk-block -->
</div>


<?php $this->endSection() ?>