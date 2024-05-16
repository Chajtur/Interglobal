<div class="flex flex-col">
    <h4>Driver Details</h4>
    <div class="flex flex-row">
        <div class="w-full text-sky-950">
            <div class="">
                <label class="text-sky-950 font-medium" for="nombreConductor">Name</label>
                <input class="rounded border-sky-950" id="nombreConductor" type="text" placeholder="Name">
            </div>
            <div class="">
                <label class="text-sky-950 font-medium" for="licenciaConducir">License</label>
                <input class="rounded border-sky-950" id="licenciaConducir" type="text" placeholder="License">
            </div>
            <div class="">
                <label class="text-sky-950 font-medium" for="telefono">Phone</label>
                <input class="rounded border-sky-950" id="telefono" type="text" placeholder="Phone">
            </div>
            <div class="flex items-center cursor-pointer mt-3 w-2/5 justify-between">
                <label for="" class="mr-3 text-sky-950 font-medium">
                    Tanker Endorsement
                </label>
                <div class="relative">
                    <input id="tankerEndorsement" type="checkbox" class="sr-only" checked />
                    <div id="tankerEndorsementToggle" class="block bg-gray-600 w-14 h-8 rounded-full dotBG">
                    </div>
                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
                </div>
            </div>
            <div class="flex items-center cursor-pointer mt-3 w-2/5 justify-between">
                <label for="" class="mr-3 text-sky-950 font-medium">
                    Hazmat
                </label>
                <div class="relative">
                    <input id="hazmat" type="checkbox" class="sr-only" checked />
                    <div id="hazmatToggle" class="block bg-gray-600 w-14 h-8 rounded-full dotBG">
                    </div>
                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
                </div>
            </div>
            <div class="flex items-center cursor-pointer mt-3 w-2/5 justify-between">
                <label for="" class="mr-3 text-sky-950 font-medium">
                    Twic
                </label>
                <div class="relative">
                    <input id="twic" type="checkbox" class="sr-only" checked />
                    <div id="twicToggle" class="block bg-gray-600 w-14 h-8 rounded-full dotBG">
                    </div>
                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
                </div>
            </div>
        </div>
    </div>
</div>