<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/drilldown.js"></script>



<script>
    $(function () {
        // Create the chart
        $('#containerpiependapatan').highcharts({
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Anggaran Pendapatan Desa'
            },
            subtitle: {
                text: 'Anggaran Pendapatan dan belanja Desa Pemerintah Desa Tahun Anggaran 2015'
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },
            series: [{
                name: "Pendapatan",
                colorByPoint: true,
                data: [{
                    name: "Pendapatan Asli Desa",
                    y: 56.33,
                    drilldown: "Pendapatan Asli Desa"
                }, {
                    name: "Pendapatan Transfer",
                    y: 24.03,
                    drilldown: "Pendapatan Transfer"
                }, {
                    name: "Pendapatan Lain lain",
                    y: 10.38,
                    drilldown: "Pendapatan Lain lain"
                }]
            }],
            drilldown: {
                series: [{
                    name: "Pendapatan Asli Desa",
                    id: "Pendapatan Asli Desa",
                    data: [
                        ["Hasil Usaha", 10],
                        ["Swadaya, Partisipasi dan Gotong Royong", 17.2],
                        ["Lain2 Pendapatan Asli Desa yg Sah", 8.11]
                    ]
                }, {
                    name: "Pendapatan Transfer",
                    id: "Pendapatan Transfer",
                    data: [
                        ["Dana Desa", 5],
                        ["Bagian dari hasil pajak & retribusi kabupaten / Kota", 4.32],
                        ["Alokasi Dana Desa", 3.68],
                        ["Bantuan Keuangan", 2.96],
                        ["Bantuan Provinsi", 2.53],
                        ["Bantuan Kabupaten / Kota", 1.45]
                    ]
                }, {
                    name: "Pendapatan Lain lain",
                    id: "Pendapatan Lain lain",
                    data: [
                        ["Hibah & Sumbangan dari pihak ke 3 yg tidak mengikat", 2.76],
                        ["Lain2 pendapatan desa yang sah", 2.32]
                    ]
                }]
            }
        });
    });
</script>


<script>
    $(function () {
        // Create the chart
        $('#containerpiebelanja').highcharts({
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Anggaran Belanja Desa'
            },
            subtitle: {
                text: 'Anggaran Pendapatan dan belanja Desa Pemerintah Desa Tahun Anggaran 2015'
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },
            series: [{
                name: "Belanja",
                colorByPoint: true,
                data: [{
                    name: "Bidang Penyelenggaraan Pemerintahan Desa",
                    y: 56.33,
                    drilldown: "Bidang Penyelenggaraan Pemerintahan Desa"
                },
                    {
                        name: "Bidang Pelaksanaan Pembangunan Desa",
                        y: 56.33,
                        drilldown: "Bidang Pelaksanaan Pembangunan Desa"
                    }
                    ,
                    {
                        name: "Bidang Pembinaan Kemasyarakatan",
                        y: 56.33,
                        drilldown: "Bidang Pembinaan Kemasyarakatan"
                    }
                    ,
                    {
                        name: "Bidang Pemberdayaan Masyarakat",
                        y: 56.33,
                        drilldown: "Bidang Pemberdayaan Masyarakat"
                    }
                    ,
                    {
                        name: "Bidang Tak Terduga",
                        y: 56.33,
                        drilldown: "Bidang Tak Terduga"
                    }
                ]
            }],
            drilldown: {
                series: [{
                    name: "Bidang Penyelenggaraan Pemerintahan Desa",
                    id: "Bidang Penyelenggaraan Pemerintahan Desa",
                    data: [
                        ["Penghasilan Tetap dan Tunjangan", 24.13],
                        ["Operasional Perkantoran", 17.2],
                        ["Operasional BPD", 8.11],
                        ["Operasional RT / RW", 5.33]
                    ]
                }, {
                    name: "Bidang Pelaksanaan Pembangunan Desa",
                    id: "Bidang Pelaksanaan Pembangunan Desa",
                    data: [
                        ["Perbaikan Saluran Irigasi", 5],
                        ["Pengaspalan Jalan Desa", 4.32],
                        ["Kegiatan", 3.68]
                    ]
                }, {
                    name: "Bidang Pembinaan Kemasyarakatan",
                    id: "Bidang Pembinaan Kemasyarakatan",
                    data: [
                        ["Kegiatan Pembinaan Ketentraman dan Ketertiban", 5],
                        ["Kegiatan", 4.32]
                    ]
                }, {
                    name: "Bidang Pemberdayaan Masyarakat",
                    id: "Bidang Pemberdayaan Masyarakat",
                    data: [
                        ["Kegiatan Pelatihan Kepala Desa dan Perangkat", 5],
                        ["Kegiatan", 4.32]
                    ]
                }, {
                    name: "Bidang Tak Terduga",
                    id: "Bidang Tak Terduga",
                    data: [
                        ["Kegiatan Kejadian Luar Biasa", 5],
                        ["Kegiatan", 4.32]
                    ]
                }
                ]
            }
        });
    });
</script>

<script>
    $(function () {
        $('#containerstackpendapatan').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Pendapatan Desa 2015'
            },
            xAxis: {
                categories: ['Pendapatan Asli Desa', 'Pendapatan Transfer', 'Pendapatan Lain lain']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rupiah'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 25,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.x + '</b><br/>' +
                        this.series.name + ': ' + this.y + '<br/>' +
                        'Total: ' + this.point.stackTotal;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                        style: {
                            textShadow: '0 0 3px black'
                        }
                    }
                }
            },
            series: [{
                name: 'Belum Terealisasi',
                data: [25000, 80000, 20000]
            }, {
                name: 'Realisasi',
                data: [75000, 50000, 10000]
            }]
        });
    });
</script>

