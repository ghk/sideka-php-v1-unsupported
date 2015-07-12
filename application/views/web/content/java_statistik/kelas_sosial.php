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
            text: 'Berdasarkan Kelas Sosial'
        },
        xAxis: {
            categories: [
                'Kelas Sosial'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
			allowDecimals: false,
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
            name: 'Sangat Miskin',
			color:'#CA0300',
            data: [
					<?php echo $jumlah_sangat_miskin ; ?>
				]

        },{
            name: 'Miskin',
			color:'#EA7201',
            data: [
					<?php echo $jumlah_miskin ; ?>
				]

        }, {
            name: 'Sedang',
			color:'#F4F013',
            data: [
					<?php echo $jumlah_sedang ; ?>
				]

        }, {
            name: 'Kaya',
			color:'green',
            data: [
					<?php echo $jumlah_kaya ; ?>
				]

        } ]
		
    });
});
	
</script>

