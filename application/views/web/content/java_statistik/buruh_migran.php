<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Statistik Pekerjaan Desa'
        },
        subtitle: {
            text: 'Berdasarkan Jenis Pekerjaan Buruh Migran'
        },
        xAxis: {
            categories: [
                'Buruh Migran'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Pekerja'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} Pekerja</b></td></tr>',
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
            name: 'Perempuan dan Laki Laki',
            data: [
					<?php echo $total_buruh_migran ; ?>
				]

        },{
            name: 'Laki Laki',
            data: [
					<?php echo $jumlah_buruh_migran_laki ; ?>
				]

        }, {
            name: 'Perempuan',
            data: [
					<?php echo $jumlah_buruh_migran_perempuan ; ?>
				]

        } ]
		
    });
});
	
</script>

