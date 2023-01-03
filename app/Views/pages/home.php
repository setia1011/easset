<?php $this->extend('templates/main'); ?>

<?php $this->section('contents') ?>

<style>
    .echart {
        padding-top: 6px;
        border-radius: 5px;
        margin-top: 20px;
    }
    .chart-status {
        width: 100% !important;
        height: 400px !important;
        border: 1px solid #607d8b6b;
    }
    .chart-kondisi {
        width: 100% !important;
        height: 400px !important;
        border: 1px solid #607d8b6b;
    }
</style>

<div id="vhome">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title"><em class="icon ni ni-bar-c"></em></h3>
            </div>
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block mt-2">
        <div class="row g-gs">
            <div class="col-md-6">
                <h4 class="title nk-block-title">Aset (status)</h4>
                <div class="nk-block-des text-soft"><p>Statistik berdasarkan status aset</p></div>
                <v-chart class="echart chart-status" autoresize :option="aset_status"/>
            </div>
            <div class="col-md-6">
                <h4 class="title nk-block-title">Aset (kondisi)</h4>
                <div class="nk-block-des text-soft"><p>Statistik berdasarkan kondisi aset</p></div>
                <v-chart class="echart chart-kondisi" autoresize :option="aset_kondisi"/>
            </div>
            <div class="col-md-6">
                <h4 class="title nk-block-title">Book (bulanan)</h4>
                <div class="nk-block-des text-soft"><p>Statistik berdasarkan periode bulanan booking</p></div>
                <v-chart class="echart chart-status" autoresize :option="book_stats"/>
            </div>
            <div class="col-md-6 mt-4">
                <h4 class="title nk-block-title">Books (status)</h4>
                <div class="nk-block-des text-soft"><p>Statistik berdasarkan status booking</p></div>
                <v-chart class="echart chart-status" autoresize :option="books_status"/>
            </div>
        </div>
    </div><!-- .nk-block -->
</div>


<?php $this->endSection() ?>