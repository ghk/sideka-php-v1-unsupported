<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Statistik Ibu Desa'
        },
        subtitle: {
            text: 'Berdasarkan Kondisi Kehamilan'
        },
        xAxis: {
            categories: [				
                'Kondisi Ibu Hamil'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Ibu'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} Ibu</b></td></tr>',
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
        series: [ {
            name: 'Total Ibu Hamil',
            data: [
					<?php echo $total_kehamilan ; ?>
				]

        },{
            name: 'Normal',
            data: [
					<?php echo $total_kehamilan_normal ; ?>
				]

        }, {
            name: 'Resiko Tinggi',
            data: [
					<?php echo $total_kehamilan_resti ; ?>
				]

        } ]
		
    });
});
	
</script>

