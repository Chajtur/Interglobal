<?php
require_once '../controllers/Login.php';

startSession();
checkActivity();

?>
<h2 class="text-center">Call Center</h2>
<div class="row w-100">
    <div class="col-md-3 col-sm-12 text-center">
        <div class="btn-group-vertical" role="group" aria-label="Elije el tipo de indicador">
            <button type="button" class="btnMenu btn btn-outline-primary active">Calls</button>
            <button type="button" class="btnMenu btn btn-outline-primary">Call Log</button>
            <button type="button" class="btnMenu btn btn-outline-primary">Lists</button>
        </div>
        <div class="row mt-5">
            <div>
                <h4 class="text-center mt-4">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="List of Businesses we should call again soon">Reminders</span>
                    <button class="btn btn-success btnCreateReminder d-none" data-toggle="tooltip" data-placement="top" title="Create a reminder for a Business you have called before">+</button>
                </h4>
                <table class="table table-striped">
                    <thead>
                        <th>Date</th>
                        <th>Company</th>
                    </thead>
                    <tbody class="clickableCalls" id="tableReminders">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-sm-12 text-start">
        <div id="callCenterInterglobalContenido"></div>
    </div>
</div>
<!-- Modal para crear recordatorios -->
<div class="modal" tabindex="-1" id="modalCreateReminder">
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

<script type="text/javascript" src="../js/callCenterInterglobal.js"></script>
<link rel="stylesheet" href="../css/callCenterInterglobal.css">
<link rel="stylesheet" href="../css/calendar.css">