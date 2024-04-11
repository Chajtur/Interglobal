<?php
$referral = $_GET['referral'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/55b2ee1815.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/test.css">
    <title>
        INTERGLOBAL INSURANCE CO. | US TRUCKING FOR HIRE
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="msapplication-TileImage" content="https://interglobalus.com/wp-content/uploads/2021/12/cropped-LOGO-INTERGLOBAL-01-270x270.png">
</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-sm-12 mx-auto">
                    <h4 class="bg-secondary text-white text-center p-2 border rounded">INTERGLOBAL INSURANCE</h4>
                    <div class="row mt-n2">
                        <h5 class="bg-primary text-white text-center p-2 border rounded">Quote Request</h5>
                    </div>
                    <div class="row" id="agencyInformation">
                        <div class="col-lg-8 col-sm-12 p-0">
                            <div class="form-floating mb-2">
                                <input disabled class="form-control rounded border-primary" id="referral" type="text" placeholder="Referral" value="<?= $referral ?>">
                                <label class="text-primary" for="referral">REFERRAL</label>
                            </div>
                            <div class="row mt-2">
                                <div class="d-none col-lg-2 col-sm-12 bg-primary text-white rounded-start py-1 text-center">Application Date</div>
                                <div class="d-none col-lg-3 col-sm-12 pair">
                                    <div id="rfpDate" class="h-100 bg-white text-primary border border-primary py-1 rounded-end text-center">
                                        March 28th, 2023
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12 bg-primary text-white rounded-start py-1 text-center">Proposed Effective Date</div>
                                <div class="col-lg-4 col-sm-12 bg-white text-primary border border-primary rounded-end py-1 text-center">
                                    <input id="rfpProposedDate" type="date">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block">
                            <img class="img-fluid" src="../assets/logo-small.png" alt="Interglobal Insurance Co">
                        </div>
                    </div>

                    <div id="tabII" class="row mt-2 tab-pane fade show active">
                        <div class="border rounded border-primary pb-2 ">
                            <span class="fw-bold text-decoration-underline text-primary h4">
                                Insured Information
                            </span>
                            <span class="fs-6 fw-lighter small text-muted ms-5">* fields are required</span>
                            <div class="row mt-2 gy-1">
                                <div class="col-lg-1  bg-primary text-white rounded-start p-1 text-center">*DOT#</div>
                                <div class="col-lg-2  pair">
                                    <input type="number" id="insuredDOT" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                                </div>
                                <div class="col-lg-2  bg-primary text-white rounded-start p-1 text-center">*Name</div>
                                <div class="col-lg-4  pair">
                                    <input type="text" id="insuredName" placeholder="Insured Name" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                </div>
                                <div class="col-lg-2  bg-primary text-white rounded-start p-1 text-center">*Owner's Name</div>
                                <div class="col-lg-4  pair">
                                    <input type="text" id="ownersName" placeholder="Owner's Name" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                </div>
                                <div class="col-lg-1  bg-primary text-white rounded-start p-1 text-center">*Address</div>
                                <div class="col-lg-5  pair">
                                    <input type="text" id="insuredAddress" placeholder="Address" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                </div>
                                <div class="col-lg-1  bg-primary text-white rounded-start p-1 text-center">*City</div>
                                <div class="col-lg-2  pair">
                                    <input type="text" id="insuredCity" placeholder="City" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                </div>
                                <div class="col-lg-1  bg-primary text-white rounded-start p-1 text-center">*State</div>
                                <div class="col-lg-2  pair">
                                    <div class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                        <select id="insuredState" class="form-select" aria-label="Default select example">
                                            <option selected>Select a State</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1  bg-primary text-white rounded-start p-1 text-center">*ZipCode</div>
                                <div class="col-lg-1  pair">
                                    <input type="text" id="insuredZipCode" placeholder="Zipcode" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                </div>

                                <div class="col-lg-1 bg-primary text-white rounded-start p-1 text-center">
                                    <div>Parking Address</div>
                                </div>
                                <div>
                                    <label for="sameAddress">Same as business address</label>
                                    <input type="checkbox" id="sameAddress" checked>
                                </div>
                                <div id="parkingAddress" class="d-none row">
                                    <div class="col-lg-1  bg-primary text-white rounded-start p-1 text-center">*Parking Address</div>
                                    <div class="col-lg-5  pair">
                                        <input type="text" id="insuredAddress" placeholder="Address" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                    </div>
                                    <div class="col-lg-1  bg-primary text-white rounded-start p-1 text-center">*Parking City</div>
                                    <div class="col-lg-2  pair">
                                        <input type="text" id="insuredCity" placeholder="City" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                    </div>
                                    <div class="col-lg-1  bg-primary text-white rounded-start p-1 text-center">*Parking State</div>
                                    <div class="col-lg-2  pair">
                                        <div class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                            <select id="insuredState" class="form-select" aria-label="Default select example">
                                                <option selected>Select a State</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1  bg-primary text-white rounded-start p-1 text-center">*Parking ZipCode</div>
                                    <div class="col-lg-1  pair">
                                        <input type="text" id="insuredZipCode" placeholder="Zipcode" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                    </div>
                                </div>


                                <div class="col-lg-1  bg-primary text-white rounded-start p-1 text-center">Email</div>
                                <div class="col-lg-3  pair">
                                    <input type="email" id="insuredEmail" placeholder="Email" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                </div>
                                <div class="col-lg-1  bg-primary text-white rounded-start p-1 text-center">*Phone</div>
                                <div class="col-lg-2  pair">
                                    <input type="phone" id="insuredPhone" placeholder="Phone" class="h-100 bg-white text-primary border border-primary rounded-end p-1 text-center w-100">
                                </div>
                                <div class="col-lg-2  bg-primary text-white rounded-start p-1 text-center">Driver License</div>
                                <div class="col-lg-2  pair">
                                    <input type="text" id="insuredDriverLicense" placeholder="xxxxxxxx" class="bg-white h-100 text-primary border border-primary rounded-end p-1 text-center w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="spinner" class="modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded border-primary">
                            <div class="modal-header text-center">
                                <h5 class="text-primary">Querying FMCSA...</h5>
                                <span class="spinner-grow ms-n8 text-primary" role="status" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2 mb-2">
                <div class="col-lg-1 col-md-2 col-sm-4 mx-auto">
                    <div class="btn btn-lg btn-success" id="requestQuote">Request Quote!!</div>
                </div>
            </div>
        </div>
        </div>
    </main>
    <footer class="footer mt-auto">
        <link rel="stylesheet" href="../css/footer.css">
        <div class="col-md-12 d-none d-sm-block bg-primary">
            172 NE 23rd Terrace, Homestead, Fl 33033
            Office: 305-884-4080 / Mobile: 305-742-6203

            Office Hours: Mon - Fri 9:00 a.m. - 6:00 p.m. E.S.T.
            Saturday from 10 a.m. to 2 p.m / Sunday closed</div>
        <div class="col-sm-12 d-sm-block text-white bg-primary">
            <i class="fa-regular fa-copyright"></i> Copyright Interglobal Insurance Co 2022
        </div>
    </footer>
    <div id="spinner" class="modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded border-primary">
                <div class="modal-header text-center">
                    <h5 class="text-primary">Querying FMCSA...</h5>
                    <span class="spinner-grow ms-n8 text-primary" role="status" aria-hidden="true"></span>
                </div>
            </div>
        </div>
    </div>
    <div id="quoteSuccess" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Request Quote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Your quote has been requested successfully, an agent from Interglobal Insurance will contact you soon!!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        var $states = [{
                Alabama: 'AL'
            },
            {
                Alaska: 'AK'
            },
            {
                Arizona: 'AZ'
            },
            {
                Arkansas: 'AR'
            },
            {
                California: 'CA'
            },
            {
                Colorado: 'CO'
            },
            {
                Connecticut: 'CT'
            },
            {
                Delaware: 'DE'
            },
            {
                'District of Columbia': 'DC'
            },
            {
                Florida: 'FL'
            },
            {
                Georgia: 'GA'
            },
            {
                Hawaii: 'HI'
            },
            {
                Idaho: 'ID'
            },
            {
                Illinois: 'IL'
            },
            {
                Indiana: 'IN'
            },
            {
                Iowa: 'IA'
            },
            {
                Kansas: 'KS'
            },
            {
                Kentucky: 'KY'
            },
            {
                Louisiana: 'LA'
            },
            {
                Maine: 'ME'
            },
            {
                Maryland: 'MD'
            },
            {
                Massachusetts: 'MA'
            },
            {
                Michigan: 'MI'
            },
            {
                Minnesota: 'MN'
            },
            {
                Mississippi: 'MS'
            },
            {
                Missouri: 'MO'
            },
            {
                Montana: 'MT'
            },
            {
                Nebraska: 'NE'
            },
            {
                Nevada: 'NV'
            },
            {
                'New Hampshire': 'NH'
            },
            {
                'New Jersey': 'NJ'
            },
            {
                'New Mexico': 'NM'
            },
            {
                'New York': 'NY'
            },
            {
                'North Carolina': 'NC'
            },
            {
                'North Dakota': 'ND'
            },
            {
                Ohio: 'OH'
            },
            {
                Oklahoma: 'OK'
            },
            {
                Oregon: 'OR'
            },
            {
                Pennsylvania: 'PA'
            },
            {
                'Rhode Island': 'RI'
            },
            {
                'South Carolina': 'SC'
            },
            {
                'South Dakota': 'SD'
            },
            {
                Tennessee: 'TN'
            },
            {
                Texas: 'TX'
            },
            {
                Utah: 'UT'
            },
            {
                Vermont: 'VT'
            },
            {
                Virginia: 'VA'
            },
            {
                Washington: 'WA'
            },
            {
                'West Virginia': 'WV'
            },
            {
                Wisconsin: 'WI'
            },
            {
                Wyoming: 'WY'
            },
        ];

        var $html = '';

        $.each($states, function() {
            $.each(this, function($name, $value) {
                $html += `<option value='${$value}'>${$name}</option>`;
            });
        });
        $('#insuredState').html($html);

        $('#insuredDOT').on('focusout', function() {
            $('#spinner').modal('show');
            $.get('../controllers/Load.php', {
                action: 'generalDotWeb',
                dot: $(this).val(),
            }).done(function(resp) {
                if (resp) {
                    respuesta = JSON.parse(resp);
                    $('#insuredMC').val(respuesta.mcNumber);
                    $('#insuredName').val(respuesta.legalName);
                    $('#insuredAddress').val(respuesta.phyStreet);
                    $('#insuredCity').val(respuesta.phyCity);
                    $('#insuredZipCode').val(respuesta.phyZipcode);
                    $('#insuredState').val(respuesta.phyState);
                    modalHide('spinner');
                    $('#ownersName').focus();
                } else {
                    modalHide('spinner');
                    $('#insuredMC').focus();
                }
            });
        });

        $('#insuredMC').on('focusout', function() {
            $('#spinner').modal('show');
            $.get('../controllers/Load.php', {
                action: 'generalMC',
                mc: $(this).val(),
            }).done(function(resp) {
                if (resp) {
                    respuesta = JSON.parse(resp);
                    $('#insuredDOT').val(respuesta.dotNumber);
                    $('#insuredName').val(respuesta.legalName);
                    $('#insuredAddress').val(respuesta.phyStreet);
                    $('#insuredCity').val(respuesta.phyCity);
                    $('#insuredZipCode').val(respuesta.phyZipcode);
                    $('#insuredState').val(respuesta.phyState);
                    modalHide('spinner');
                    $('#ownersName').focus();
                }
                modalHide('spinner');
            });
        });

        $('#sameAddress').on('change', function() {
            if ($(this).is(':checked')) {
                $('#parkingAddress').addClass('d-none');
            } else {
                $('#parkingAddress').removeClass('d-none');
            }
        })

        $('#requestQuote').on('click', function() {
            $proposedDate = $('#rfpProposedDate').val();
            $dot = $('#insuredDOT').val();
            $mc = $('#insuredMC').val();
            $name = $('#insuredName').val();
            $ownersName = $('#ownersName').val();
            $address = $('#insuredAddress').val();
            $city = $('#insuredCity').val();
            $state = $('#insuredState').val();
            $zip = $('#insuredZipCode').val();
            $email = $('#insuredEmail').val();
            $phone = $('#insuredPhone').val();
            $driversLicense = $('#insuredDriverLicense').val();
            $.post('../controllers/Quote.php', {
                proposedDate: $proposedDate,
                dot: $dot,
                mc: $mc,
                name: $name,
                ownersName: $ownersName,
                address: $address,
                city: $city,
                state: $state,
                zip: $zip,
                email: $email,
                phone: $phone,
                driversLicense: $driversLicense,
                action: 'newQuote',
            }).done(function(resp) {
                if (resp = 1) {
                    $('#quoteSuccess').modal('show');
                } else {
                    alert('Error');
                }
            });
        });

    });
</script>