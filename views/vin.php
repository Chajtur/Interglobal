<script src="../js/vin.js"></script>
<link rel="stylesheet" href="../css/vin.css">
<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<div class="flex flex-col text-center">
    <div class="w-full md:w-1/3 mx-auto justify-center">
        <div class="mb-3 w-3/4 mx-auto">
            <div class="text-sky-950" for="vinSearch">Input the VIN number</div>
            <input class="rounded border border-sky-950" id="vinSearch" type="text" placeholder="VIN #">
        </div>
        <button class="btn-info" id="vinSearchBtn">Search</button>
        <div class="mt-4">
            <table class="table w-full">
                <thead class="bg-blue-400 text-white rounded-lg">
                    <th>Property</th>
                    <th>Value</th>
                </thead>
                <tbody id="vinTable" class="divide-y divide-gray-200"></tbody>
            </table>
        </div>
    </div>
</div>