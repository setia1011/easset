Vue.component("v-chart", VueECharts);
var application = new Vue({
    el: '#vhome',
    created() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
    data: {
        aset_status: {},
        aset_kondisi: {},
        book_stats: {},
        books_status: {}
    },
    watch: {
    },
    computed: {
    },
    mounted() {
        this.statsAsetStatus();
        this.statsAsetKondisi();
        this.statsBooks();
        this.statsBooksStatus();
    },
    methods: {
        statsAsetStatus: function() {
            axios.post('../app/stats-aset', JSON.stringify({
                ref: 'aset-status'
            })).then(res => {
                this.aset_status = {
                    toolbox: {
                        feature: {
                            saveAsImage: {
                                pixelRatio: 2
                            }
                        }
                    },
                    xAxis: {
                        type: 'category',
                        data: res.data.status
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            data: res.data.jumlah,
                            type: 'bar',
                            showBackground: true,
                            backgroundStyle: {
                                color: 'rgba(180, 180, 180, 0.2)'
                            },
                            label: {
                                show: true,
                                position: 'top',
                                valueAnimation: true
                            }
                        }
                    ]
                };
            }).catch(err => {
                console.log(err);
            });
        },
        statsAsetKondisi: function() {
            axios.post('../app/stats-aset', JSON.stringify({
                ref: 'aset-kondisi'
            })).then(res => {
                this.aset_kondisi = {
                    toolbox: {
                        show: true,
                        feature: {
                            saveAsImage: { show: true }
                        }
                    },
                    tooltip: {
                        trigger: 'item',
                        formatter: '{a} <br/>{b} : {c} ({d}%)'
                    },
                    series: [
                    {
                        name: 'Kondisi',
                        type: 'pie',
                        radius: [20, 160],
                        center: ['50%', '50%'],
                        roseType: 'area',
                        itemStyle: {
                            borderRadius: 8
                        },
                        data: res.data
                    }
                    ]
                };
            }).catch(err => {
                console.log(err);
            });
        },
        statsBooks: function() {
            axios.post('../app/stats-aset', JSON.stringify({
                ref: 'book-stats'
            })).then(res => {
                this.book_stats = {
                    toolbox: {
                        feature: {
                            saveAsImage: {
                                pixelRatio: 2
                            }
                        }
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    xAxis: {
                        type: 'category',
                        data: res.data.periode
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            data: res.data.jumlah,
                            type: 'line',
                            smooth: true,
                            showBackground: true,
                            backgroundStyle: {
                                color: 'rgba(180, 180, 180, 0.2)'
                            },
                            label: {
                                show: false,
                                position: 'top',
                                valueAnimation: true
                            }
                        }
                    ]
                };
            }).catch(err => {
                console.log(err);
            });
        },
        statsBooksStatus: function() {
            axios.post('../app/stats-aset', JSON.stringify({
                ref: 'books-status'
            })).then(res => {
                this.books_status = {
                    toolbox: {
                        feature: {
                            saveAsImage: {
                                pixelRatio: 2
                            }
                        }
                    },
                    xAxis: {
                        type: 'category',
                        data: res.data.status
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            data: res.data.jumlah,
                            type: 'bar',
                            showBackground: true,
                            backgroundStyle: {
                                color: 'rgba(180, 180, 180, 0.2)'
                            },
                            label: {
                                show: true,
                                position: 'top',
                                valueAnimation: true
                            }
                        }
                    ]
                };
            }).catch(err => {
                console.log(err);
            });
        }
    }
});