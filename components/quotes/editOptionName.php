<?php

$name = $_POST['name'] ?? 'Option Name';
$optionId = $_POST['optionId'] ?? 0;

?>

<div>
    <label for="optionName">Enter a name or description for the Option</label>
    <input id="optionName" class="rounded w-full" type="text" value='<?= $name ?>'>
</div>

<script>

$(document).off().on('click', '#btnUpdateOptionName', function() {
    var name = $('#optionName').val();
    var optionId = <?= $optionId ?>;
    console.log('Option ID: ' + optionId + ' Name: ' + name + ', changing name ');
    $('span[data-optionname="' + optionId + '"]').text(name);
    modalHide('infoModal');
});

</script>