<?Php
include $_SERVER['DOCUMENT_ROOT'] . "/models/User.php";
include $_SERVER['DOCUMENT_ROOT'] . "/models/Transaction.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/Login.php";

$year = $_POST['year'] ?? date('Y');
$mes = $_POST['mes'] ?? 'all';
$agente = $_POST['agente'] ?? getUser();
$tipo = $_POST['tipo'] ?? 'all';
$keyword = $_POST['keyword'] ?? null;
$page = $_POST['page'] ?? 1;
$data = getTransactions($year, $mes, $agente, $tipo, $keyword, $page);
$user = new User();
$agentCommissions = $user->listAgents();
?>

<div class="pe-2 mt-4">
    <table class="table text-center capitalize w-full" id="tblTransactions">
        <thead class="bg-sky-950 text-white font-bold">
            <tr>
                <td class="rounded-s p-2">Date</td>
                <td>Insured</td>
                <td>Carrier</td>
                <td>Policy No.</td>
                <td class="text-end">Transaction</td>
                <td class="text-end">Premium</td>
                <td class="text-end">Agency Comm</td>
                <td class="text-end">Agent Comm</td>
                <?php if ($user->hasPermission('listarPolizas')) { ?>
                    <td>Agent</td>
                <?php } ?>
                <td class="rounded-e">Actions</td>
            </tr>
        </thead>
        <tbody class="">
            <?php
            foreach ($data['data'] as $row) {
                $date = date_create($row['date']);
                $date = date_format($date, 'm-d-y');
                $type = $row['type'];
                $premium = number_format($row['premium'], 2);
                $rawAgentCommission = $row['premium'] * $row['commission'] / 100;
                $agencycommission = number_format(($row['premium'] * $row['commission'] / 100), 2);
                $idToFind = $row['agent'];
                $result = array_filter($agentCommissions, function ($item) use ($idToFind) {
                    return $item['id'] == $idToFind;
                });
                $firstMatch = reset($result);
                $agentPercentage = $firstMatch['agentCommission'] / 100;
                $agentcommission = number_format(($rawAgentCommission * $agentPercentage), 2);
                $insured = $row['insured'];
                $carrier = $row['carrier'];
                $policyNumber = $row['policyNumber'];
                $agent = $row['agent'];
                $employee = $user->getAgent($agent);
                $agent = $employee['firstName'];
                $id = $row['id'];
                $class = '';
                if ($premium >= 0) {
                    $class = 'text-green-500 fw-bold';
                } else {
                    $class = 'text-red-500 fw-bold';
                }
                echo "<tr class='border-b border-b-gray-700' data-id=$id>
                        <td class='p-2'>$date</td>
                        <td>$insured</td>
                        <td>$carrier</td>
                        <td>$policyNumber</td>
                        <td class='text-end'>$type</td>
                        <td class='text-end $class'>" . str_replace('-', '', $premium) . "</td>
                        <td class='text-end $class'>" . str_replace('-', '', $agencycommission) . "</td>
                        <td class='text-end $class'>" . str_replace('-', '', $agentcommission) . "</td>";
                if ($user->hasPermission('listarPolizas')) {
                    echo "<td>$agent</td>";
                }
                echo "<td><span class='fa-solid fa-pencil fa-lg text-yellow-500'></span><span class='clickable text-red-500 ms-2 fa-solid fa-trash-can fa-lg'></span></button></td>
                    </tr>";
            }
            ?>
        </tbody>
        <tfoot class="border-t-2 border-sky-950 font-bold align-bottom">
            <td class="">TOTAL</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-end align-bottom"><?= $data['stats']['totalRows'] ?></td>
            <td class="text-end text-success fw-bold align-bottom <?php echo ($data['stats']['totalPremium'] < 0) ? 'text-red-500' : 'text-green-500' ?>">$<?= str_replace('-', '', number_format($data['stats']['totalPremium'], 2)) ?></td>
            <td class="text-end text-success fw-bold align-bottom <?php echo ($data['stats']['totalPremium'] < 0) ? 'text-red-500' : 'text-green-500' ?>">$<?= str_replace('-', '', number_format($data['stats']['agencyCommission'], 2)) ?></td>
            <td class="text-end text-success fw-bold align-bottom <?php echo ($data['stats']['totalPremium'] < 0) ? 'text-red-500' : 'text-green-500' ?>">$<?= str_replace('-', '', number_format($data['stats']['agentCommission'], 2)) ?></td>
            <td colspan="2" class="flex-wrap content-end text-end"><button class="btn-success" id="btnExport">Export to Excel</button></td>
        </tfoot>
        <nav aria-label="Policy Pagination" class="text-end">
            <ul class="pagination text-sky-950 flex flex-row border-gray-700">
                <li class="page-item rounded-s">
                    <a class="page-link firstPage" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item <?php echo $page == 1 ? 'bg-sky-950 text-white' : 'text-primary' ?>"><a id="firstPage" class="page-link pageNumber" href="#"><?php echo $page == 1 ? '1' : ($page - 1) ?></a></li>
                <li class="page-item <?php echo $page != 1 ? 'bg-sky-950 text-white' : 'text-primary' ?>"><a id="middlePage" class="page-link pageNumber" href="#"><?php echo $page == 1 ? '2' : ($page) ?></a></li>
                <li class="page-item"><a id="lastPage" class="page-link pageNumber text-primary" href="#"><?php echo $page == 1 ? '3' : ($page + 1) ?></a></li>
                <li class="page-item rounded-e">
                    <a class="page-link text-primary lastPage" href="#" aria-label="Next" data-page=<?php echo number_format($data['stats']['totalRows'] % 10 == 0 ? ($data['stats']['totalRows'] / 10) : ($data['stats']['totalRows'] / 10) + 1, 0) ?>>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </table>
</div>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="https://unpkg.com/file-saver/dist/FileSaver.min.js"></script>

<script>
    $(document)
        .off()
        .on('click', '.pageNumber', function() {
            modalShow('spinner');
            $('#policyTable').load(
                '../components/policyTable.php', {
                    page: $(this).html(),
                    year: $('#yearSelect').val(),
                    mes: $('#mesSelect').val(),
                    agente: $('#agenteSelect').val(),
                    tipo: $('#typeSelect').val(),
                    keyword: $('#searchText').val(),
                },
                function() {
                    modalHide('spinner');
                }
            );
        });

    $(document).on('click', '.firstPage', function() {
        modalShow('spinner');
        $('#policyTable').load(
            '../components/policyTable.php', {
                page: 1,
                year: $('#yearSelect').val(),
                mes: $('#mesSelect').val(),
                agente: $('#agenteSelect').val(),
                tipo: $('#typeSelect').val(),
                keyword: $('#searchText').val(),
            },
            function() {
                modalHide('spinner');
            }
        );
    });

    $(document).on('click', '.lastPage', function() {
        modalShow('spinner');
        $('#policyTable').load(
            '../components/policyTable.php', {
                year: $('#yearSelect').val(),
                page: $(this).data('page'),
                mes: $('#mesSelect').val(),
                agente: $('#agenteSelect').val(),
                tipo: $('#typeSelect').val(),
                keyword: $('#searchText').val(),
            },
            function() {
                modalHide('spinner');
            }
        );
    });

    $(document).on('click', 'tbody tr', function() {
        $(this).addClass('bg-blue-300 selected').siblings().removeClass('bg-blue-300 selected');
    });

    $(document).on('click', 'td .fa-pencil', function() {
        modalShow('spinner');
        $id = $(this).closest('tr').data('id');
        $('#infoModalTitle').parent().removeClass();
        $('#infoModalTitle').parent().addClass('modalTitle bg-yellow-500');
        $('#infoModalTitle').text('Edit Policy');
        $modalContent = "<div id='editPolicy'></div>";
        $('#infoModalText').html($modalContent);
        $('#editPolicy').load('../components/newTransaction.php', {
            id: $(this).closest('tr').data('id')
        });
        $modalContent =
            '<div class="flex gap-1 justify-end"><div id="cancelButtonDiv"></div><div id="saveButtonDiv"></div></div>';
        $('#infoModalButtons').html($modalContent);
        $('#cancelButtonDiv').load('../components/buttons/cancelButton.php');
        $('#saveButtonDiv').load('../components/buttons/saveButton.php');
        modalShow('infoModal');
    });

    $(document).on('click', 'td .fa-trash-can', function() {
        $id = $(this).closest('tr').data('id');
        $('#infoModalTitle').text('Delete Policy');
        $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-red-800');
        $('#infoModalText').html('Are you sure you want to delete this policy?');
        $modalContent =
            '<div class="flex gap-1"><div id="noButton"></div><div id="btnDeletePolicy" data-id=' + $id + ' ></div></div>';
        $('#infoModalButtons').html($modalContent);
        $('#noButton').load('../components/buttons/noButton.php');
        $('#btnDeletePolicy').load('../components/buttons/yesButton.php');
        modalShow('infoModal');
    });

    $(document).on('click', '#btnDeletePolicy', function() {
        $.post('../controllers/Transaction.php', {
            action: 'deleteTransaction',
            id: $(this).data('id'),
        }).done(function(resp) {
            resp = JSON.parse(resp);
            if (resp.status == 'true') {
                // success
                modalHide('infoModal');
                $('#infoModalTitle').text('Success');
                $('#infoModalText').html(resp.message);
                $('#infoModalButtons').html(
                    '<div id="okButton"></div>'
                );
                $('#okButton').load('../components/buttons/okButton.php');
                modalShow('infoModal');
                loadPolicySummary();
                loadPolicyTable();
            } else {
                modalHide('infoModal');
                $('#infoModalTitle').text('Error');
                $('#infoModalText').html(resp.message);
                $('#infoModalButtons').html(
                    '<div id="okButton"></div>'
                );
                $('#okButton').load('../components/buttons/okButton.php');
                modalShow('infoModal');
            }
        });
    });

    $(document).on('click', '#btnExport', function() {
        modalShow('spinner');
        $.post('../controllers/Transaction.php', {
            action: 'exportTransactions',
            mes: $('#mesSelect').val(),
            agente: $('#agenteSelect').val(),
            tipo: $('#typeSelect').val(),
            keyword: $('#searchText').val(),
        }).done(function(resp) {
            resp = JSON.parse(resp);
            if (resp.status == 'true') {
                // success
                var data = $.map(resp.data, function(value, index) {
                    return [Object.values(value)];
                });
                var ws = XLSX.utils.aoa_to_sheet(data);
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Sheet 1");

                var wbout = XLSX.write(wb, {
                    bookType: 'xlsx',
                    type: 'binary'
                });

                function s2ab(s) {
                    var buf = new ArrayBuffer(s.length);
                    var view = new Uint8Array(buf);
                    for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                    return buf;
                }
                saveAs(new Blob([s2ab(wbout)], {
                    type: "application/octet-stream"
                }), 'Transactions.xlsx');
                modalHide('spinner');
                $('#infoModalTitle').text('Success');
                $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-green-800');
                $('#infoModalText').html('Transactions exported successfully');
                $('#infoModalButtons').html(
                    '<div id="okButton"></div>'
                );
                $('#okButton').load('../components/buttons/okButton.php');
                modalShow('infoModal');
            } else {
                modalHide('spinner');
                $('#infoModalTitle').text('Error');
                $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-red-800');
                $('#infoModalText').html(resp.message);
                $('#infoModalButtons').html(
                    '<div id="okButton"></div>'
                );
                $('#okButton').load('../components/buttons/okButton.php');
                modalShow('infoModal');
            }
        });
    });
</script>