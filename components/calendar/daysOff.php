<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/Dates.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Login.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';

$user = $_POST['user'] ?? getUser();
$dates = new holiday();
$vacation = new vacation();

$daysOffList = $vacation->getDaysOff($user);
$data = $daysOffList;
$employee = new User($user);
$employee->load($user);
$availableDays = $vacation->getAvailableDays($user);

$daysOff['requested'] = 0;
$daysOff['available'] = 0;
$daysOff['approved'] = 0;
$daysOff['denied'] = 0;
$workingDate = $vacation->getWorkingDate($employee->hireDate);

if ($daysOffList == null)
{
    $daysOffList = [];
}
foreach ($daysOffList as $day)
{
    if ($day['dateFrom'] >= $workingDate)
    {
        if ($day['status'] == 'Requested')
        {
            $daysOff['requested'] += $dates->getBusinessDays($day['dateFrom'], $day['dateTo']);
        } elseif ($day['status'] == 'Approved')
        {
            $daysOff['approved'] += $dates->getBusinessDays($day['dateFrom'], $day['dateTo']);
            $daysOff['requested'] += $dates->getBusinessDays($day['dateFrom'], $day['dateTo']);
        } elseif ($day['status'] == 'Denied')
        {
            $daysOff['denied'] += $dates->getBusinessDays($day['dateFrom'], $day['dateTo']);
            $daysOff['requested'] += $dates->getBusinessDays($day['dateFrom'], $day['dateTo']);
        }
    }
}
?>

<div class="flex flex-row justify-between p-2">
    <div>Requested: <?= $daysOff['requested']; ?></div>
    <div>Earned (Available): <?= $availableDays ?> (<?= ($availableDays - $daysOff['approved']) ?>)</div>
</div>
<div class="flex flex-row justify-between p-2">
    <div>Approved: <?= $daysOff['approved']; ?></div>
    <div>Denied: <?= $daysOff['denied']; ?></div>
</div>
<div class="" id="contentMisVacaciones">
    <div class="justify-end flex my-2 w-full" id="requestVacationDiv">

    </div>
    <div class="w-full">
        <div class="bg-sky-950 rounded-t-md text-white text-xl flex flex-row text-end p-2">
            <div class="w-1/4 text-start">No</div>
            <div class="w-1/4 text-center">Date</div>
            <div class="w-1/4 text-center">Days</div>
            <div class="w-1/4">Status</div>
        </div>
        <div class="text-end row-group overflow-y-auto bg-white">
            <?php
            if ($data != null)
            {
                foreach ($data as $key => $vacacion)
                {
                    switch ($vacacion['status'])
                    {
                        case 'Requested':
                            $bgColor = 'text-yellow-800 bg-yellow-100 border-yellow-800 border';
                            break;
                        case 'Approved':
                            $bgColor = 'text-green-800 bg-green-100 border-green-800 border';
                            break;
                        case 'Denied':
                            $bgColor = 'text-red-800 bg-red-100 border-red-800 border';
                            break;
                    } ?>
                    <div data-target='#id<?php echo $vacacion['id'] ?>'
                        class='row-tab cursor-pointer flex flex-row p-2 border-b'>
                        <div class="w-1/4 text-start"><?php echo ++$key ?></div>
                        <div class="w-1/4 text-center"><?php echo $vacacion['dateFrom'] ?></div>
                        <div class="w-1/4 text-center">
                            <?php echo $dates->getBusinessDays($vacacion['dateFrom'], $vacacion['dateTo']) ?>
                        </div>
                        <div class="w-1/4 justify-end flex">
                            <div class="<?php echo $bgColor ?> rounded-lg px-2 w-auto">
                                <span><?php echo $vacacion['status'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class='row-content h-48' id='contentid<?php echo $vacacion['id'] ?>' data-parent='.table'>
                        <div colspan='4'>
                            <h4 class="w-full text-center">Request Details</h4>
                            <div class='flex flex-row justify-between border-b border-gray-500'>
                                <div>Request Date: </div>
                                <div class='pe-1'><?php echo $vacacion['requestDate'] ?></div>
                            </div>
                            <div class='flex flex-row justify-between border-b border-gray-500'>
                                <div class=''>Start Date: </div>
                                <div class='pe-1'><?php echo $vacacion['dateFrom'] ?></div>
                            </div>
                            <div class='flex flex-row justify-between border-b border-gray-500'>
                                <div class=''>End Date: </div>
                                <div class='pe-1'><?php echo $vacacion['dateTo'] ?></div>
                            </div>
                            <div class='flex flex-row justify-between border-b border-gray-500'>
                                <div class=''>Reason: </div>
                                <div class='pe-1'><?php echo $vacacion['detail'] ?></div>
                            </div>
                            <div class='flex flex-row justify-between border-b border-gray-500'>
                                <div class=''>Reviewed By: </div>
                                <div class='pe-1'><?php echo $vacacion['approvedEmployee'] ?: ''; ?></div>
                            </div>
                            <div class='flex flex-row justify-between border-b border-gray-500'>
                                <div class=''>Review Date: </div>
                                <div class='pe-1'><?php echo $vacacion['approvedDate'] ?: '' ?></div>
                            </div>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
</div>

<script>
    $('#requestVacationDiv').load('../components/buttons/requestVacationButton.php');

    $('.row-tab').click(function () {
        $(this).siblings('.row-content').not($(this).next()).removeClass('active');
        $(this).next('.row-content').toggleClass('active');
    });


</script>