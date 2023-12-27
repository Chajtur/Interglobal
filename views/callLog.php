<div class="row">
    <h3>Call Log</h3>
    <h4 class="">Options</h4>
    <div class="col-4">
        <p>Filter calls by Agent</p>
        <select class="form-select" name="" id="filterCallAgent">
            <option value="0">All</option>
        </select>
    </div>
    <div class="col-4">
        <p>Filter calls by Status</p>
        <select class="form-select" name="" id="filterCallStatus">
            <option value="0">Any</option>
            <option value="1">Lead</option>
            <option value="2">Possible Lead</option>
            <option value="3">No Answer</option>
            <option value="4">Not Interested</option>
            <option value="5">Black Listed</option>
        </select>
    </div>
    <div class="col-4">
        <p>Filter calls by State</p>
        <select class="form-select" name="" id="filterCallState"></select>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-2 offset-10">
        <button class="btn btn-success float-end" id="btnLoadCallLog">Search</button>
    </div>
</div>
<hr>
<table class="table">
    <thead>
        <th class="text-nowrap">Date</th>
        <th>Company</th>
        <th>Notes</th>
        <th class="text-nowrap">Messaged</th>
        <th class="text-nowrap">Call Again</th>
    </thead>
    <tbody id="callLogTable">
    </tbody>
</table>
</div>

<script type="text/javascript" src="../js/callLog.js"></script>
<!-- <link rel="stylesheet" href="../css/callLog.css">