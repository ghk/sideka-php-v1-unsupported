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
                data: <?php echo $json; ?>
                   /** [{
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
                **/
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
                data:  <?php echo $json2; ?>
                    /**[{
                    name: "Penyelenggaraan Pemerintahan Desa",
                    y: 56.33,
                    drilldown: "Bidang Penyelenggaraan Pemerintahan Desa"
                },
                    {
                        name: "Pelaksanaan Pembangunan Desa",
                        y: 56.33,
                        drilldown: "Bidang Pelaksanaan Pembangunan Desa"
                    }
                    ,
                    {
                        name: "Pembinaan Kemasyarakatan",
                        y: 56.33,
                        drilldown: "Bidang Pembinaan Kemasyarakatan"
                    }
                    ,
                    {
                        name: "Pemberdayaan Masyarakat",
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
                     **/
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
                data: <?php echo $jsonstackbelumrealisasi; ?>
            }, {
                name: 'Realisasi',
                data: <?php echo $jsonstackrealisasi; ?>
            }]
        });
    });
</script>

<script>
    $(function () {
        $('#containerstackbelanja').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Belanja Desa 2015'
            },
            xAxis: {
                categories: ['Bidang Penyelenggaraan Pemerintahan     Desa', 'Bidang Pelaksanaan Pembangunan Desa', 'Bidang Pembinaan Kemasyarakatan', 'Bidang Pemberdayaan Masyarakat', 'Bidang Tak Terduga']
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
                data: <?php echo $jsonstackbelanjabelumrealisasi; ?>
            }, {
                name: 'Realisasi',
                data: <?php echo $jsonstackbelanjarealisasi; ?>
            }]
        });
    });
</script>

<script>
    $(function () {
        $('#containerbasicpendapatan').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Pendapatan Desa Per Bulan'
            },
            subtitle: {
                text: 'Pendapatan'
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah dalam Rupiah (Rp)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Pendapatan Asli Desa',
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

            }, {
                name: 'Pendapatan Transfer',
                data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

            }, {
                name: 'Pendapatan Lain lain',
                data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

            }]
        });
    });
</script>
<script>
    $(function () {
        $('#containerbasicbelanja').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Belanja Desa Per Bulan'
            },
            subtitle: {
                text: 'Belanja'
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah dalam Rupiah (Rp)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Bidang Penyelenggaraan Pemerintahan Desa',
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

            }, {
                name: 'Bidang Pelaksanaan Pembangunan Desa',
                data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

            }, {
                name: 'Bidang Pembinaan Kemasyarakatan',
                data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

            }, {
                name: 'Bidang Pemberdayaan Masyarakat',
                data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

            }, {
                name: 'Bidang Tak Terduga',
                data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

            }]
        });
    });
</script>
