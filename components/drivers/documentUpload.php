<h4>
    Upload Documents
</h4>
<div class="mt-1">
    <label class="font-medium text-sky-950" for="licenseScan">License</label>
    <input type="file" class="form-control  text-sky-950" id="licenseScan" accept=".jpg, .jpeg, .png, .pdf">
</div>
<div class="">
    <label class="font-medium text-sky-950" for="medicalCardScan">Medical
        Card</label>
    <input type="file" class="form-control text-sky-950" id="medicalCardScan" accept=".jpg, .jpeg, .png, .pdf">
</div>
<div class="">
    <label class="font-medium text-sky-950" for="mvrScan">MVR</label>
    <input type="file" class="form-control text-sky-950" id="mvrScan" accept=".pdf">
</div>

<script>
    $(document).ready(function () {
        $('#licenseScan').change(function () {
            var file = $(this)[0].files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#documentViewer img').eq(0).attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        });
        $('#medicalCardScan').change(function () {
            var file = $(this)[0].files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#documentViewer img').eq(1).attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        });
        $('#mvrScan').change(function () {
            var file = $(this)[0].files[0];
            var objectUrl = URL.createObjectURL(file);
            PDFObject.embed(objectUrl, "#mvrImage");
        });
    });
</script>