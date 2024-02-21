<script>
    function printOption($id) {
        if ($id > 1) {
            $html += '<div class="page-break">';
        }
        $html += '<h1 class="text-center">Option ' +
            $id +
            '</h1></div>' +
            '<div class="row"><table class="table text-primary"><tbody>';
        var totalDownPayment = 0;
        var installmentAmount = 0;
        var i = 0;
        $('table[data-option="' + $id + '"] tr.billPlanRow').each(function() {
            i++;
            console.log('Printing bill plan ' + $(this).data('billplan') + ' for option ' + $id);
            var totalPremium = 0;
            var totalBasePremium = 0;
            var totalTaxesFees = 0;
            var billPlan = $(this).data('billplan');
            $html += '<tr class="bg-primary"><td colspan=4 class="text-white font-bold">BILL PLAN ' + i + '</td></tr>';
            $('.coverageRow[data-billPlan="' + billPlan + '"]').each(function() {
                console.log('Printing coverage ' + $(this).data('coverage') + ' for bill plan ' + billPlan + ' for option ' + $id);
                var coverage = $(this).find('td:eq(1)').text();
                var coverageAmount = $(this).find('td:eq(2)').text();
                var carrierName = $(this).find('td:eq(3)').text();
                var basePremium = $(this).find('td:eq(4)').text();
                var taxesFees = $(this).find('td:eq(5)').text();
                var totalPremiumCoverage = $(this).find('td:eq(6)').text();
                var notes = $(this).find('td:eq(7)').text();
                $html +=
                    '      <tr class="bg-warning-light">' +
                    '        <td>' +
                    '          <h6>' +
                    coverage +
                    '          </h6>' +
                    '          <h6>' +
                    'Insurance Company: ' +
                    carrierName +
                    '          </h6>' +
                    '          <h6>' +
                    coverageAmount +
                    '          </h6>' +
                    '          <h6>' +
                    notes +
                    '        </h6></td>' +
                    '        <td class="text-center"><h6>' +
                    '          Base premium</h6><h6>' +
                    basePremium +
                    '        </h6></td>' +
                    '        <td class="text-center"><h6>' +
                    '          Taxes & Fees</h6><h6>' +
                    taxesFees +
                    '        </h6></td>' +
                    '        <td class="text-center"><h6>' +
                    '          Total premium</h6><h6>' +
                    totalPremiumCoverage +
                    '        </h6></td>' +
                    '      </tr>';

                totalPremiumCoverage = totalPremiumCoverage.replace(',', '');
                totalPremiumCoverage = totalPremiumCoverage.replace('$', '');
                totalPremium += parseFloat(totalPremiumCoverage);
                basePremium = basePremium.replace(',', '');
                basePremium = basePremium.replace('$', '');
                totalBasePremium += parseFloat(basePremium);
                taxesFees = taxesFees.replace(',', '');
                taxesFees = taxesFees.replace('$', '');
                totalTaxesFees += parseFloat(taxesFees);
            });
            $html += '<tr class="bg-success-light">' +
                '<td></td>' +
                '<td class="text-center">' +
                '<h6>Total Base Premium</h6><h6>$' +
                totalBasePremium.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) +
                '</h6></td>' +
                '<td class="text-center">' +
                '<h6>Total Taxes & Fees</h6><h6>$' +
                totalTaxesFees.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) +
                '</h6></td>' +
                '<td class="text-center">' +
                '<h6>Total Premium</h6><h6>$' +
                totalPremium.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) +
                '</h6></td>' +
                '</tr>';
            $html += '<tr class="bg-success">' +
                '<td class=" text-primary font-bold">' +
                /*'BILL PLAN ' + i +*/
                '</td>' +
                '<td class="text-center"><h6 class=" text-primary font-bold">' +
                'Term</h6><h6 class=" text-primary font-bold">' +
                $(this).find('td:eq(2)').text() +
                ' months</h6>' +
                '</td>' +
                '<td class="text-center"><h6 class=" text-primary font-bold">' +
                'Down Payment</h6><h6 class=" text-primary font-bold">' +
                $(this).find('td:eq(4)').text() +
                '</h6></td>' +
                '<td class="text-center"><h6 class=" text-primary font-bold">' +
                $(this).find('td:eq(3)').text() +
                ' Installments of</h6><h6 class=" text-primary font-bold">' +
                $(this).find('td:eq(5)').text() +
                '</h6></td>' +
                '</tr><tr><td colspan=4><hr></tr>';
            totalDownPayment += parseFloat($(this).find('td:eq(4)').text().replace(',', '').replace('$', ''));
            installmentAmount += parseFloat($(this).find('td:eq(5)').text().replace(',', '').replace('$', ''));
        });
        $html += '<tr style="height: 20px;"><td colspan=4 class="font-bold text-center bg-primary text-white"><h4>&lt;=========== BILL PLAN SUMMARY ===========></h4></td></tr>';
        var count = 0;
        $('table[data-option="' + $id + '"] tr.billPlanRow').each(function() {
            count++;
            $html += '<tr class="bg-success-light text-primary">' +
                '<td class="font-bold text-primary">' +
                'BILL PLAN ' + count +
                '</td>' +
                '<td class="text-center">' +
                '<h6 class="font-bold  text-primary">Term</h6><h6 class="font-bold  text-primary">' +
                $(this).find('td:eq(2)').text() +
                ' months</h6>' +
                '</td>' +
                '<td class="text-center">' +
                '<h6 class="font-bold  text-primary">Down Payment</h6><h6 class="font-bold  text-primary">' +
                $(this).find('td:eq(4)').text() +
                '</h6></td>' +
                '<td class="text-center"><h6 class="font-bold  text-primary">' +
                $(this).find('td:eq(3)').text() +
                ' Installments of</h6><h6 class="font-bold  text-primary">' +
                $(this).find('td:eq(5)').text() +
                '</h6></td>' +
                '</tr>';
        });
        $html +=
            '    </tbody>' +
            '  </table></div>';
    };

    $html =
        '<head>' +
        '  <title>' +
        '    Quote Number: {QuoteNumber} | Interglobal Insurance Company' +
        '  </title>' +
        '  <meta name="viewport" content="width=device-width, initial-scale=1">' +
        '  <meta charset="utf-8">' +
        '  <link rel="icon" href="https://interglobalinsurance.com/wp-content/uploads/2021/12/LOGO-INTERGLOBAL-01-300x300.webp">' +
        '</head>' +
        '' +
        '<body class="text-primary d-flex row justify-content-between">' +
        '  <div>' +
        '    <table class="table shadow-lg">' +
        '      <thead>' +
        '        <tr>' +
        '           <th>' +
        '        <a class="navbar-brand align-self-start" href="#" data-config-id="brand">' +
        '          <img class="img-fluid" src="https://interglobalinsurance.com/wp-content/uploads/2021/12/LOGO-INTERGLOBAL-01-600x361.webp" alt="" width="auto">' +
        '        </a>' +
        '      </th>' +
        '      <th>' +
        '        <div class="text-end">' +
        '          <h5>Quote Number: {QuoteNumber}</h5>' +
        '        </div>' +
        '        <div class="text-end">' +
        '          <h5>Quote Date: {Date}</h5>' +
        '        </div>' +
        '      </th>' +
        '    </table>' +
        '    <hr>' +
        '    <div class="row text-center">' +
        '      <div class="h2 text-primary pt-8">Commercial Quote Proposal</div>' +
        '      <div class="h3">Client: ' +
        $('#clientDiv').data('name') +
        '</div>' +
        '    </div>' +
        '    <div class="mb-5">' +
        '      <p class="text-primary">' +
        '        Interglobal Insurance Company is pleased to offer you the following Insurance Quote:' +
        '      </p>' +
        '    </div>' +
        '  </div>';
    async function processOptions() {
        await Promise.all(
            $('.tableOptions[data-option]').toArray().map(async function(element) {
                console.log('Printing option : ' + $(element).data('option'));
                await printOption($(element).data('option'));
            })
        );
    }
    processOptions().then(() => {
        console.log('All options printed, now printing footer');
        $html += '  <div class="page-break">' +
            '    <table class="table border-0">' +
            '      <thead>' +
            '        <tr>' +
            '           <th>' +
            '        <a class="mt-5" href="#">' +
            '          <img class="img-fluid" src="https://app.interglobalus.com/assets/logo-small.png" alt="" width="auto">' +
            '        </a>' +
            '      </th>' +
            '      <th>' +
            '        <div class="text-end">' +
            '          <h5>Quote Number: {QuoteNumber}</h5>' +
            '        </div>' +
            '        <div class="text-end">' +
            '          <h5>Quote Date: {Date}</h5>' +
            '        </div>' +
            '      </th>' +
            '    </table>' +
            '    <hr>';
        $html += '<br><br><div class="mt-5"><p class="h5 text-justify">If you have any questions or doubts about the policies here presented, please do not hesitate contacting me, I am here to address any concerns you may have and ensure that you have all the information you need to make an informed decision about your insurance coverage. You can reach me at {phoneNumber} ext. {extension} or at my email {email}.</p><p class="h5">Your satisfaction and protection is our top priority.</p></div>' +
            '<br><br><br><br><div class="h5">{agentName}</div><div class="h5">Sales Executive</div></div><br><br><br><br>';
        $html += '<div style="position: absolute; bottom: 5px; width: 100%;"><h6>*Offer is valid for 30 days, after this period, the rates and terms may change.</h6>';
        $html += '<table class="table"><tr><td style="width: 30%;"><img class="footerImg" src="https://app.interglobalus.com/assets/bbb_a_rating_logo.jpg" alt="Interglobal Insurance Company"></td><td class="text-justify">As a distinguished member of the Better Business Bureau, Interglobal Insurance adheres to the highest standards of integrity, transparency, and customer service, ensuring that policyholders receive the utmost protection and satisfaction. With a track record of trustworthiness and accountability, Interglobal Insurance continues to set the benchmark for quality and reliability in the insurance sector.</td></tr></table></div>';
        $html +=
            '  <footer class="footer">' +
            '    <div class="d-flex bg-primary justify-content-center align-items-center w-100 p-2 mt-2 pt-3 row">' +
            '      <h6 class="text-white text-center">' +
            '        172 NE 23rd Terrace, Homestead, Fl 33033' +
            '        Office: 305-884-4080 / Mobile: 305-742-6203' +
            '      </h6>' +
            '      <h6 class="text-white text-center">' +
            '        Office Hours: Mon - Fri 9:00 a.m. - 6:00 p.m. E.S.T.' +
            '        Saturday from 10 a.m. to 2 p.m / Sunday closed' +
            '      </h6>' +
            '    </div>' +
            '  </footer>';
        $html += '</body>';
        $.ajax({
            url: '../components/html2pdf.php',
            method: 'POST',
            data: {
                html: $html,
                filename: 'test.pdf',
                dot: $('#btnPreviewProposal').data('dot'),
            },
            xhrFields: {
                responseType: 'blob',
            },
            success: function(response) {
                var file = new Blob([response], {
                    type: 'application/pdf'
                });
                var fileURL = URL.createObjectURL(file);

                // Create a new window or iframe and load the PDF into it for preview
                var previewWindow = window.open('', '_blank');
                var iframe = previewWindow.document.createElement('iframe');
                iframe.src = fileURL;
                iframe.style.width = '100%';
                iframe.style.height = '100%';
                previewWindow.document.body.appendChild(iframe);
                $('#previewProposalSpinner').addClass('d-none');
                $('#previewProposalFinished').removeClass('d-none');
            },
        });
    });
</script>

<div id="previewProposalSpinner" class="text-center justify-content-center align-items-center">
    <div class="spinner-border text-info" style="width: 4rem; height:4rem"></div>
    <div clas="text-primary">
        <p>Please wait while we generate your proposal<br><br><small class="fw-bold">Interglobal Insurance / US Trucking for Hire</small></p>
    </div>
</div>
<div id="previewProposalFinished" class="d-none text-center justify-content-center align-items-center">
    <div class="text-primary">
        <p>Your proposal is ready for download<br><br><small class="fw-bold">Interglobal Insurance / US Trucking for Hire</small></p>
    </div>
</div>