<?php $this->extend('templates/main'); ?>

<?php $this->section('contents') ?>

<div id="v-pass">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Password</h3>
                <div class="nk-block-des text-soft">
                    <p>Update password securely</p>
                </div>
            </div>
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-lg-6">
                <div class="card card-bordered h-100">
                    <div class="card-inner">
                        <div class="form-group">
                            <label class="form-label">Old <span v-if="o_valid"><b><em class="icon ni ni-check-thick text-success"></em></b></span></label>
                            <div class="form-control-wrap">
                                <input type="password" v-model="o_password" class="form-control border-secondary">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">New <span v-if="x_valid"><b><em class="icon ni ni-check-thick text-success"></em></b></span></label>
                            <div class="form-control-wrap">
                                <input type="password" v-model="n_password" class="form-control border-warning">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm <span v-if="x_valid"><b><em class="icon ni ni-check-thick text-success"></em></b></span></label>
                            <div class="form-control-wrap">
                                <input type="password" v-model="c_password" class="form-control border-warning">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" :disabled="!o_valid" v-on:click="updatePass" class="btn btn-mid btn-primary">Update</button>
                        </div>
                        <div class="loading-info" v-show="loading">
                            <span><img src="<?= base_url('assets/images/utils/loading.svg'); ?>"> updating..</span>
                        </div>
                        <div class="login-info" v-show="linfo">
                            <div v-if="ainfo == 'Berhasil update password'" class="alert alert-success alert-icon">
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
    </div><!-- .nk-block -->
</div>


<?php $this->endSection() ?>