<script src="../js/rfp.js"></script>
<link rel="stylesheet" href="../css/rfp.css">
<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<div class="container-fluid h-100">
    <div class="row">
        <div class="col-lg-12 col-sm-12 mx-auto d-none">
            <div class="row" id="agencyInformation">
                <div class="col-lg-8 col-sm-12 p-0">
                    <div class="form-floating mb-2">
                        <input class="form-control rounded border-primary" id="referral" type="text" placeholder="Referral">
                        <label class="text-primary" for="referral">REFERRAL</label>
                    </div>
                    <div class="row mt-2">
                        <div class="border rounded border-primary pb-2 fw-bold">
                            <p class="text-decoration-underline text-primary h4">
                                Agency Information
                            </p>
                            <div class="row gy-1">
                                <div class="col-lg-2 col-sm-12 bg-primary text-white rounded-start py-1 text-center">Application Date</div>
                                <div class="col-lg-3 col-sm-12 pair">
                                    <div id="rfpDate" class="h-100 bg-white text-primary border border-primary py-1 rounded-end text-center">
                                        March 28th, 2023
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12 bg-primary text-white rounded-start py-1 text-center">Agency Name</div>
                                <div class="col-lg-4 col-sm-12 bg-white text-primary border border-primary rounded-end py-1 text-center">Interglobal Insurance Company</div>
                                <div class="col-lg-2 col-sm-12 bg-primary text-white rounded-start py-1 text-center">Person to Contact</div>
                                <div class="col-lg-3 col-sm-12 pair">
                                    <div class="h-100 bg-white text-primary border border-primary rounded-end py-1 text-center">Donald Córdoba</div>
                                </div>
                                <div class="col-lg-3 col-sm-12 bg-primary text-white rounded-start py-1 text-center">Proposed Effective Date</div>
                                <div class="col-lg-4 col-sm-12 bg-white text-primary border border-primary rounded-end py-1 text-center">
                                    <input id="rfpProposedDate" type="date">
                                </div>
                                <div class="col-lg-2 col-sm-6 bg-primary text-white rounded-start py-1 text-center">State</div>
                                <div class="col-lg-3 col-sm-6 pair">
                                    <div class="h-100 bg-white text-primary border border-primary rounded-end py-1 text-center">Florida</div>
                                </div>
                                <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start py-1 text-center">Agent Code</div>
                                <div class="col-lg-4 col-sm-6 bg-white text-primary border border-primary rounded-end py-1 text-center">99577</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block">
                    <img class="img-fluid" src="../assets/logo-small.png" alt="Interglobal Insurance Co">
                </div>
            </div>
            <div class="row mt-2 d-sm-block d-md-none" id="startBtns">
                <div class="col text-end">
                    <div class="btn btn-lg btn-primary fw-bold" id="btnPrevious">
                        Prev </div>
                </div>
                <div class="col text-start">
                    <div class="btn btn-lg btn-primary fw-bold" id="btnStart"> Next </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="border-bottom border-primary p-0 col-lg-12 mx-auto">
            <ul id='tabMenu' class="nav nav-tabs rounded justify-content-center">
                <li class="nav-item  border-primary m-1"><a data-id="0" data-bs-toggle="tab" href="#tabII" class="nav-link active"><i class="fa-solid fa-user-injured me-2"></i>Insured Information</a></li>
                <li class="nav-item  border-primary m-1"><a data-id="1" data-bs-toggle="tab" href="#tabPCI" class="nav-link"><i class="fa-solid fa-shield-halved me-2"></i>Prior Carrier Information</a></li>
                <li class="nav-item  border-primary m-1"><a data-id="2" data-bs-toggle="tab" href="#tabDI" class="nav-link"><i class="fa-regular fa-id-card me-2"></i>Driver Information</a></li>
                <li class="nav-item  border-primary m-1"><a data-id="3" data-bs-toggle="tab" href="#tabVI" class="nav-link"><i class="fa-solid fa-truck me-2"></i>Vehicle Information</a></li>
                <li class="nav-item  border-primary m-1"><a data-id="4" data-bs-toggle="tab" href="#tabLiability" class="nav-link"><i class="fa-solid fa-file-shield me-2"></i>Liability</a></li>
                <li class="nav-item  border-primary m-1"><a data-id="5" data-bs-toggle="tab" href="#tabCargo" class="nav-link"><i class="fa-solid fa-box me-2"></i>Cargo</a></li>
                <li class="nav-item  border-primary m-1"><a data-id="6" data-bs-toggle="tab" href="#tabPhysical" class="nav-link"><i class="fa-solid fa-car-burst me-2"></i>Physical Damage</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div id="tabContent" class="tab-content col-lg-12 mx-auto d-none d-md-block mt-4">
            <div id="tabII" class="tab-pane fade show active">
                <div class="">
                    <span class="fw-bold text-decoration-underline text-primary h4">
                        Insured Information
                    </span>
                    <span class="fs-6 fw-lighter small text-muted ms-5">* fields are required</span>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">*Insured DOT#</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="number" id="insuredDOT" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Insured MC#</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="number" id="insuredMC" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Brokerage</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <div class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                <div class="switchToggle">
                                    <input type="checkbox" id="switch">
                                    <label class="mx-auto" for="switch">Toggle</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">SSN</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="number" id="Address" placeholder="xxxxxxxxxx" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">FEI</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="number" id="Address" placeholder="xxxxxxxxxx" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">*Insured Name</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="text" id="insuredName" placeholder="Insured Name" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">*Owner's Name</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="text" id="ownersName" placeholder="Owner's Name" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">*Address</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="text" id="insuredAddress" placeholder="Address" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">*City</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="text" id="insuredCity" placeholder="City" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">*State</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <div class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                <select id="insuredState" class="form-select" aria-label="Default select example">
                                    <option selected>Select a State</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">*ZipCode</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="text" id="insuredZipCode" placeholder="Zipcode" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Email</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="email" id="Address" placeholder="Email" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">*Phone</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="phone" id="Address" placeholder="Phone" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Fax</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="text" id="Address" placeholder="Fax" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Other State Filings (Please provide ID #s if applicable)</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="text" id="Address" placeholder="xxxxxxxxxxx" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Years in Business</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="number" id="Address" placeholder="xx" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">States Entered</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="text" id="Address" placeholder="xx, xx, xx, xx" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Does the Insured do Doubles or Triples</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <div class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                <div class="switchToggle">
                                    <input type="checkbox" id="doubleOrTriple">
                                    <label class="mx-auto" for="doubleOrTriple">Toggle</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Major Cities Driving into or Through</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="text" id="Address" placeholder="xxxxx, xxxxx, xxxxxx" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-2 col-sm-6 pair">
                            <div class="h-100 bg-primary text-white border border-primary rounded p-1 text-center w-100">Radius (Give %)</div>
                        </div>
                        <div class="col-lg-1 col-sm-6 bg-primary text-white rounded-start p-1 text-center">0-100 Miles</div>
                        <div class="col-lg-1 col-sm-6 pair">
                            <input type="number" id="Address" placeholder="xx" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                        <div class="col-lg-1 col-sm-6 bg-primary text-white rounded-start p-1 text-center">101-300 Miles</div>
                        <div class="col-lg-1 col-sm-6 pair">
                            <input type="number" id="Address" placeholder="xx" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                        <div class="col-lg-1 col-sm-6 bg-primary text-white rounded-start p-1 text-center">301-600 Miles</div>
                        <div class="col-lg-1 col-sm-6 pair">
                            <input type="number" id="Address" placeholder="xx" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                        <div class="col-lg-2 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Over 600 Miles</div>
                        <div class="col-lg-1 col-sm-6 pair">
                            <input type="number" id="Address" placeholder="xx" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-2 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Planning on Expanding?</div>
                        <div class="col-lg-1 col-sm-6 pair">
                            <div id="" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                <div class="switchToggle">
                                    <input type="checkbox" id="expanding">
                                    <label class="mx-auto" for="expanding">Toggle</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 bg-primary text-white rounded-start p-1 text-center">How Much?</div>
                        <div class="col-lg-4 col-sm-6 pair">
                            <input type="text" id="Address" placeholder="xxxxx, xxxxx, xxxxxx" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                </div>
            </div>
            <div id="tabPCI" class="tab-pane fade">
                <div class="pb-2">
                    <span class="fw-bold text-decoration-underline text-primary h4">Prior Carrier Info for the past 3 Years</span>
                    <div class="row mt-2">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">From</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="month" id="pciYearFrom" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">To</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="month" id="pciYearTo" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Company</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="text" id="pciCompany" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Losses</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <div class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                <div class="switchToggle">
                                    <input type="checkbox" id="pciLosses">
                                    <label class="mx-auto" for="pciLosses">Toggle</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Details</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="text" id="pciDetails" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Driver Involved</div>
                        <div class="col-lg-3 col-sm-6 pair">
                            <input type="text" id="pciDriver" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-3 col-sm-6 bg-primary text-white rounded-start p-1 text-center">Upload Loss Run</div>
                        <div class="col-lg-3 col-sm-6 pair text-end">
                            <input type="file" id="pciLossRun" placeholder="" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-1 offset-5 text-end ps-0 d-flex flex-column float-end">
                            <div class="btn btn-outline-success fw-bold mt-auto" id="addPCI"><i class="fa-solid fa-square-plus"></i> Add</div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <table class="table table-striped text-center" id="priorCarrierInfo">
                            <thead>
                                <tr class="text-start">
                                    <th>
                                        From
                                    </th>
                                    <th>
                                        To
                                    </th>
                                    <th>
                                        Company
                                    </th>
                                    <th>
                                        Losses
                                    </th>
                                    <th>
                                        Details
                                    </th>
                                    <th>
                                        Driver Involved
                                    </th>
                                    <th class="text-end">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mb-3">
                        <div class="h6 col-auto m-0 mt-3 pe-0 align-bottom">Please explain any CANCELLATIONS/NONRENEWAL in the past 3 years:</div>
                        <div class="col ps-3">
                            <input type="text" id="pciDriver" placeholder="xxxxxxxx" class="text-start bg-white h-100 text-primary border-0 border-primary border-bottom w-100">
                        </div>
                    </div>
                </div>
            </div>
            <div id="tabDI" class="tab-pane fade">
                <div class="">
                    <div class="fw-bold text-decoration-underline h4">Driver Information</div>
                    <div class="row">
                        <div class="col-auto p-0">
                            <div>Does owner / insured name drive? If no, explain why</div>
                        </div>
                        <div class="col-auto">
                            <span class="switchToggle">
                                <input type="checkbox" id="ownerDrives">
                                <label class="" for="ownerDrives">Toggle</label>
                            </span>
                        </div>
                        <div class="col p-0">
                            <input type="text" id="ownerDoesNotDrive" placeholder="Why not?" class="h-100 bg-white text-primary shadow-none border border-primary rounded p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Driver Name</div>
                        <div class="col-3 pair">
                            <input type="text" id="diDriverName" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">DOB</div>
                        <div class="col-3 pair">
                            <input type="date" id="diDOB" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">License Number</div>
                        <div class="col-3 pair">
                            <input type="text" id="diLicenseNumber" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">State</div>
                        <div class="col-3 pair">
                            <div class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                <select id="diState" class="form-select" aria-label="Default select example">
                                    <option selected>Select a State</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Date Hired</div>
                        <div class="col-3 pair">
                            <input type="date" id="diDateHired" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">CDL Years</div>
                        <div class="col-3 pair">
                            <input type="number" id="diCDL" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <!-- <div class="row mt-1">
                        <div class="col-auto bg-primary text-white rounded-start p-1 text-center">Violations in the last 3 Years</div>
                        <div class="col-1 pair">
                            <input type="number" id="diLastYears" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-auto bg-primary text-white rounded-start p-1 text-center">Suspensions in the last 3 Years</div>
                        <div class="col-1 pair">
                            <input type="number" id="diSuspensions" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div> -->
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Accidents</div>
                        <div class="col-3 pair">
                            <input type="number" id="diAccidents" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Upload MVR</div>
                        <div class="col-3 pair">
                            <input type="file" id="diMVR" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-1 offset-5 text-end ps-0 d-flex flex-column float-end">
                            <div class="btn btn-outline-success fw-bold mt-auto float-end" id="addDI"><i class="fa-solid fa-square-plus"></i> Add</div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <table class="table table-striped text-center" id="diTable">
                            <thead>
                                <tr class="text-start">
                                    <th>
                                        Driver Name
                                    </th>
                                    <th>
                                        DOB
                                    </th>
                                    <th>
                                        License Number
                                    </th>
                                    <th>
                                        State
                                    </th>
                                    <th>
                                        Date Hired
                                    </th>
                                    <th>
                                        CDL Years
                                    </th>
                                    <th>
                                        Last 3 Years
                                    </th>
                                    <th>
                                        Accidents
                                    </th>
                                    <th class="text-end">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tabVI" class="tab-pane fade">
                <div class="row">
                    <div class="fw-bold text-decoration-underline h4">Vehicle Information</div>
                    <div class="row">
                        <div class="col-auto p-0">
                            <div>Does risk pull dump trailers?</div>
                        </div>
                        <div class="col-auto">
                            <span class="switchToggle">
                                <input type="checkbox" id="viDump">
                                <label class="" for="viDump">Toggle</label>
                            </span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Vehicle Identificaction Number</div>
                        <div class="col-3 pair">
                            <input type="text" id="viVIN" maxlength="17" minlength="17" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Year</div>
                        <div class="col-3 pair">
                            <input type="number" id="viYear" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Type</div>
                        <div class="col-3 pair">
                            <input type="text" id="viType" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Make</div>
                        <div class="col-3 pair">
                            <input type="text" id="viMake" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Gross Vehicle Weight</div>
                        <div class="col-3 pair">
                            <input type="number" id="viWeight" placeholder="xxxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Present Value</div>
                        <div class="col-3 pair">
                            <input type="number" id="viValue" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Radius Miles</div>
                        <div class="col-3 pair">
                            <input type="text" id="viMiles" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-1 ps-0 d-flex flex-column offset-5">
                            <div class="btn btn-outline-success fw-bold mt-auto float-end" id="addVI"><i class="fa-solid fa-square-plus"></i> Add</div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <table class="table table-striped text-center" id="viTable">
                            <thead>
                                <tr class="text-start">
                                    <th>
                                        Year
                                    </th>
                                    <th>
                                        Type
                                    </th>
                                    <th>
                                        Make
                                    </th>
                                    <th>
                                        GVW
                                    </th>
                                    <th>
                                        Present Value
                                    </th>
                                    <th>
                                        Radius Miles
                                    </th>
                                    <th>
                                        VIN
                                    </th>
                                    <th class="text-end">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tabLiability">
                <div class="">
                    <div class="fw-bold text-decoration-underline h4">Liability</div>
                    <div class="row mt-2">
                        <div class="col-lg-4 ms-0">
                            <button class="btn text-center btn-info active" role="button" aria-pressed="true" id="primaryLiabilityBtn">Primary</button>
                            <button class="btn text-center btn-info" role="button" id="nonTruckingLiabilityBtn">Non-Trucking</butt>
                        </div>
                    </div>
                    <div id="primaryLiabilityGrp">
                        <div class="row mt-2">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Auto Liability Limits</div>
                            <div class="col-3 pair">
                                <input type="number" id="viMake" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">UM</div>
                            <div class="col-3 pair">
                                <input type="number" id="viWeight" placeholder="xxxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">UIM</div>
                            <div class="col-3 pair">
                                <input type="number" id="viValue" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">PIP Coverage</div>
                            <div class="col-3 pair">
                                <input type="number" id="viMiles" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Med Pay</div>
                            <div class="col-3 pair">
                                <input type="number" id="viVIN" maxlength="17" minlength="17" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Hired Car</div>
                            <div class="col-3 pair">
                                <input type="number" id="viValue" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Non-Owned</div>
                            <div class="col-3 pair">
                                <input type="number" id="viValue" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">GL Coverage</div>
                            <div class="col-3 pair">
                                <input type="number" id="viValue" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Other</div>
                            <div class="col-3 pair">
                                <input type="number" id="viValue" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tabCargo">
                <div class="">
                    <div class="fw-bold text-decoration-underline h4">Cargo</div>
                    <div id="cargoGrp">
                        <div class="row mt-2">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Maximum Cargo Limit</div>
                            <div class="col-3 pair">
                                <input type="number" id="viYear" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Cargo Deductible</div>
                            <div class="col-3 pair">
                                <input type="number" id="viYear" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Reefer Breakdown Deductible</div>
                            <div class="col-3 pair">
                                <input type="number" id="viYear" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-2">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Commodity Transport</div>
                            <div class="col-3 pair">
                                <input type="number" id="commodityTransport" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">% of Total</div>
                            <div class="col-3 pair">
                                <input type="number" id="percentTotal" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Avg. Value per Truckload</div>
                            <div class="col-3 pair">
                                <input type="number" id="averageTruckload" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3 bg-primary text-white rounded-start p-1 text-center">Max. Value per Truckload</div>
                            <div class="col-3 pair">
                                <input type="number" id="valueTruckload" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-1 offset-5 text-end ps-0 d-flex flex-column float-end">
                                <div class="btn btn-outline-success fw-bold mt-auto float-end" id="addCargo"><i class="fa-solid fa-square-plus"></i> Add</div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <table class=" table table-striped text-center" id="cargoTable">
                                <thead>
                                    <tr class="text-start">
                                        <th>
                                            Commodity Transport
                                        </th>
                                        <th>
                                            % of Total
                                        </th>
                                        <th>
                                            Avg. Value per Truckload
                                        </th>
                                        <th>
                                            Max. Value per Truckload
                                        </th>
                                        <th class="text-end">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tabPhysical">
                <div class="">
                    <div class="fw-bold text-decoration-underline h4">Physical Damage</div>
                    <div class="row pb-2 gy-2">
                        <div class="col-lg-8">
                            <table class="table text-center table-bordered table-striped w-100">
                                <thead class="bg-primary text-white fw-bold">
                                    <td>Coverage</td>
                                    <td>Deductible in USD</td>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Specified Perils</td>
                                        <td><input class="text-end" type="number" id="specifiedPerils"></td>
                                    </tr>
                                    <tr>
                                        <td>Comprehensive</td>
                                        <td><input class="text-end" type="number" id="comprehensive"></td>
                                    </tr>
                                    <tr>
                                        <td>Collision</td>
                                        <td><input class="text-end" type="number" id="collision"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-4 d-flex align-items-center justify-content-center">
                            <div class="btn btn-success w-50 h-50 d-flex align-items-center justify-content-center"><span class="h4 text-white">SAVE QUOTE!!</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer mt-auto d-none d-md-block">
        <div class="row py-2">
            <div class="col text-end">
                <div class="btn btn-lg btn-primary fw-bold" id="btnPrevious">
                    Prev </div>
            </div>
            <div class="col text-start">
                <div class="btn btn-lg btn-primary fw-bold" id="btnNext"> Next </div>
            </div>
        </div>
    </div>
</div>