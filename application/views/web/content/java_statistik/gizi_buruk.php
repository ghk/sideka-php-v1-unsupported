<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Statistik Anak Desa'
        },
        subtitle: {
            text: 'Berdasarkan Gizi Buruk'
        },
        xAxis: {
            categories: [				
                'Anak Gizi Buruk 0-4 Tahun',
                'Anak Gizi Buruk 5-9 Tahun'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Anak'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} Anak</b></td></tr>',
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
        series: [ {
            name: 'Laki Laki & Perempuan',
            data: [
					<?php echo $jumlah_gizi_buruk_0_4 ; ?>,
					<?php echo $jumlah_gizi_buruk_5_9 ; ?>
				]

        },{
            name: 'Laki Laki',
            data: [
					<?php echo $jumlah_gizi_buruk_laki_0_4 ; ?>,
					<?php echo $jumlah_gizi_buruk_laki_5_9 ; ?>
				]

        }, {
            name: 'Perempuan',
            data: [
					<?php echo $jumlah_gizi_buruk_perempuan_0_4 ; ?>,
					<?php echo $jumlah_gizi_buruk_perempuan_5_9 ; ?>
				]

        } ]
		
    });
});
	
</script>

