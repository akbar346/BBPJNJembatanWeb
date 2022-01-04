
<!DOCTYPE html>
<html lang="en">
    {setMeta}
    <body class="page-container-bg-solid page-sidebar-closed-hide-logo page-header-fixed page-footer-fixed">
        {setHeader}
        <div class="clearfix"> </div>
        <div class="page-container">
            {setMenu}
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-head">
                        <div class="page-title">
                            <h1>Profile</h1>
                        </div>
                    </div>
                    <ul class="page-breadcrumb breadcrumb"></ul>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-reorder"></i>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="tabbable-custom ">
                                        <ul class="nav nav-tabs ">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab">Overview</a>
                                            </li>
                                            <li>
                                                <a href="#tab_1_3" data-toggle="tab">Akun</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1_1">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <ul class="list-unstyled profile-nav">
                                                            <li>
                                                                <img src="<?= base_url() ?>assets/upload/foto/<?= $this->session->userdata('foto') ?>" style="width: 220px; height: 280px;" class="img-responsive" id="foto_profile" name="foto_profile"/>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="profile-info">
                                                                <h1><?= $this->session->userdata('nama_lengkap') ?></h1>
                                                                <table border="0" style="width: 100%">
                                                                    <tr>
                                                                        <td style="width: 20%">
                                                                            <label class="control-label">NIP</label>
                                                                        </td>
                                                                        <td style="width: 80%">
                                                                            <label class="control-label">: <?= $this->session->userdata('nip') ?></label>                                                        
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <label class="control-label">Email</label>
                                                                        </td>
                                                                        <td>
                                                                            <label class="control-label">: <?= $this->session->userdata('email') ?></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <label class="control-label">No HP</label>
                                                                        </td>
                                                                        <td>
                                                                            <label class="control-label">: <?= $this->session->userdata('no_hp') ?></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <label class="control-label">Satker</label>
                                                                        </td>
                                                                        <td>
                                                                            <label class="control-label">: <?= $this->session->userdata('nama_satker') ?></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <label class="control-label">PPK</label>
                                                                        </td>
                                                                        <td>
                                                                            <label class="control-label">: <?= $this->session->userdata('nama_ppk') ?></label>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                        
                                            </div>
                                            <div class="tab-pane" id="tab_1_3">
                                                <div class="row profile-account">
                                                    <div class="col-md-3">
                                                        <ul class="ver-inline-menu tabbable margin-bottom-10">
                                                            <li class="active">
                                                                <a data-toggle="tab" href="#tab_1-1">
                                                                    <i class="fa fa-cog"></i> Personal info </a>
                                                                <span class="after">
                                                                </span>
                                                            </li>
                                                            <li>
                                                                <a data-toggle="tab" href="#tab_2-2"><i class="fa fa-picture-o"></i> Ubah Foto</a>
                                                            </li>
                                                            <li>
                                                                <a data-toggle="tab" href="#tab_3-3"><i class="fa fa-lock"></i> Ubah Password</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="tab-content">
                                                            <div id="tab_1-1" class="tab-pane active">
                                                                <form role="form" action="#" id="form_ubah_info" name="form_ubah_info">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Nama Lengkap</label>
                                                                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" value="<?= $this->session->userdata('nama_lengkap') ?>" />
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label">No HP</label>
                                                                        <input type="number" id="no_hp" name="no_hp" placeholder="isi dengan No HP" class="form-control" value="<?= $this->session->userdata('no_hp') ?>"/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Email</label>
                                                                        <div class="input-icon right">
                                                                            <i class="fa"></i>
                                                                            <input type="email" id="email" name="email" placeholder="isi dengan Email" class="form-control" value="<?= $this->session->userdata('email') ?>"/>
                                                                        </div>
                                                                    </div> 
                                                                    <div class="margiv-top-10">
                                                                        <button type="submit" class="btn blue">Simpan <span class="glyphicon glyphicon-save"/></button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div id="tab_2-2" class="tab-pane">
                                                                <form action="#" id="form_ubah_foto" role="form" enctype="multipart/form-data">
                                                                    <div class="form-group">
                                                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                            <div class="fileupload-new thumbnail" style="width: 200px; height: 200px;">
                                                                                <input type="hidden" class="form-control"/>
                                                                                <img src="<?= base_url() ?>assets/upload/foto/<?= $this->session->userdata('foto') ?>" class="img-responsive" id="foto_profile_edit" name="foto_profile_edit"/>
                                                                            </div>
                                                                            <div>
                                                                                <span class="btn default btn-file">
                                                                                    <input type="file" id="foto" name="foto" class="default"/>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <span class="label label-danger">NOTE!</span>
                                                                        <span>Extention .jpg|.jpeg|.png</span>
                                                                    </div>
                                                                    <div class="margin-top-10">
                                                                        <button type="submit" class="btn blue" >Simpan <span class="glyphicon glyphicon-save"/></button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div id="tab_3-3" class="tab-pane">
                                                                <form action="#" id="form_ubah_password" name="form_ubah_password">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Password Sekarang</label>
                                                                        <input type="password" class="form-control" id="password_sekarang" name="password_sekarang"/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Password Baru</label>
                                                                        <input type="password" class="form-control" id="password_baru" name="password_baru"/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Re-type Password Baru</label>
                                                                        <input type="password" class="form-control" id="re_password_baru" name="re_password_baru"/>
                                                                    </div>
                                                                    <div class="margin-top-10">
                                                                        <button type="submit" class="btn blue" >Simpan <span class="glyphicon glyphicon-save"/></button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>				    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {setFooter}
        {setJS}
        <script>
            jQuery(document).ready(function () {
                App.init();
                var InitController = function () {
                    var handleUbahPassword = function () {
                        $('#form_ubah_password').validate({
                            errorElement: 'span', //default input error message container
                            errorClass: 'help-block', // default input error message class
                            focusInvalid: true, // do not focus the last invalid input
                            ignore: "",
                            rules: {
                                password_sekarang: {
                                    required: true
                                },
                                password_baru: {
                                    required: true
                                },
                                re_password_baru: {
                                    required: true
                                }
                            },
                            invalidHandler: function (event, validator) { //display error alert on form submit              
                                toastr.error("Maaf, Inputkan data dengan lengkap");
                            },
                            errorPlacement: function (error, element) { // render error placement for each input type
                                var icon = $(element).parent('.input-icon').children('i');
                                icon.removeClass('fa-check').addClass("fa-warning");
                                icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                            },
                            highlight: function (element) { // hightlight error inputs
                                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group   
                            },
                            unhighlight: function (element) { // revert the change done by hightlight
                            },
                            success: function (label, element) {
                                var icon = $(element).parent('.input-icon').children('i');
                                $(element).closest('.form-group').removeClass('has-error');
                                icon.removeClass("fa-warning");
                            },
                            submitHandler: function (form) {
                                $.blockUI();
                                $.ajax({
                                    method: 'POST',
                                    dataType: 'json',
                                    url: '<?= site_url() ?>profil/do_Simpan_Ubah_Password',
                                    data: $('#form_ubah_password').serializeArray(),
                                    success: function (data) {
                                        if (data.success === true) {
                                            $.unblockUI();
                                            toastr.success(data.msgServer);
                                            location.reload();
                                        } else {
                                            $.unblockUI();
                                            toastr.warning(data.msgServer);
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
                    var handleUbahFoto = function () {
                        $('#form_ubah_foto').validate({
                            errorElement: 'span', //default input error message container
                            errorClass: 'help-block', // default input error message class
                            focusInvalid: true, // do not focus the last invalid input
                            ignore: "",
                            rules: {
                                foto: {
                                    required: true
                                }
                            },
                            invalidHandler: function (event, validator) { //display error alert on form submit              
                                toastr.error("Maaf, Inputkan data dengan lengkap");
                            },
                            errorPlacement: function (error, element) { // render error placement for each input type
                                var icon = $(element).parent('.input-icon').children('i');
                                icon.removeClass('fa-check').addClass("fa-warning");
                                icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                            },
                            highlight: function (element) { // hightlight error inputs
                                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group   
                            },
                            unhighlight: function (element) { // revert the change done by hightlight
                            },
                            success: function (label, element) {
                                var icon = $(element).parent('.input-icon').children('i');
                                $(element).closest('.form-group').removeClass('has-error');
                                icon.removeClass("fa-warning");
                            },
                            submitHandler: function (form) {
                                $.blockUI();
                                $.ajax({
                                    url: '<?= site_url() ?>profil/do_Simpan_Ubah_Foto',
                                    type: 'POST',
                                    data: new FormData($('#form_ubah_foto')[0]),
                                    async: true,
                                    success: function (data) {
                                        var data = jQuery.parseJSON(data);
                                        if (data.success === true) {
                                            $.unblockUI();
                                            toastr.success(data.msgServer);
                                            location.reload();
                                        } else {
                                            $.unblockUI();
                                            toastr.warning(data.msgServer);
                                        }
                                    },
                                    contentType: false,
                                    processData: false
                                });
                            }
                        });
                    };
                    var handleUbahInfo = function () {
                        $('#form_ubah_info').validate({
                            errorElement: 'span', //default input error message container
                            errorClass: 'help-block', // default input error message class
                            focusInvalid: true, // do not focus the last invalid input
                            ignore: "",
                            rules: {
                                nama_lengkap: {
                                    required: false
                                },
                                no_hp: {
                                    required: false
                                },
                                email: {
                                    required: false,
                                    email: true
                                }
                            },
                            invalidHandler: function (event, validator) { //display error alert on form submit              
                                toastr.error("Maaf, Inputkan data dengan lengkap");
                            },
                            errorPlacement: function (error, element) { // render error placement for each input type
                                var icon = $(element).parent('.input-icon').children('i');
                                icon.removeClass('fa-check').addClass("fa-warning");
                                icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                            },
                            highlight: function (element) { // hightlight error inputs
                                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group   
                            },
                            unhighlight: function (element) { // revert the change done by hightlight
                            },
                            success: function (label, element) {
                                var icon = $(element).parent('.input-icon').children('i');
                                $(element).closest('.form-group').removeClass('has-error');
                                icon.removeClass("fa-warning");
                            },
                            submitHandler: function (form) {
                                $.blockUI();
                                $.ajax({
                                    method: 'POST',
                                    dataType: 'json',
                                    url: '<?= site_url() ?>profil/do_Simpan_Ubah_Info',
                                    data: $('#form_ubah_info').serializeArray(),
                                    success: function (data) {
                                        if (data.success === true) {
                                            $.unblockUI();
                                            toastr.success(data.msgServer);
                                            location.reload();
                                        } else {
                                            $.unblockUI();
                                            toastr.warning(data.msgServer);
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
                            handleUbahPassword();
                            handleUbahInfo();
                            handleUbahFoto();
                        }
                    };
                }();
                InitController.init();
            });
        </script>
    </body>
</html>