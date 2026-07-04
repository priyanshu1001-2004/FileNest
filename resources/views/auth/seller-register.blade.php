<!doctype html>
<html lang="en" dir="ltr">

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

    <!-- JQUERY JS -->
    <script src="../assets/js/jquery.min.js"></script>
    <script>
        // Fallback: if the local jQuery file above failed to load
        // (wrong path / file not found), load it from a CDN instead.
        if (typeof jQuery === "undefined") {
            document.write('<script src="https://code.jquery.com/jquery-3.7.1.min.js"><\/script>');
        }
    </script>

    <!-- BOOTSTRAP JS -->
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- SIDE-MENU JS-->
    <script src="../assets/plugins/sidemenu/sidemenu.js"></script>

<!-- TypeHead js -->
<script src="../assets/plugins/bootstrap5-typehead/autocomplete.js"></script>
    <script src="../assets/js/typehead.js"></script>

    <!-- SIDEBAR JS -->
    <script src="../assets/plugins/sidebar/sidebar.js"></script>

    <!-- FORM WIZARD JS-->
    <script src="../assets/plugins/formwizard/jquery.smartWizard.js"></script>
    <script src="../assets/plugins/formwizard/fromwizard.js"></script>

    <!-- INTERNAl Jquery.steps js -->
    <script src="../assets/plugins/jquery-steps/jquery.steps.min.js"></script>
    <script src="../assets/plugins/parsleyjs/parsley.min.js"></script>

    <!-- Perfect SCROLLBAR JS-->
    <script src="../assets/plugins/p-scroll/perfect-scrollbar.js"></script>
    <script src="../assets/plugins/p-scroll/pscroll.js"></script>
    <script src="../assets/plugins/p-scroll/pscroll-1.js"></script>

    <!-- INTERNAL Accordion-Wizard-Form js-->
    <script src="../assets/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js"></script>
    <script src="../assets/js/form-wizard.js"></script>

    <!-- FILE UPLOADES JS -->
    <script src="../assets/plugins/fileuploads/js/fileupload.js"></script>
    <script src="../assets/plugins/fileuploads/js/file-upload.js"></script>

    <!-- INTERNAL File-Uploads Js-->
    <script src="../assets/plugins/fancyuploder/jquery.ui.widget.js"></script>
    <script src="../assets/plugins/fancyuploder/jquery.fileupload.js"></script>
    <script src="../assets/plugins/fancyuploder/jquery.iframe-transport.js"></script>
    <script src="../assets/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
    <script src="../assets/plugins/fancyuploder/fancy-uploader.js"></script>

    <!-- Color Theme js -->
    <script src="../assets/js/themeColors.js"></script>

    <!-- Sticky js -->
    <script src="../assets/js/sticky.js"></script>

    <!-- CUSTOM JS -->
    <script src="../assets/js/custom.js"></script>

    <!-- SELLER FORM VALIDATION JS -->
    <script>
    (function ($) {
        "use strict";

        // Human readable "required" messages per field
        function getRequiredMessage(field) {
            switch (field) {
                case "name": return "Please enter your name.";
                case "email": return "Please enter your email.";
                case "phone": return "Please enter your phone number.";
                case "address": return "Please enter your address.";
                case "storename": return "Please enter your store / brand name.";
                case "category": return "Please select a business category.";
                case "username": return "Please enter a seller username.";
                case "govtid": return "Please upload a government ID for verification.";
                case "payoutmethod": return "Please select a preferred payout method.";
                case "payoutdetails": return "Please enter your UPI ID or bank details.";
                case "agree_terms": return "You must agree to the Seller Terms & Conditions.";
                case "agree_rights": return "You must confirm you own the rights to your products.";
                default: return "This field is required.";
            }
        }

        // Validate a single field, returns an error message string or "" if valid
        function getFieldError($input) {
            var field = $input.data("field");
            var type = $input.attr("type");
            var val = ($input.val() || "").toString().trim();
            var isRequired = $input.hasClass("required") || $input.prop("required");

            // Required checks (covers text, select, checkbox, radio, file)
            if (isRequired) {
                if (type === "checkbox" || type === "radio") {
                    var name = $input.attr("name");
                    var checked = name ? $input.closest("form,section,body").find('input[name="' + name + '"]:checked').length > 0 : $input.prop("checked");
                    if (!checked) {
                        return getRequiredMessage(field) || "Please select an option.";
                    }
                } else if (type === "file") {
                    if (!$input.val()) {
                        return getRequiredMessage(field) || "Please select a file.";
                    }
                } else if ($input.is("select")) {
                    if (val === "") {
                        return getRequiredMessage(field) || "Please select an option.";
                    }
                } else if (val === "") {
                    return getRequiredMessage(field);
                }
            }

            if (val === "") {
                return "";
            }

            // Format specific validations
            if (field === "email" || type === "email") {
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(val)) {
                    return "Please enter a valid email address.";
                }
            }

            if (field === "phone") {
                if (!/^\d{10}$/.test(val.replace(/\D/g, ""))) {
                    return "Please enter a valid 10-digit phone number.";
                }
            }

            if (field === "username") {
                if (!/^[a-zA-Z0-9_]{3,20}$/.test(val)) {
                    return "Username should be 3-20 characters (letters, numbers, underscore only).";
                }
            }

            if (field === "website" || field === "social") {
                var urlPattern = /^(https?:\/\/)?[^\s]+\.[^\s]{2,}$/;
                if (!urlPattern.test(val)) {
                    return "Please enter a valid URL.";
                }
            }

            if (field === "supportemail") {
                var supportEmailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!supportEmailPattern.test(val)) {
                    return "Please enter a valid support email.";
                }
            }

            if (field === "supportphone") {
                if (!/^\d{10}$/.test(val.replace(/\D/g, ""))) {
                    return "Please enter a valid 10-digit phone number.";
                }
            }

            return "";
        }

        function showFieldError($input, message) {
            $input.addClass("is-invalid");
            var $feedback = $input.nextAll(".invalid-feedback").first();
            if (!$feedback.length) {
                $feedback = $input.closest(".input-group, .control-group, .form-group").find(".invalid-feedback").first();
            }
            $feedback.text(message);
        }

        function clearFieldError($input) {
            $input.removeClass("is-invalid");
            var $feedback = $input.nextAll(".invalid-feedback").first();
            if (!$feedback.length) {
                $feedback = $input.closest(".input-group, .control-group, .form-group").find(".invalid-feedback").first();
            }
            $feedback.text("");
        }

        function validateAndMark($input) {
            var message = getFieldError($input);
            if (message) {
                showFieldError($input, message);
                return false;
            }
            clearFieldError($input);
            return true;
        }

        function validateSection($section) {
            var valid = true;
            $section.find(".required, [required]").each(function () {
                var $input = $(this);
                if (!validateAndMark($input)) {
                    valid = false;
                }
            });
            return valid;
        }

        $(function () {
            // Live clear/validate as the user types or changes a field
            $("#wizard1").on("input change blur", ".required, [required]", function () {
                validateAndMark($(this));
            });
        });

        // We track the active step ourselves instead of guessing the wizard
        // plugin's internal markup (href="#next", ".current" class, etc.),
        // since that varies between wizard libraries and was not matching.
        var $wizardSections = $("#wizard1 > section");
        var currentStepIndex = 0;

        function isWizardControl($el) {
            if (!$el || !$el.length) return false;
            if ($el.closest("#wizard1").length > 0) return true;
            var $card = $el.closest(".card");
            return $card.length > 0 && $card.find("#wizard1").length > 0;
        }

        function getButtonLabel($el) {
            return $el.text().replace(/\s+/g, " ").trim().toLowerCase();
        }

        // Intercept clicks on Next / Finish controls (identified by their
        // visible text, regardless of tag, href, or class) before the
        // wizard plugin's own handler runs, using the capture phase.
        document.addEventListener("click", function (e) {
            var $origin = $(e.target);
            var $clickable = $origin.closest('a, button, li, [role="menuitem"], [role="button"]');
            if (!$clickable.length) {
                return;
            }
            if (!isWizardControl($clickable)) {
                return;
            }

            var label = getButtonLabel($clickable);
            console.log("[wizard-validation] clicked:", $clickable.prop("tagName"), "| label:", label, "| step:", currentStepIndex);

            var isNext = label.indexOf("next") !== -1;
            var isFinish = label.indexOf("finish") !== -1 || label.indexOf("submit") !== -1;
            var isPrev = label.indexOf("previous") !== -1 || label.indexOf("prev") !== -1 || label.indexOf("back") !== -1;

            if (isNext || isFinish) {
                var ok = validateSection($wizardSections.eq(currentStepIndex));
                console.log("[wizard-validation] step valid?", ok);
                if (!ok) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    e.stopPropagation();
                    return false;
                }
                if (isNext && currentStepIndex < $wizardSections.length - 1) {
                    currentStepIndex++;
                }
            } else if (isPrev) {
                if (currentStepIndex > 0) {
                    currentStepIndex--;
                }
            }
        }, true);

    })(jQuery);
    </script>

</body>
</html>