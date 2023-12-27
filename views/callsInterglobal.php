<div class="row">
    <div class="col-sm-12 col-md-4 ">
        <p>Filter calls by Type</p>
        <select class="form-select" name="" id="filterCallType">
            <option value="1" selected>New Venture</option>
            <option value="2">Renewals</option>
        </select>
    </div>
    <div class="col-md-4 col-sm-12">
        <p>Filter calls by Status</p>
        <select class="form-select" name="" id="filterCallStatus">
            <option value="0">Any</option>
            <option value="1">New</option>
            <option value="2">No Answer</option>
        </select>
    </div>
    <div class="col-md-4 col-sm-12">
        <p>Filter calls by State</p>
        <select class="form-select" name="" id="filterCallState"></select>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-5 col-sm-12">
        <p>Search for a Company based on phone number or DOT</p>
    </div>
    <div class="col-md-4 col-sm-12 text-start ps-0">
        <div class="input-group mb-3">
            <input id="inputSearchByPhoneOrDot" type="text" class="form-control rounded-start" placeholder="Phone Number or DOT" aria-label="Phone Number or DOT" aria-describedby="btnSearchByPhone">
            <button class="btn btn-outline-success" type="button" id="btnSearchByPhoneOrDot">Search</button>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <button id="btnNextBusiness" class="btn btn-warning text-white rounded w-100" data-toggle="tooltip" data-placement="top" title="Click if you wish to load a new business to call based on the filters">New Call</button>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-12 col-md-4">
        <h4>Company Details</h4>
        <div><span>DOT: </span><span id="businessDOT"></span></div>
        <div id="businessMC">MC:</div>
        <div id="businessName">Name:</div>
        <div id="businessRep">Rep:</div>
        <div id="businessAddress">Address:</div>
        <div id="businessState">State:</div>
        <div id="listDate">List Date: </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div id="insuranceDetails" class="d-none">
            <h4>Insurance Details</h4>
            <div id="insuranceName">Insurer:</div>
            <div id="insurancePolicy">Policy Number:</div>
            <div id="insuranceType">Insurance Type:</div>
            <div id="insuranceExpirationDate">Expiration Date:</div>
        </div>
        <div class="mt-1 p-1 border rounded">
            <h4 class="text-center">Call this Company</h4>
            <h4 class=" mb-2 text-center">
                <button class="btn btn-success pe-none rounded p-2">
                    <!-- <span class="fa-solid fa-phone fa-lg"></span> -->
                    <span class="user-select-all text-decoration-none text-white" id="businessPhone"></span>
                </button>
            </h4>
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <h4 class="text-center">Call History</h4>
        <table class="table table-sm table-spaced">
            <thead class="fw-bold">
                <td>Date</td>
                <td>Notes</td>
            </thead>
            <tbody class="clickableCallHistory" id="tableCallHistory"></tbody>
        </table>
    </div>
</div>
<hr>
<div class="row">
    <div class="text-center">
        <p class="card-text">Please select one of the options after ending the call</p>
        <div class="btn-group" role="group" aria-label="Elije el resultado de la llamada">
            <button type="button" id="acarreoMensual" class="btnStatus btn btn-outline-success">Lead</button>
            <button type="button" id="acarreoSemanal" class="btnStatus btn btn-outline-primary">Possible Lead</button>
            <button type="button" id="acarreoDiario" class="btnStatus btn btn-outline-warning">No Answer</button>
            <button type="button" id="acarreoTransportista" class="btnStatus btn btn-outline-danger">Not Interested</button>
            <button type="button" id="acarreoTransportista" class="btnStatus btn btn-outline-dark">Black List</button>
        </div>
    </div>
</div>
<hr>
<div class="row text-center">
    <div id="calendar" class="col-md-4 col-sm-12 mt-2">
        <h4 class="text-center">Call Again</h4>
        <div class="row bg-primary rounded-top" id="calendarHeader">
            <div class="row">
                <div class="col-2">
                    <span class="fa-solid fa-backward-fast fa-lg text-white"></span>
                </div>
                <div class="col-8 text-center">
                    <span class="text-white fw-bolder" id="monthLookup">September</span>
                </div>
                <div class="col-2">
                    <span class="fa-solid fa-forward-fast fa-lg text-white"></span>
                </div>
            </div>
            <div class="row text-white g-0 text-center">
                <div class="dia">Sun</div>
                <div class="dia">Mon</div>
                <div class="dia">Tue</div>
                <div class="dia">Wed</div>
                <div class="dia">Thu</div>
                <div class="dia">Fri</div>
                <div class="dia">Sat</div>
            </div>
        </div>
        <div class="row border-1 border border-primary rounded-bottom" id="calendarBody">
        </div>
    </div>
    <div class="col-md-8 col-sm-12 mt-2">
        <h4>Notes:</h4>
        <textarea class="form-control" id="callNotes" cols="30" rows="7"></textarea>
        <div class="form-check text-end">
            <input type="checkbox" class="form-check-input float-end" id="sentMessage">
            <label class="form-check-label me-5" for="">Sent Message</label>
        </div>
    </div>
</div>
<hr>
<div class="row justify-content-end">

    <div class="btn-group w-25 gap-2">
        <button id="btnSaveCall" class="btn btn-success rounded">Save</button>
    </div>
</div>

<script type="text/javascript" src="../js/callsInterglobal.js"></script>
<link rel="stylesheet" href="../css/callsInterglobal.css">