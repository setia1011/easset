<?php $this->extend('templates/main'); ?>

<?php $this->section('contents') ?>

<div id="v-pemasukan">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Pemasukan</h3>
                <div class="nk-block-des text-soft">
                    <p>Form rekam pemasukan aset</p>
                </div>
            </div>
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="card card-bordered">
            <div class="card-inner">
                <!-- <div class="card-head">
                    <h5 class="card-title">Header</h5>
                </div> -->
                <div id="form-pemasukan">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="email-address-1">Nama</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="email-address-1">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="phone-no-1">Uraian</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control form-control-sm" id="cf-default-textarea" placeholder="Write your message"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Jenis</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="full-name-1">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row row gy-3">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="pay-amount-1">Jumlah</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="pay-amount-1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="pay-amount-1">Satuan</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="pay-amount-1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="phone-no-1">Kondisi</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="pay-amount-1">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="customFileLabel">Foto</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-file-input" id="customFile">
                                        <label class="form-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary">Save Informations</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .nk-block -->
</div>


<?php $this->endSection() ?>