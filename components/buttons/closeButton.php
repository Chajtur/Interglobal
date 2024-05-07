<button id="closeButton" type="button" class="btn-danger">Close</button>

<script>
    $('#closeButton').click(function() {
        $(this).closest('.modal').addClass('hidden');
    });
</script>