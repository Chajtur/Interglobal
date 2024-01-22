<?php

$styles = file_get_contents('../css/bootstrap.css');

?>


<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.3/dist/chart.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/55b2ee1815.js" crossorigin="anonymous"></script>
  <script src="../js/index.js"></script>
  <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
  <!-- <link rel="stylesheet" href="../css/bootstrap.css"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <!-- <link rel="stylesheet" href="../css/index.css"> -->

  <title>
    INTERGLOBAL INSURANCE CO. | US TRUCKING FOR HIRE
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <link rel="icon" href="https://app.interglobalus.com/assets/logo-tiny-removebg-preview.png">
</head>

<body class="p-10 text-primary d-flex row justify-content-between">
  <div>
    <table class="table shadow-lg">
      <thead>
        <tr>
        <th>
        <a class="navbar-brand align-self-start" href="#" data-config-id="brand">
          <img class="img-fluid" src="../assets/logo-tiny-removebg-preview.png" alt="" width="auto">
        </a>
      </th>
      <th>
        <div class="text-end">
          <div class="h5">Quote Number: {QuoteNumber}</div>
        </div>
        <div class="text-end">
          <div class="h5">Quote Date: {Date}</div>
        </div>
      </th>
        </tr>
      </thead>
    </table>
    <div class="row text-center">
      <div class="h2 text-primary pt-8">Commercial Quote Proposal</div>
      <div class="h3">Client: {Client Name}</div>
    </div>
    <div class="mt-5">
      <p>
        Interglobal Insurance Company is pleased to offer you the following Insurance Quote:
      </p>
    </div>
  </div>
  <table class="table table-striped">
    <tbody>
      <tr>
        <td>
          <div>
            {Coverage 1}
          </div>
          <div>
            {Carrier}
          </div>
          <div>
            {Coverage Info and Notes}
          </div>
        </td>
        <td>
          Base Premium: {Base Premium}
        </td>
        <td>
          Taxes & Fees: {Taxes & Fees}
        </td>
        <td>
          Total Premium: {Total Coverage Premium}
        </td>
      </tr>
      <tr>
        <td>
          <div>
            {Coverage 2}
          </div>
          <div>
            {Carrier}
          </div>
          <div>
            {Coverage Info and Notes}
          </div>
        </td>
        <td>
          Base Premium: {Base Premium}
        </td>
        <td>
          Taxes & Fees: {Taxes & Fees}
        </td>
        <td>
          Total Premium: {Total Coverage Premium}
        </td>
      </tr>
      <tr>
        <td>
          <div>
            {Coverage 3}
          </div>
          <div>
            {Carrier}
          </div>
          <div>
            {Coverage Info and Notes}
          </div>
        </td>
        <td>
          Base Premium: {Base Premium}
        </td>
        <td>
          Taxes & Fees: {Taxes & Fees}
        </td>
        <td>
          Total Premium: {Total Coverage Premium}
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2"></td>
        <td>
          <div>
            BILL PLAN
          </div>
          <div>
            12 Months
          </div>
        </td>
        <td class="text-end">{Total Premium}</td>
      </tr>
      <tr>
        <td colspan="2"></td>
        <td>Down Payment</td>
        <td class="text-end">{Down Payment}</td>
      </tr>
      <tr>
        <td colspan="2"></td>
        <td>{installments} Installments</td>
        <td class="text-end">{installmentAmount}</td>
      </tr>
    </tfoot>
  </table>
  <footer class="d-flex bg-primary justify-content-center align-items-center w-100">
    <div class="text-white text-center">
      <div>
        172 NE 23rd Terrace, Homestead, Fl 33033
        Office: 305-884-4080 / Mobile: 305-742-6203
      </div>
      <div>
        Office Hours: Mon - Fri 9:00 a.m. - 6:00 p.m. E.S.T.
        Saturday from 10 a.m. to 2 p.m / Sunday closed
      </div>
    </div>
  </footer>
</body>
<style>
  <?php echo $styles; ?>
</style>