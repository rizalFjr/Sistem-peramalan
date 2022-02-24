$(function () {
    //Initialize Select2 Elements
    $("#barang_id").select2({
        theme: "bootstrap4",
        placeholder: "Pilih Barang",
    });

    $("#alpha").select2({
        theme: "bootstrap4",
        placeholder: "Pilih Alpha",
    });

    $("#bulan_awal").select2({
        theme: "bootstrap4",
        placeholder: "Pilih Bulan Awal",
    });

    $("#bulan_akhir").select2({
        theme: "bootstrap4",
        placeholder: "Pilih Bulan Akhir",
    });

    $("#tahun_awal").select2({
        theme: "bootstrap4",
        placeholder: "Pilih Tahun Awal",
    });

    $("#tahun_akhir").select2({
        theme: "bootstrap4",
        placeholder: "Pilih Tahun Akhir",
    });
    $("#table-ramal").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        paging: false,
        ordering: true,
        // buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
    });
    // .buttons()
    // .container()
    // .appendTo("#table-ramal_wrapper .col-md-6:eq(0)");

    var areaChartData = {
        labels: periode,
        datasets: [
            {
                label: "Data Aktual",
                backgroundColor: "rgba(60,141,188,0.9)",
                borderColor: "rgba(60,141,188,0.8)",
                pointRadius: true,
                pointColor: "#3b8bba",
                pointStrokeColor: "rgba(60,141,188,1)",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(60,141,188,1)",
                data: dataAktual,
            },
            {
                label: "Data Peramalan",
                backgroundColor: "rgba(210, 214, 222, 1)",
                borderColor: "rgba(210, 214, 222, 1)",
                pointRadius: true,
                pointColor: "rgba(210, 214, 222, 1)",
                pointStrokeColor: "#c1c7d1",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: dataRamal,
            },
        ],
    };

    var chartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: true,
        },
        scales: {
            xAxes: [
                {
                    gridLines: {
                        display: false,
                    },
                },
            ],
            yAxes: [
                {
                    gridLines: {
                        display: true,
                    },
                },
            ],
        },
    };

    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChartOptions = $.extend(true, {}, chartOptions);
    var lineChartData = $.extend(true, {}, areaChartData);
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false;

    var lineChart = new Chart(lineChartCanvas, {
        type: "line",
        data: lineChartData,
        options: lineChartOptions,
    });
});
