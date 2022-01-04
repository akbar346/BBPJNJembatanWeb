<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Login | Aplikasi Pelaporan Perbaikan Jembatan BBPJN VIII</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link href="<?= base_url() ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?= base_url() ?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>assets/pages/css/login-3.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>assets/layouts/layout/css/custom.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= base_url() ?>assets/global/plugins/bootstrap-toastr/toastr.min.css"/>
        <link rel="shortcut icon" href="<?= base_url() ?>assets/global/img/logo.png" /> 
    </head>

    <body class=" login">
        <div id="panel">
            <div class="logo">
                <img src="<?= base_url() ?>assets/global/img/logo_app.png" alt="" width="250px" />
            </div>
            <div class="content">
                <form class="login-form" action="#" method="post" id="form-login">
                    <h3 class="form-title" style="text-align: center"><b>Login</b></h3>
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span> Enter any nip and password. </span>
                    </div>
                    <div class="form-group">
                        <label class="control-label visible-ie8 visible-ie9">NIP</label>
                        <div class="input-icon">
                            <i class="fa fa-user"></i>
                            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="NIP" name="nip" id="nip" /> </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label visible-ie8 visible-ie9">Password</label>
                        <div class="input-icon">
                            <i class="fa fa-lock"></i>
                            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="passwd" id="passwd" /> </div>
                    </div>
                    <div class="form-actions">
                        <label class="checkbox"></label>
                        <button type="submit" class="btn green pull-right"><i class="fa fa-sign-in"></i> Login </button>
                    </div>
                </form>
            </div>
            <div class="copyright" style="color: black"> 2021 &copy; Aplikasi Pelaporan Perbaikan Jembatan BBPJN VIII. </div>
        </div>
        <script src="<?= base_url() ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/global/plugins/bootstrap-toastr/toastr.min.js"></script> 
        <script src="<?= base_url() ?>assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script>
            jQuery(document).ready(function () {
                var Login = function () {
                    var handleLogin = function () {
                        $('#form-login').validate({
                            errorElement: 'span', //default input error message container
                            errorClass: 'help-block', // default input error message class
                            focusInvalid: false, // do not focus the last invalid input
                            rules: {
                                nip: {
                                    required: true
                                },
                                passwd: {
                                    required: true
                                }
                            },
                            messages: {
                                nip: {
                                    required: "<b>NIP Harus diisi.</b>"
                                },
                                passwd: {
                                    required: "<b>Password Harus diisi.</b>"
                                }
                            },
                            highlight: function (element) { // hightlight error inputs
                                $(element)
                                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                            },
                            success: function (label) {
                                label.closest('.form-group').removeClass('has-error');
                                label.remove();
                            },
                            errorPlacement: function (error, element) {
                                error.insertAfter(element.closest('.input-icon'));
                            },
                            submitHandler: function (form) {
                                $.blockUI();
                                $.ajax({
                                    method: 'POST',
                                    dataType: 'json',
                                    url: '<?= site_url() ?>login/do_login',
                                    data: $('#form-login').serializeArray(),
                                    success: function (data) {
                                        $.unblockUI();
                                        if (data.success === true) {
                                            window.location.href = "<?= site_url() ?>" + data.page;
                                        } else {
                                            toastr.error(data.msgServer);
                                        }
                                    },
                                    fail: function (e) {
                                        $.unblockUI();
                                        toastr.error(e);
                                    }
                                });
                            }
                        });
                    };

                    return {
                        //main function to initiate the module
                        init: function () {
                            handleLogin();
                        }
                    };
                }();

                Login.init();
            });
        </script>
    </body>

</html>
