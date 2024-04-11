<?php

include '../models/Dates.php';
include '../models/User.php';
include '../controllers/Login.php';

$user = new User($_SESSION['user']['id']);
$fecha = $_POST['fecha'];
$dates = new Holiday($fecha);

$data = $dates->getDaysOff(getUser());

?>
<div class="accordion">
    <div id="" class="accordion-header bg-sky-950 justify-between" data-content='vacacionesContent'>
        <h4>Vacations</h4>
        <div class="flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 arrowClose">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 arrowOpen">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
    </div>
</div>
<div id="vacacionesContent" class="accordion-content h-96">
    <div class="tab-group flex flex-row mt-2" id="tabVacaciones">
        <div class="text-tab active w-32" id="tabMisVacaciones" data-target="MisVacaciones">My Vacations</div>
        <?php if ($user->hasPermission('listarVacaciones')) {
            $dataDate = $dates->getApprovedDaysOffbyDay($fecha); ?>
            <div class="text-tab w-32" id="tabVacacionesPersonal" data-target="VacacionesPersonal">Staff</div>
        <?php }; ?>
    </div>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active h-80" id="contentMisVacaciones">
            <div class="justify-end flex my-2 w-full">
                <button type="button" class="btn-success solicitarVacaciones" data-searchDate='<?php echo $_POST['fecha'] ?>'>Request Vacations</button>
            </div>
            <div class="w-full">
                <div class="bg-sky-950 rounded-t-md text-white text-xl flex flex-row text-end p-2">
                    <div class="w-1/4 text-start">No</div>
                    <div class="w-1/4 text-center">Date</div>
                    <div class="w-1/4 text-center">Days</div>
                    <div class="w-1/4">Status</div>
                </div>
                <div class="text-end row-group overflow-y-auto h-64">
                    <?php foreach ($data as $key => $vacacion) {
                        switch ($vacacion['status']) {
                            case 'Requested':
                                $bgColor = 'bg-blue-800';
                                break;
                            case 'Approved':
                                $bgColor = 'bg-green-800';
                                break;
                            case 'Denied':
                                $bgColor = 'bg-red-800';
                                break;
                        } ?>
                        <div data-target='#id<?php echo $vacacion['id'] ?>' class='text-white row-tab cursor-pointer flex flex-row p-2 <?php echo $bgColor ?>'>
                            <div class="w-1/4 text-start"><?php echo ++$key ?></div>
                            <div class="w-1/4 text-center"><?php echo $vacacion['dateFrom'] ?></div>
                            <div class="w-1/4 text-center"><?php echo $dates->getBusinessDays($vacacion['dateFrom'], $vacacion['dateTo']) ?></div>
                            <div class="w-1/4 text-end"><?php echo $vacacion['status'] ?></div>
                        </div>
                        <div class='row-content h-full' id='contentid<?php echo $vacacion['id'] ?>' data-parent='.table'>
                            <div colspan='4'>
                                <h4 class="w-full text-center">Request Details</h4>
                                <div class='flex flex-row justify-between border-b border-gray-500'>
                                    <div>Request Date: </div>
                                    <div><?php echo $vacacion['requestDate'] ?></div>
                                </div>
                                <div class='flex flex-row justify-between border-b border-gray-500'>
                                    <div class=''>Start Date: </div>
                                    <div class=''><?php echo $vacacion['dateFrom'] ?></div>
                                </div>
                                <div class='flex flex-row justify-between border-b border-gray-500'>
                                    <div class=''>End Date: </div>
                                    <div class=''><?php echo $vacacion['dateTo'] ?></div>
                                </div>
                                <div class='flex flex-row justify-between border-b border-gray-500'>
                                    <div class=''>Reason: </div>
                                    <div class=''><?php echo $vacacion['detail'] ?></div>
                                </div>
                                <div class='flex flex-row justify-between border-b border-gray-500'>
                                    <div class=''>Reviewed By: </div>
                                    <div class=''><?php echo $vacacion['approvedEmployee'] ?: ''; ?></div>
                                </div>
                                <div class='flex flex-row justify-between border-b border-gray-500'>
                                    <div class=''>Review Date: </div>
                                    <div class=''><?php echo $vacacion['approvedDate'] ?: '' ?></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="tab-pane h-80" id="contentVacacionesPersonal">
            <?php if ($dataDate) { ?>
                <div class="w-full mt-2">
                    <div class="bg-sky-950 rounded-t-md text-white text-xl flex flex-row text-end p-2">
                        <div class="w-1/4 text-start">No</div>
                        <div class="w-1/4 text-center">Date</div>
                        <div class="w-1/4 text-center">Days</div>
                        <div class="w-1/4">Status</div>
                    </div>
                    <div class="text-end row-group overflow-y-auto h-64">
                        <?php foreach ($dataDate as $key => $vacacion) {
                            switch ($vacacion['status']) {
                                case 'Requested':
                                    $bgColor = 'bg-blue-800';
                                    break;
                                case 'Approved':
                                    $bgColor = 'bg-green-800';
                                    break;
                                case 'Denied':
                                    $bgColor = 'bg-red-800';
                                    break;
                            } ?>
                            <div data-target='#id<?php echo $vacacion["id"] ?>' class='text-white row-tab cursor-pointer flex flex-row p-2 <?php echo $bgColor ?>'>
                                <div class="w-1/4 text-start"><?php echo ++$key ?></div>
                                <div class="w-1/4 text-center"><?php echo $vacacion['dateFrom'] ?></div>
                                <div class="w-1/4 text-center"><?php echo $dates->getBusinessDays($vacacion['dateFrom'], $vacacion['dateTo']) ?></div>
                                <div class="w-1/4 text-end"><?php echo $vacacion['status'] ?></div>
                            </div>
                            <div class='row-content h-full' id='id<?php echo $vacacion['id'] ?>' data-parent='.table'>
                                <div colspan='4'>
                                    <h4 class="w-full text-center">Request Details</h4>
                                    <div class='flex flex-row justify-between border-b border-gray-500'>
                                        <div class=''>Requested By</div>
                                        <div class=''><?php echo $vacacion['requestEmployee'] ?></div>
                                    </div>
                                    <div class='flex flex-row justify-between border-b border-gray-500'>
                                        <div class=''>Request Date</div>
                                        <div class=''><?php echo $vacacion['requestDate'] ?></div>
                                    </div>
                                    <div class='flex flex-row justify-between border-b border-gray-500'>
                                        <div class=''>Start Date</div>
                                        <div class=''><?php echo $vacacion['dateFrom'] ?></div>
                                    </div>
                                    <div class='flex flex-row justify-between border-b border-gray-500'>
                                        <div >End Date</div>
                                        <div ><?php echo $vacacion['dateTo'] ?></div>
                                    </div>
                                    <div class='flex flex-row justify-between border-b border-gray-500'>
                                        <div >Reason</div>
                                        <div ><?php echo $vacacion['detail'] ?></div>
                                    </div>
                                    <div class='flex flex-row justify-between border-b border-gray-500'>
                                        <div >Reviewed By</div>
                                        <div ><?php echo ($vacacion['approvedEmployee'] ?: '') ?></div>
                                    </div>
                                    <div class='flex flex-row justify-between border-b border-gray-500'>
                                        <div >Review Date</div>
                                        <div ><?php echo ($vacacion['approvedDate'] ?: '') ?></div>
                                    </div>
                                    <?php if ($user->hasPermission('aprobarVacaciones')) { ?>
                                        <div class="flex flex-row w-full justify-end my-1">
                                            <div class="">
                                                <button type="button" class="btn-danger shadow-none solicitarVacaciones" data-searchDate='<?php $_POST['fecha'] ?>'>Reject</button>
                                                <button type="button" class="btn-success shadow-none solicitarVacaciones" data-searchDate='<?php $_POST['fecha'] ?>'>Approve</button>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            <?php } else { ?>
                <div class='mt-2'>No vacation requests for this date</div>
            <?php } ?>
        </div>
    </div>
</div>
</div>

<script>
    $('.accordion').click(function() {
        $(this).find('.accordion-header').toggleClass('active');
        console.log($(this).find('.accordion-header').data('content'));
        $('#' + $(this).find('.accordion-header').data('content')).toggleClass('active');
    });
    $('.text-tab').click(function() {
        $(this).siblings('.text-tab').removeClass('active');
        $(this).addClass('active');
        var tabGroup = $(this).closest('.tab-group');
        var tabContent = tabGroup.siblings('.tab-content');
        tabContent.find('.tab-pane').removeClass('active');
        tabContent.find('#content' + $(this).data('target')).addClass('active');
    });
    $('.row-tab').click(function() {
        $(this).siblings('.row-tab').removeClass('active');
        $(this).toggleClass('active');
        $(this).siblings('.row-content').not($(this).next()).removeClass('active');
        $(this).next('.row-content').toggleClass('active');
    });
</script>