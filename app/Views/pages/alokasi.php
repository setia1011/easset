<?php $this->extend('templates/main'); ?>

<?php $this->section('contents') ?>

<div id="v-alokasi">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Alokasi</h3>
                <div class="nk-block-des text-soft">
                    <p>Manajemen alokasi aset</p>
                </div>
            </div>
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="form-control-wrap mb-2">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search by aset">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim"><em class="icon ni ni-search"></em></button>
                </div>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Aset</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Book Qty</th>
                    <th scope="col">Book Date</th>
                    <th scope="col">User</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in items">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ item.nama }}</td>
                    <td>{{ item.jumlah }} ({{ item.satuan }})</td>
                    <td>{{ item.book_qty }} ({{ item.satuan }})</td>
                    <td>{{ item.created_atx }}</td>
                    <td>{{ item.book_user }}</td>
                    <td><button data-bs-toggle="modal" data-bs-target="#modalDetails" v-on:click="fetchDetails($event, item.id)" style="float: right;" class="btn btn-icon btn-secondary btn-table-sm"><em class="icon ni ni-file-text"></em></button></td>
                </tr>
            </tbody>
        </table>
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
                                        <button type="submit" class="btn btn-md" v-bind:class = "(bid !== null) ? 'btn-danger' : 'btn-primary'" style="">Cancel</button>
                                        <button type="submit" class="btn btn-md" v-bind:class = "(bid !== null) ? 'btn-danger' : 'btn-primary'" style="float: right;">Allocated</button>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->endSection() ?>