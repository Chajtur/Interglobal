<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';
$user = new User();

$agents = $user->listAgents();
?>

<div>
    <h4 class="text-center">Agent Commission Percentages</h4>
</div>
<table class="table mt-2" id="tableCommissions">
    <thead class="bg-sky-950 text-white text-center">
        <tr>
            <th class="p-2 rounded-s">Agent</th>
            <th>Commission</th>
            <th>Supervisor</th>
            <th class="p-2 rounded-e">Commission</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <?php
        foreach ($agents as $agent) {
            echo "<tr class='border-b'>
                        <td data-id='$agent[id]' title='" . $agent['firstName'] . " " . $agent['lastName'] . "'>$agent[firstName]</td>
                        <td class='flex items-center justify-end'><input type='number' class='w-3/4 rounded' id='commission' min='5' max='40' step='5' value='$agent[agentCommission]'>%</td>
                        <td><select class='' id='supervisor'>
                        <option value='0'>No Supervisor</option>";
            foreach ($agents as $supervisor) {
                $selected = $supervisor['id'] == $agent['idSupervisor'] ? 'selected' : '';
                echo "<option value='$supervisor[id]' $selected>$supervisor[firstName]</option>";
            }
            echo "</select></td>
                        <td class='flex items-center justify-end'><input type='number' class='w-3/4 rounded' id='supervisorComm' min='5' max='40' step='5' value='$agent[supervisorCommission]'>%</td>
                    </tr>";
        }
        ?>
    </tbody>
</table>

<script>
    $('#btnSaveCommission').click(function() {
        $flag = true;
        $('#tableCommissions tbody tr').each(function() {
            var agentCommission = $(this).find('#commission').val();
            var supervisorCommission = $(this).find('#supervisorComm').val();
            if (agentCommission == '' || supervisorCommission == '') {
                $flag = false;
                toast('Commission cannot be blank', 'error');
                console.log('Commission cannot be blank');
                return false;
            }
            if (agentCommission < 0 || agentCommission > 40 || supervisorCommission < 0 || supervisorCommission > 40) {
                $flag = false;
                toast('Commission must be between 5 and 40 %', 'error');
                console.log('Commission must be between 5 and 40 %');
                return false;
            }
        });
        if (!flag) {
            return false;
        }
        if ($flag) {
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
        }
        if ($flag) {
            modalHide('infoModal');
            $('#infoModalTitle').text('Success');
            $('#infoModalText').html('Commissions updated successfully');
            $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-green-800');
            $('#infoModalButtons').html('<div id="okButton">OK</div>');
            $('#okButton').load('../components/buttons/okButton.php');
            modalShow('infoModal');
            var checkedButtonId = $('input[name="quarters"]:checked').attr('id');
            loadPolicySummary(checkedButtonId);
            loadPolicyTable();
        } else {
            modalHide('infoModal');
            $('#infoModalTitle').text('Error');
            $('#infoModalText').html('There was an error updating the commissions, please try again');
            $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-red-800');
            $('#infoModalButtons').html('<div id="okButton">OK</div>');
            $('#okButton').load('../components/buttons/okButton.php');
            modalShow('infoModal');
        }
    });
    $(document).ready(function() {
        modalHide('spinner');
    });
</script>