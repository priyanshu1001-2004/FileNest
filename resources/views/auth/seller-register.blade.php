<!doctype html>
<html lang="en">
<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sash – Bootstrap 5  Admin & Dashboard Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/brand/new style FN.png" />

    <!-- TITLE -->
    <title>FileNest - Product Selling Form</title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href="../assets/css/dark-style.css" rel="stylesheet" />
    <link href="../assets/css/transparent-style.css" rel="stylesheet">
    <link href="../assets/css/skin-modes.css" rel="stylesheet" />

    <!--- FONT ICONS CSS -->
    <link href="../assets/css/icons.css" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="../assets/colors/color1.css" />

</head>

<body class="app sidebar-mini ltr">

    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="../assets/images/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">
            <!--app-content open-->
            <div class=" mt-0">
                <div class="">

                    <!-- CONTAINER -->
                    <div class="main-container container">

                        <!-- Row -->
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header border-bottom-0">
                                        <div class="card-title">
                                            <h1><b>Become a Seller</b></h1>
                                            <p>Complete your seller profile to start selling digital products on FileNest.</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="wizard1">
                                            <h3>Seller Information</h3>
                                            <section>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control required" placeholder="Name" data-field="name">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control required"
                                                        placeholder="Email Address" autocomplete="new-password" data-field="email">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Phone Number</label>
                                                    <input type="number" class="form-control required" placeholder="Number" data-field="phone">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group mb-0">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" class="form-control required" placeholder="Address" data-field="address">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </section>
                                            <h3>Store Information</h3>
                                             <section>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Store / Brand Name</label>
                                                    <input type="text" class="form-control required" placeholder="Store / Brand Name" data-field="storename">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Store Logo <span class="text-muted">(Optional)</span></label>
                                                    <input type="file" class="form-control" accept="image/*" data-field="storelogo">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Short Store Description <span class="text-muted">(Optional)</span></label>
                                                    <textarea class="form-control" rows="3" placeholder="Tell buyers about your business" data-field="storedescription"></textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Business Category</label>
                                                    <select class="form-select required" data-field="category">
                                                        <option value="">Select Category</option>
                                                        <option value="Software">Software</option>
                                                        <option value="Templates">Templates</option>
                                                        <option value="UI Kits">UI Kits</option>
                                                        <option value="eBooks">eBooks</option>
                                                        <option value="Courses">Courses</option>
                                                        <option value="Graphics">Graphics</option>
                                                        <option value="Music">Music</option>
                                                        <option value="Video">Video</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Seller Username</label>
                                                    <input type="text" class="form-control required" placeholder="Unique username" data-field="username">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Website <span class="text-muted">(Optional)</span></label>
                                                    <input type="text" class="form-control" placeholder="https://yourwebsite.com" data-field="website">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Social Media Link <span class="text-muted">(Optional)</span></label>
                                                    <input type="text" class="form-control" placeholder="https://instagram.com/yourstore" data-field="social">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Support Email <span class="text-muted">(Optional, defaults to your seller email)</span></label>
                                                    <input type="email" class="form-control" placeholder="Support Email" autocomplete="new-password" data-field="supportemail">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group mb-0">
                                                    <label class="form-label">Support Phone <span class="text-muted">(Optional)</span></label>
                                                    <input type="number" class="form-control" placeholder="Support Phone" data-field="supportphone">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </section>
                                            <h3>Verification &amp; Agreement</h3>
                                            <section>
                                                <h5 class="mb-3">Identity</h5>
                                                <div class="control-group form-group">
                                                    <label class="form-label">Government ID Upload</label>
                                                    <input type="file" class="form-control required" accept="image/*,.pdf" data-field="govtid">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group">
                                                    <label class="form-label">PAN / GST <span class="text-muted">(Optional, if targeting India)</span></label>
                                                    <input type="text" class="form-control" placeholder="PAN / GST Number" data-field="pangst">
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                                <h5 class="mb-3 mt-4">Payment</h5>
                                                <div class="control-group form-group">
                                                    <label class="form-label d-block">Preferred Payout Method</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input required" type="radio" name="payoutmethod" id="payoutUpi" value="UPI" data-field="payoutmethod">
                                                        <label class="form-check-label" for="payoutUpi">UPI</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input required" type="radio" name="payoutmethod" id="payoutBank" value="Bank Transfer" data-field="payoutmethod">
                                                        <label class="form-check-label" for="payoutBank">Bank Transfer</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input required" type="radio" name="payoutmethod" id="payoutPaypal" value="PayPal" data-field="payoutmethod">
                                                        <label class="form-check-label" for="payoutPaypal">PayPal <span class="text-muted">(Future)</span></label>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group mb-0">
                                                    <label class="form-label">UPI ID / Bank Details</label>
                                                    <input type="text" class="form-control required" placeholder="UPI ID or Bank Account Details" data-field="payoutdetails">
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                                <h5 class="mb-3 mt-4">Agreement</h5>
                                                <div class="control-group form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input required" type="checkbox" name="agree_terms" id="agreeTerms" data-field="agree_terms">
                                                        <label class="form-check-label" for="agreeTerms">I agree to the Seller Terms &amp; Conditions.</label>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="control-group form-group mb-0">
                                                    <div class="form-check">
                                                        <input class="form-check-input required" type="checkbox" name="agree_rights" id="agreeRights" data-field="agree_rights">
                                                        <label class="form-check-label" for="agreeRights">I confirm that I own the rights to the products I upload.</label>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/Row -->

                        
                    </div>
                    <!-- CONTAINER CLOSED -->
                </div>
            </div>
            <!--app-content closed-->
        </div>


        <!-- FOOTER -->
        <footer class="footer">
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-md-12 col-sm-12 text-center">
                        Copyright © <span id="year"></span> <a href="javascript:void(0)">FileNest</a>.  <span
                            class="fa fa-heart text-danger"></span> <a href="javascript:void(0)">  </a> All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
        <!-- FOOTER END -->
    </div>

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

  <script>
    function togglePassword(inputId, iconId){
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      if(input.type === 'password'){
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.5 21.5 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 7 11 7a21.5 21.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
      } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/>';
      }
    }
  </script>

</body>
</html>