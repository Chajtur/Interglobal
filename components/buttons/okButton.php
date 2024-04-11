<button id="okButton" type="button" class="btn-info">Ok</button>

<script>
    $('#okButton').click(function() {
        $(this).closest('.modal').addClass('hidden');
    });
</script>