<button id="noButton" type="button" class="btn-danger">No</button>

<script>
    $('#noButton').click(function() {
        $(this).closest('.modal').addClass('hidden');
    });
</script>