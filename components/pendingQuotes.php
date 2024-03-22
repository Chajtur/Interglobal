<?php
include "../controllers/Login.php";
include_once '../models/Quote.php';

$quote = new pendingQuote();
$user = new User();
$quotes = $quote->getAll(getUser());
?>

<h4>Requested Quotes</h4>
<table class="table table-striped rounded">
    <thead>
        <th>Quote Date</th>
        <th>Name</th>
        <th>Status</th>
    </thead>
    <tbody id="tableQuotes">
        <?php
        foreach ($quotes as $quote) {
            echo "<tr class='clickable' data-id=" . $quote['dot'] . ">
            <td>" . $quote['date'] . "</td>
            <td>" . $quote['name'] . "</td>
            <td>" . $quote['status'] . "</td>
            </tr>";
        }
        ?>
    </tbody>
</table>