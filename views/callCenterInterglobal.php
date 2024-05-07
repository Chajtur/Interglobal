<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common.php';

startSession();
checkActivity();

?>
<h2 class="text-center text-3xl text-sky-950 font-bold">Call Center</h2>
<div class="flex lg:flex-row flex-col w-full content-center">
    <div class="w-full md:w-1/4 text-center mx-auto md:mt-2">
        <div class="hidden md:flex flex-col items-center justify-center cursor-pointer" role="group" aria-label="Choose the indicator type">
            <div type="button" class="bg-sky-950 text-white rounded-t w-28">Calls</div>
            <div type="button" class="text-sky-950 border-sky-950 border-r-2 border-l-2 w-28">Call Log</div>
            <div type="button" class="text-sky-950 border-2 border-sky-950 w-28 rounded-b">Lists</div>
        </div>
        <div class="flex flex-col mt-3">
            <div>
                <h4 class="text-center mt-4 text-xl font-bold">
                    <span title="List of Businesses we should call again soon">Reminders</span>
                    <button class="btnCreateReminder hidden" data-toggle="tooltip" data-placement="top" title="Create a reminder for a Business you have called before">+</button>
                </h4>
                <table class="min-w-full">
                    <thead class="border-t border-gray-400 border-b-2">
                        <th class="px-6 py-3 text-center">Date</th>
                        <th class="px-6 py-3 text-center">Company</th>
                    </thead>
                    <tbody class="clickableCalls" id="tableReminders">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="lg:ms-5 w-full md:w-2/3 text-start mx-auto">
        <div id="callCenterInterglobalContenido" class="text-center"></div>
    </div>
</div>
<!-- Modal para crear recordatorios -->
<div class="modal hidden" tabindex="-1" id="modalCreateReminder">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Reminder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <h5>Search for the business</h5>

                </div>
                <hr>
                <div class="row">
                    <h5>Set a date to call again this business</h5>
                    <div class="row">
                        <div class="col-6">
                            <label for="reminderMonth">Select Month</label>
                            <select class="form-select" name="" id="reminderMonth">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="reminderDay">Select Day</label>
                            <input class="form-control rounded" type="number" min="1" max="31" id="reminderDay">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Create</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="../css/callCenterInterglobal.css">
<link rel="stylesheet" href="../css/calendar.css">

<script>
    modalShow('spinner');

    $(document).ready(function() {
        $('#nombreModulo').text('Call Center');
        $('#nombreModuloM').text('Call Center');

        $('.btnMenu').click(function() {
            $('.btnMenu.active').removeClass('active');
            $(this).addClass('active');
            switch ($(this).text()) {
                case 'Calls':
                    $('#callCenterInterglobalContenido').load('../views/callsInterglobal.php');
                    break;
                case 'Call Log':
                    $('#callCenterInterglobalContenido').load('../views/callLog.php');
                    break;
                case 'Lists':
                    $('#callCenterInterglobalContenido').load('../views/lists.php');
                    break;
            }
        });

        modalHide('spinner');
    });

    $('.clickableCalls').on('click', 'tr', function() {
        getNewCall($(this).data('dot'));
    });

    $('#callCenterInterglobalContenido').load('../views/callsInterglobal.php');
</script>