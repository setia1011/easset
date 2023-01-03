<?php $this->extend('templates/main'); ?>

<?php $this->section('contents') ?>

<link rel="stylesheet" href="<?php echo base_url('assets/plugins/vue-select/vue-select.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/vue2-datepicker/index.css'); ?>">

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

<div id="v-alokasi">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <?php if ($_SESSION['level'] == 'admin') { ?>
                <h3 class="nk-block-title page-title">Laporan</h3>
                <?php } else { ?>
                <h3 class="nk-block-title page-title">Laporan</h3>
                <?php } ?>
                <div class="nk-block-des text-soft">
                    <p>Laporan aset</p>
                </div>
            </div>
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="row">
            <div class="col-md-4">
                <input type="hidden" ref="userlev" value="<?= $_SESSION['level']; ?>">
                <div class="form-control-wrap mb-1">
                    <date-picker style="width: 248px;" v-model="tstart" lang="en" type="date" format="DD-MM-YYYY" placeholder="Start"></date-picker>
                </div>
                <div class="form-control-wrap mb-2">
                    <date-picker style="width: 248px;" v-model="tend" lang="en" type="date" format="DD-MM-YYYY" placeholder="End"></date-picker>
                </div>
                <div class="form-group mb-1">
                    <div class="form-control-wrap">
                        <select class="form-select" v-model="opt_status">
                            <option value="all">All</option>
                            <option value="book">Book</option>
                            <option value="allocated">Allocated</option>
                            <option value="return">Return</option>
                            <option value="returned">Returned</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="form-control-wrap mb-2">
                    <div class="input-group">
                        <input type="text" v-model="search" class="form-control" placeholder="Search by aset">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary btn-dim"><em class="icon ni ni-search"></em></button>
                        </div>
                    </div>
                </div>
                <input type="hidden" ref="baseurl" value="<?= base_url() ?>">
                <button v-on:click="exportToCsv($event)" class="btn btn-dim btn-outline-secondary"><em class="icon ni ni-download"></em><span>Export to CSV</span></button>
            </div>

            <div class="col-md-8">
                <div class="card card-bordered mb-4">
                <table class="table">
                    <thead style="height: 40px; vertical-align: middle;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Aset</th>
                            <th scope="col">Book/Stok</th>
                            <th scope="col">Book Date</th>
                            <th scope="col">User</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="vertical-align: middle;" v-for="(item, index) in items">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ item.nama }}</td>
                            <td><span class="fw-bold text-dark">{{ item.book_qty }}</span>/{{ item.jumlah }} {{ item.satuan }}</td>
                            <td>{{ item.booked_atx }}</td>
                            <td>{{ item.book_user }}</td>
                            <td>
                                <span 
                                    class="text-bold" 
                                    v-bind:class="{'text-warning': item.book_status == 'book', 'text-dark': item.book_status == 'allocated', 'text-danger': item.book_status == 'rejected'}">{{ item.book_status}}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
        </div>        
    </div><!-- .nk-block -->
</div>

<?php $this->endSection() ?>