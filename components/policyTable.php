<?Php
include "../models/User.php";
include "../models/Transaction.php";

$mes = $_POST['mes'] ?? 'all';
$agente = $_POST['agente'] ?? 'all';
$tipo = $_POST['tipo'] ?? 'all';
$keyword = $_POST['keyword'] ?? null;
$page = $_POST['page'] ?? 1;
$data = getTransactions($mes, $agente, $tipo, $keyword, $page);
?>

<div class="mx-auto px-2">
    <table class="table table-responsive-sm text-center" id="tblTransactions">
        <thead>
            <td>Date</td>
            <td>Insured</td>
            <td>Carrier</td>
            <td>Policy No.</td>
            <td class="text-end">Transaction</td>
            <td class="text-end">Premium</td>
            <td class="text-end">Commission</td>
            <?php if (hasPermission('listarPolizas')) { ?>
                <td>Agent</td>
            <?php } ?>
            <td>Actions</td>
        </thead>
        <tbody class="table-group-divider">
            <?php
            foreach ($data['data'] as $row) {
                $date = date_create($row['date']);
                $date = date_format($date, 'M d');
                $type = $row['type'];
                $premium = number_format($row['premium'], 2);
                $commission = number_format(($row['premium'] * 0.04),2);
                $insured = $row['insured'];
                $carrier = $row['carrier'];
                $policyNumber = $row['policyNumber'];
                $agent = $row['agent'];
                $employee = getAgent($agent);
                $agent = $employee['firstName'] . ' ' . $employee['lastName'];
                $id = $row['id'];
                $class = '';
                if ($type == 'NEW BUSINESS' || $type == 'RENEWAL' || $type == 'REINSTATEMENT' || $type == 'ADDITIONAL PREMIUM') {
                    $class = 'text-success fw-bold';
                } else {
                    $class = 'text-danger fw-bold';
                }
                echo "<tr data-id=$id>
                        <td>$date</td>
                        <td>$insured</td>
                        <td>$carrier</td>
                        <td>$policyNumber</td>
                        <td class='text-end'>$type</td>
                        <td class='text-end $class'>$$premium</td>
                        <td class='text-end $class'>$$commission</td>";
                if (hasPermission('listarPolizas')) {
                    echo "<td>$agent</td>";
                }
                echo "<td><span class='fa-solid fa-pencil fa-lg text-warning'></span><span class='clickable text-danger ms-2 fa-solid fa-trash-can fa-lg'></span></button></td>
                    </tr>";
            }
            ?>
        </tbody>
        <tfoot class="table-group-divider">
            <td class="fw-bold align-bottom">TOTAL</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-end align-bottom"><?= $data['stats']['totalRows'] ?></td>
            <td class="text-end text-success fw-bold align-bottom <?php echo ($data['stats']['totalPremium'] < 0) ? 'text-danger' : 'text-success' ?>">$<?= number_format($data['stats']['totalPremium'],2) ?></td>
            <td class="text-end text-success fw-bold align-bottom <?php echo ($data['stats']['totalPremium'] < 0) ? 'text-danger' : 'text-success' ?>">$<?= number_format($data['stats']['totalPremium']*0.04,2) ?></td>
            <td colspan="2"><button class="btn btn-success ms-2" id="btnExport">Export to Excel</button></td>
        </tfoot>
        <nav aria-label="Policy Pagination text-end">
            <ul class="pagination text-primary">
                <li class="page-item">
                    <a class="page-link text-primary firstPage" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item"><a id="firstPage" class="page-link <?php echo $page == 1 ? 'bg-primary text-white' : 'text-primary' ?> pageNumber" href="#"><?php echo $page == 1 ? '1' : ($page - 1) ?></a></li>
                <li class="page-item"><a id="middlePage" class="page-link pageNumber <?php echo $page != 1 ? 'bg-primary text-white' : 'text-primary' ?>" href="#"><?php echo $page == 1 ? '2' : ($page) ?></a></li>
                <li class="page-item"><a id="lastPage" class="page-link pageNumber text-primary" href="#"><?php echo $page == 1 ? '3' : ($page + 1) ?></a></li>
                <li class="page-item">
                    <a class="page-link text-primary lastPage" href="#" aria-label="Next" data-page=<?php echo number_format(($data['stats']['totalRows'] / 10), 0) ?>>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </table>
</div>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="https://unpkg.com/file-saver/dist/FileSaver.min.js"></script>
<script type="text/javascript" src="../js/policyTable.js"></script>