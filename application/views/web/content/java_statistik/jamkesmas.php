<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column',
			margin: 75,
            options3d: {
                enabled: true,
                alpha: 2,
                beta: 2,
                depth: 0
            }
        },
        title: {
            text: 'Statistik Keluarga Desa'
        },
        subtitle: {
            text: 'Berdasarkan Bantuan JamKesMas'
        },
        xAxis: {
            categories: [
                'Sangat Miskin',
                'Miskin',
                'Sedang',
                'Kaya'
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
            name: 'Menerima JamKesMas',
			color:'#060606',			
            data: [
					{y:<?php echo $menerimaSangatMiskin ; ?>,color:'#CA0300'},
					{y:<?php echo $menerimaMiskin ; ?>,color:'#EA7201' },
					{y:<?php echo $menerimaSedang ; ?>,color:'#F4F013' },
					{y:<?php echo $menerimaKaya ; ?>,color:'#008000' }
				]

        }, {
            name: 'Jumlah Kepala Keluarga',
			color:'#888888',
            data: [
					{y:<?php echo $totalSangatMiskin ; ?>,color:'#C93836' },
					{y:<?php echo $totalMiskin ; ?>,color:'#ED994A' },
					{y:<?php echo $totalSedang ; ?>,color:'#F6F46F' },
					{y:<?php echo $totalKaya ; ?>,color:'#4AA94A' }
				]

        } ]
		
    });
});
	
</script>

