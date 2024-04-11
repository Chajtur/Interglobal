<?php
include "../controllers/Login.php";
include_once '../models/Quote.php';

$quote = new pendingQuote();
$user = new User();
$quotes = $quote->getAll(getUser());
?>

<h4>Requested Quotes</h4>
<table class="table table-striped rounded">
    <thead class="text-white">
        <tr class='bg-sky-950'>
            <th class="rounded-s p-2">Quote Date</th>
            <th>Name</th>
            <th class='rounded-e'>Status</th>
        </tr>
    </thead>
    <tbody id="tableQuotes">
        <?php
        foreach ($quotes as $quote) {
            echo "<tr class='clickable border-b' data-id=" . $quote['dot'] . ">
            <td class='p-2'>" . $quote['date'] . "</td>
            <td>" . $quote['name'] . "</td>
            <td>" . $quote['status'] . "</td>
            </tr>";
        }
        ?>
    </tbody>
</table>