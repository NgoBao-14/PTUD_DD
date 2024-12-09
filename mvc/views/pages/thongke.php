<?php
$thongKe = json_decode($data["ThongKe"], true);

// Khởi tạo mảng dữ liệu cho các loại dịch vụ
$dataPoints1 = array(); // Khám bệnh
$dataPoints2 = array(); // Xét nghiệm

// Mảng theo dõi doanh thu cho từng tháng
$monthlyData = [];

// Lặp qua dữ liệu thống kê và phân loại theo tháng và dịch vụ
foreach ($thongKe as $row) {
    $thang = $row['Thang'];
    $tongTien = $row['TongTienTheoThang'] / 1000000; // Chuyển đổi tiền tệ sang triệu VND

    // Tạo mảng doanh thu theo tháng và dịch vụ
    $monthlyData[$thang][$row['DichVu']] = $tongTien;
}

// Lấy tất cả các tháng và sắp xếp theo thứ tự từ 1 đến 12
$months = range(1, 12);

// Điền dữ liệu vào mảng nếu thiếu
foreach ($months as $thang) {
    $dataPoints1[] = array("label" => "$thang", "y" => isset($monthlyData[$thang]['Khám bệnh']) ? $monthlyData[$thang]['Khám bệnh'] : 0);
    $dataPoints2[] = array("label" => "$thang", "y" => isset($monthlyData[$thang]['Xét nghiệm']) ? $monthlyData[$thang]['Xét nghiệm'] : 0);
}
?>
<script>
window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title:{
            text: "Doanh thu giữa các dịch vụ theo tháng"
        },
        axisY:{
            includeZero: true,
            title: "Doanh thu (Triệu VND)"
        },
        legend:{
            cursor: "pointer",
            verticalAlign: "center",
            horizontalAlign: "right",
            itemclick: toggleDataSeries
        },
        data: [{
            type: "column",
            name: "Khám bệnh",
            indexLabel: "{y}Tr",
            yValueFormatString: "#0.##",
            showInLegend: true,
            dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
        },{
            type: "column",
            name: "Xét nghiệm",
            indexLabel: "{y}Tr",
            yValueFormatString: "#0.##",
            showInLegend: true,
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();

    function toggleDataSeries(e){
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        }
        else{
            e.dataSeries.visible = true;
        }
        chart.render();
    }
}
</script>
<div id="chartContainer" style="height: 400px; width: 100%;"></div> 
