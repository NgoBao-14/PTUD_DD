<?php
$dt = json_decode($data["DT"],true);
$pagination = $data["Pagination"];
$dem = $pagination->getOffset() + 1;
            echo '<h1>Danh Sách Đơn Thuốc</h1>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center;">STT</th>
                        <th style="text-align: center;">Mã đơn thuốc</th>
                        <th style="text-align: center;">Tên Bệnh Nhân</th>
                        <th style="text-align: center;">Ngày tạo</th>
                        <th style="text-align: center;">Trạng thái</th>
                        <th style="text-align: center;">Mô tả</th>
                        <th style="text-align: center;"></th>
                    </tr>
                </thead>
                <tbody>';
            foreach ($dt as $r):
            
                echo '<tr>
                    <td data-label="STT">'.$dem.'</td>
                    <td data-label="Order ID">'.$r["MaDT"].'</td>
                    <td data-label="Customer" style="text-align: left;">'.$r["HovaTen"].'</td>
                    <td data-label="Date">'.$r["NgayTao"].'</td>
                    <td data-label="Status"><span class="status status-completed">'.$r["TrangThai"].'</span>
                    <td data-label="MT" style="text-align: left;">'.$r["MoTa"].'</td>
                    <form action="NVNT/CTDT" method="POST">
                    <input type="hidden"  name="ctdt" value="'.$r["MaDT"].'">
                    </td>
                    <td><input type="submit" name="btnCTDT" value="Xem">
                    </form>
                    </td>
                    </tr>';
                $dem++;
            endforeach;
        echo '</tbody>
        </table>';

// Pagination links
if ($pagination instanceof Pagination) {
    echo '<div class="pagination" style=" display: flex; justify-content: center; text-align: center; padding: 10px 0; ">
            <div style="display: inline-block; background-color: #f0f0f0; padding: 10px; border-radius: 5px; ">';
    
    $baseUrl = '';

    // Previous page link
    if ($pagination->hasPreviousPage()) {
        echo '<form action="" method="POST" style="display: inline;">
                <input type="hidden" name="page" value="'.($pagination->getCurrentPage() - 1).'">
                <input type="submit" name="btnPage" value="<" style="margin: 0 5px; width: 60px; text-align: center;  border:none;">
            </form>';
    }

    // Page number links
    $totalPages = $pagination->getTotalPages();
    $currentPage = $pagination->getCurrentPage();
    $range = 2; // Number of pages to show before and after the current page

    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == 1 || $i == $totalPages || ($i >= $currentPage - $range && $i <= $currentPage + $range)) {
            if ($i == $currentPage) {
                echo '<span style="margin: 0 5px; font-weight: bold;">'.$i.'</span>';
            } else {
                echo '<form action="" method="POST" style="display: inline;">
                        <input type="hidden" name="page" value="'.$i.'" style="margin: 0 5px; width: 30px; text-align: center;">
                        <input type="submit" name="btnPage" value="'.$i.'" style="margin: 0 5px; width: 30px; text-align: center; border:none;">
                    </form>';
            }
        } elseif ($i == $currentPage - $range - 1 || $i == $currentPage + $range + 1) {
            echo '<span style="margin: 0 5px;">...</span>';
        }
    }

    // Next page link
    if ($pagination->hasNextPage()) {
        echo '      <form action="" method="POST" style="display: inline;">
                        <input type="hidden" name="page" value="'.($pagination->getCurrentPage() + 1).'">
                        <input type="submit" name="btnPage" value=">" style="margin: 0 5px; width: 60px; text-align: center;  border:none;">
                    </form>';
    }

    echo '</div></div>';
} else {
    echo '<p></p>';
}
?>
