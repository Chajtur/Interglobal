<h4 class="border-b-2 border-sky-900">Driver List</h4>
<div class="mt-2">
    <label class="text-sky-950" for="filtroNombres">Filter Drivers</label>
    <input class="rounded border-sky-950" id="filtroNombres" type="text" placeholder="Nombre">
</div>
<table class="table table-auto w-full">
    <thead>
        <th>Id</th>
        <th class="text-start">Name</th>
        <th class="text-start">License</th>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">1</td>
            <td>Robert</td>
            <td class="text-start">571-666-2617</td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>Tony Aguirre</td>
            <td class="text-start">571-707-9885</td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>Reinier</td>
            <td class="text-start">720 546 1178</td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>Aneudy</td>
            <td class="text-start">862-270-7929</td>
        </tr>
    </tbody>
</table>

<script>
    $('#filtroNombres').on('input', function() {
        let filtro = $(this).val().toLowerCase();
        $('tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(filtro) > -1)
        })
    });
</script>
