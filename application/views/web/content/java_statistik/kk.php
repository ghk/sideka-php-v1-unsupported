<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Statistik Keluarga Desa'
        },
        subtitle: {
            text: 'Berdasarkan Jenis Kelamin Kepala Keluarga'
        },
        xAxis: {
            categories: [
                'Kepala Keluarga Perempuan',
                'Kepala Keluarga Laki Laki'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Kepala Keluarga'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} KK</b></td></tr>',
            footerFormat: '</table>',
            shared: false,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Jumlah Kepala Keluarga Perempuan',
            data: [
					<?php echo $jumlah_kk_perempuan ; ?>
				]

        }, {
            name: 'Jumlah Kepala Keluarga Laki Laki',
            data: [
					<?php echo $jumlah_kk_laki ; ?>
				]

        } ]
		
    });
});
	
</script>

