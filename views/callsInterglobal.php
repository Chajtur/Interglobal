<div class="flex flex-col lg:flex-row mt-4">
    <div class="w-full lg:w-1/3">
        <p>Filter calls by Type</p>
        <select class="px-2 py-2 w-5/6 border rounded border-gray-400 hover:border-2 " name="" id="filterCallType">
            <option value="1" selected>New Venture</option>
            <option value="2">Renewals</option>
        </select>
    </div>
    <div class="w-full lg:w-1/3">
        <p>Filter calls by Status</p>
        <select class="px-2 py-2 w-5/6 border rounded border-gray-400 hover:border-2 " name="" id="filterCallStatus">
            <option value="0">Any</option>
            <option value="1">New</option>
            <option value="2">No Answer</option>
        </select>
    </div>
    <div class="w-full lg:w-1/3">
        <p>Filter calls by State</p>
        <select class="px-2 py-2 w-5/6 border rounded border-gray-400 hover:border-2 " name="" id="filterCallState"></select>
    </div>
</div>
<div class="flex flex-col lg:flex-row mt-4">
    <div class="w-full lg:w-1/3 mt-4 lg:mt-0">
        <p class="text-sm">Search for a Company based on phone number or DOT</p>
    </div>
    <div class="w-full lg:w-1/3 text-start mt-4 lg:mt-0">
        <div class="flex flex-row w-5/6 mx-auto">
            <input id="inputSearchByPhoneOrDot" type="text" class="w-full rounded-l p-2 border-2 border-green-800" placeholder="Phone Number or DOT" aria-label="Phone Number or DOT" aria-describedby="btnSearchByPhone">
            <div class="cursor-pointer border-t-2 border-b-2 border-r-2 p-2 border-green-800 rounded-r text-green-800" type="button" id="btnSearchByPhoneOrDot">Search</div>
        </div>
    </div>
    <div class="w-full lg:w-1/3 mt-4 lg:mt-0">
        <div>
            <button id="btnNextBusiness" class="shadow-yellow-800 bg-gradient-to-r from-yellow-300 to-yellow-500 w-5/6  hover:bg-yellow-700" title="Click if you wish to load a new business to call based on the filters">New Call</button>
        </div>
    </div>
</div>
<hr class="mt-4">
<div class="flex flex-col lg:flex-row mt-4">
    <div class="w-full lg:w-1/3 text-start">
        <h4 class="text-sky-950 text-center">Company Details</h4>
        <div><span>DOT: </span><span id="businessDOT"></span></div>
        <div id="businessMC ">MC:</div>
        <div id="businessName" class="capitalize">Name:</div>
        <div id="businessRep" class="capitalize">Rep:</div>
        <div id="businessAddress" class="capitalize">Address:</div>
        <div id="businessState">State:</div>
        <div id="listDate">List Date: </div>
    </div>
    <div class="w-full lg:w-1/3">
        <div id="insuranceDetails" class="hidden text-start">
            <h4 class="text-center">Insurance Details</h4>
            <div id="insuranceName">Insurer:</div>
            <div id="insurancePolicy">Policy Number:</div>
            <div id="insuranceType">Insurance Type:</div>
            <div id="insuranceExpirationDate">Expiration Date:</div>
        </div>
        <div class="pb-3 pr-4">
            <div class="p-2 border rounded">
                <h4 class="text-center text-sky-950">Call this Company</h4>
                <h4 class="mt-2 text-center text-sm">
                    <button class="shadow-green-800 bg-gradient-to-r from-green-600 to-green-800 lg:w-1/2 mx-auto">
                        <a class="fa-solid fa-phone fa-lg no-underline text-white" id="businessPhoneLink"></a>
                        <span class="text-white" id="businessPhone"></span>
                    </button>
                </h4>
            </div>
        </div>
    </div>
    <div class="w-full lg:w-1/3">
        <h4 class="text-center text-sky-950">Call History</h4>
        <table class="table table-sm table-spaced w-full">
            <thead class="font-bold">
                <td>Date</td>
                <td>Notes</td>
            </thead>
            <tbody class="clickableCallHistory" id="tableCallHistory"></tbody>
        </table>
    </div>
</div>
<hr>
<div class="flex-col flex lg:flex-row">
    <div class="mx-auto text-center">
        <p class="text-sky-950">Please select one of the options after ending the call</p>
        <div class="flex-row text-center" role="group" aria-label="Please pick a call outcome">
            <button type="button" id="" class="btnStatus rounded font-bold py-2 px-3 cursor-pointer border-2 border-green-800 text-green-800 hover:ring-2 hover:ring-green-300 [&.active]:text-white [&.active]:bg-green-800">Lead</button>
            <button type="button" id="" class="btnStatus rounded font-bold py-2 px-3 cursor-pointer border-2 border-sky-950 text-sky-950 hover:ring-2 hover:ring-sky-300 [&.active]:text-white [&.active]:bg-sky-950">Possible Lead</button>
            <button type="button" id="" class="btnStatus rounded font-bold py-2 px-3 cursor-pointer border-2 border-yellow-500 text-yellow-500 hover:ring-2 hover:ring-yellow-300 [&.active]:text-white [&.active]:bg-yellow-500">No Answer</button>
            <button type="button" id="" class="btnStatus rounded font-bold py-2 px-3 cursor-pointer border-2 border-red-700 text-red-700 hover:ring-2 hover:ring-red-300 [&.active]:text-white [&.active]:bg-red-700">Not Interested</button>
            <button type="button" id="" class="btnStatus rounded font-bold py-2 px-3 cursor-pointer border-2 border-black text-black hover:ring-2 hover:ring-black [&.active]:text-white [&.active]:bg-black">Black List</button>
        </div>
    </div>
</div>
<hr class="mt-2">
<div class="flex flex-col md:flex-row text-center">
    <div id="calendar" class="w-full md:w-1/3 mt-2">
        <h4 class="text-center text-sky-950">Call Again</h4>
        <div class="flex flex-col bg-sky-950 rounded-t mt-2" id="calendarHeader">
            <div class="flex">
                <div class="w-1/6">
                    <span class="fa-solid fa-backward-fast fa-lg text-white"></span>
                </div>
                <div class="w-2/3 text-center">
                    <span class="text-white fw-bolder" id="monthLookup">September</span>
                </div>
                <div class="w-1/6">
                    <span class="fa-solid fa-forward-fast fa-lg text-white"></span>
                </div>
            </div>
            <div class="flex-row flex text-white g-0 text-center">
                <div class="dia">Sun</div>
                <div class="dia">Mon</div>
                <div class="dia">Tue</div>
                <div class="dia">Wed</div>
                <div class="dia">Thu</div>
                <div class="dia">Fri</div>
                <div class="dia">Sat</div>
            </div>
        </div>
        <div class="flex-col flex border-1 border border-sky-950 rounded-b text-black" id="calendarBody">
        </div>
    </div>
    <div class="w-full md:w-2/3 mt-2 pl-4">
        <h4 class="text-sky-950 text-center">Notes:</h4>
        <textarea class="border border-gray-400 w-full rounded mt-2 p-2" id="callNotes" cols="30" rows="7"></textarea>
        <div class="flex justify-end">
            <label class="form-check-label" for="">Sent Message</label>
            <input type="checkbox" class="align-bottom ms-1" id="sentMessage">
        </div>
    </div>
</div>
<hr class="mt-2">
<div class="flex-row flex mt-2">
    <div class="w-full text-end">
        <button id="btnSaveCall" class="bg-gradient-to-br shadow-green-800 from-green-600 to-green-800 text-white px-4 py-2 rounded">Save</button>
    </div>
</div>

<script type="text/javascript" src="../js/callsInterglobal.js"></script>
<link rel="stylesheet" href="../css/callsInterglobal.css">