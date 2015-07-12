<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Statistik Pendidikan Desa'
        },
        subtitle: {
            text: 'Berdasarkan Penerima Program Bantuan Siswa Miskin'
        },
        xAxis: {
            categories: [
                'Penerima Bantuan Siswa Miskin'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Siswa'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} Siswa</b></td></tr>',
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
					<?php echo $total_bsm ; ?>
				]

        },{
            name: 'Laki Laki',
            data: [
					<?php echo $jumlah_bsm_laki ; ?>
				]

        }, {
            name: 'Perempuan',
            data: [
					<?php echo $jumlah_bsm_perempuan ; ?>
				]

        } ]
		
    });
});
	
</script>

