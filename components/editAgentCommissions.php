<?php

include_once '../models/User.php';
$user = new User();

$agents = $user->listAgents();
?>

<div>
    <h4 class="text-center">Agent Commission Percentages</h4>
</div>
<table class="table table-striped" id="tableCommissions">
    <thead class="bg-primary text-white">
        <tr>
            <th>Agent</th>
            <th>Commission</th>
            <th>Supervisor</th>
            <th>Commission</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($agents as $agent) {
            echo "<tr>
                        <td data-id='$agent[id]' title='" . $agent['firstName'] . " " . $agent['lastName'] . "'>$agent[firstName]</td>
                        <td class='d-flex align-items-center align-content-end'><input type='number' class='form-control-sm w-75 rounded' id='commission' min='5' max='40' step='5' value='$agent[agentCommission]'>%</td>
                        <td><select class='form-select' id='supervisor'>
                        <option value='0'>No Supervisor</option>";
            foreach ($agents as $supervisor) {
                $selected = $supervisor['id'] == $agent['idSupervisor'] ? 'selected' : '';
                echo "<option value='$supervisor[id]' $selected>$supervisor[firstName]</option>";
            }
            echo "</select></td>
                        <td class='d-flex align-items-end align-content-middle'><input type='number' class='form-control-sm w-75 rounded' id='supervisorComm' min='5' max='40' step='5' value='$agent[supervisorCommission]'>%</td>
                    </tr>";
        }
        ?>
    </tbody>
</table>
<div class="toast-container position-fixed top-0">
    <div id="liveToast" class="toast bg-danger rounded w-100" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true" data-delay="5000" data-animation="true">
        <div class="toast-header">
            <i class="bi-x-square"></i>
            <strong class="me-auto ms-3">Error</strong>
        </div>
        <div class="toast-body">
            Commission percentage must be between 5 and 40
        </div>
    </div>
</div>

<script>
    $('#btnSaveCommission').click(function() {
        $flag = true;
        $('#tableCommissions tbody tr').each(function() {
            var agentCommission = $(this).find('#commission').val();
            var supervisorCommission = $(this).find('#supervisorComm').val();
            if (agentCommission == '' || supervisorCommission == '') {
                $('#liveToast').toast('show');
                $flag = false;
                return false;
            }
            if (agentCommission < 0 || agentCommission > 40 || supervisorCommission < 0 || supervisorCommission > 40) {
                $('#liveToast').toast('show');
                $flag = false;
                return false;
            }
        });
        $('#tableCommissions tbody tr').each(function() {
            var agentId = $(this).find('td').attr('data-id');
            var agentCommission = $(this).find('#commission').val();
            var supervisorId = $(this).find('#supervisor').val();
            var supervisorCommission = $(this).find('#supervisorComm').val();
            $.ajax({
                url: '../controllers/Transaction.php',
                type: 'POST',
                data: {
                    action: 'saveCommission',
                    agentId: agentId,
                    agentCommission: agentCommission,
                    supervisorId: supervisorId,
                    supervisorCommission: supervisorCommission
                },
                success: function(response) {
                    response = JSON.parse(response);
                    console.log(response.message);
                    if (response.status == 'false') {
                        $flag = false;
                    }
                }
            });
        });
        if ($flag) {

            $('#infoModalTitle').text('Success');
            $('#infoModalText').html('Commissions updated successfully');
            $('#infoModalButtons').html('<button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>');
            $('#infoModal').modal('show');
            var checkedButtonId = $('input[name="quarters"]:checked').attr('id');
            loadPolicySummary(checkedButtonId);
            loadPolicyTable();
        } else {
            //alert('Error updating commissions');
        }
    });
</script>