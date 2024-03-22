<?php 

$label = $_POST['label'];
$table = $_POST['table'];
$page = $_POST['page'];
$totalRows = $_POST['totalRows'];

?>

<nav aria-label="<?= $label ?>" class="text-end">
    <ul class="pagination text-primary">
        <li class="page-item">
            <a class="page-link text-primary firstPage" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li class="page-item"><a id="firstPage" class="page-link <?php echo $page == 1 ? 'bg-primary text-white' : 'text-primary' ?> pageNumber" href="#"><?php echo $page == 1 ? '1' : ($page - 1) ?></a></li>
        <li class="page-item"><a id="middlePage" class="page-link pageNumber <?php echo $page != 1 ? 'bg-primary text-white' : 'text-primary' ?>" href="#"><?php echo $page == 1 ? '2' : ($page) ?></a></li>
        <li class="page-item"><a id="lastPage" class="page-link pageNumber text-primary" href="#"><?php echo $page == 1 ? '3' : ($page + 1) ?></a></li>
        <li class="page-item">
            <a class="page-link text-primary lastPage" href="#" aria-label="Next" data-page=<?php echo number_format($totalRows % 10 == 0 ? ($totalRows / 10) : ($totalRows / 10) + 1, 0) ?>>
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>