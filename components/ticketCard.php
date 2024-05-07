<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';

$priority = 3;
$createdOn = '2021-09-01';
$createdBy = 1;
$user = getAgent($createdBy);

?>


<div class="bg-warning rounded-top text-white p-2" id=<?= $id ?>>Ticket Title<span class="float-end">Priority : 3</span></div>
<div class="border-bottom border-start border-end border-warning rounded-bottom p-1">
    <div>Description:</div>
    <div>lkasdj faosd fojas djfoaks mdfoas mfkoasdj ofkmas dkofj dasokfma sdokfm asdofm oaksdmf koasdmf koasdmf </div>
    <hr>
    <div class="text-end w-100"><small>Created on <?= $createdOn ?> by <?= $user['firstName'] . ' ' . $user['lastName'] ?></small></div>
</div>