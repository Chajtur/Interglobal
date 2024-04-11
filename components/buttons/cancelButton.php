<button id="cancelButton" type="button" class="btn-danger">Cancel</button>

<script>
    $('#cancelButton').click(function() {
        $(this).closest('.modal').addClass('hidden');
    });
</script>