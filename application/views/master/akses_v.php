<!DOCTYPE html>
<html lang="en">
    {setMeta}
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
    <body class="page-container-bg-solid page-sidebar-closed-hide-logo page-header-fixed page-footer-fixed">
        {setHeader}
        <div class="clearfix"> </div>
        <div class="page-container">
            {setMenu}
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-head">
                        <div class="page-title">
                            <h1>Master {namaMenu}</h1>
                        </div>
                    </div>
                    <ul class="page-breadcrumb breadcrumb"></ul>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-table"></i>Form Data {namaMenu}
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <form action="#" id="formku" name="formku" class="form-horizontal"> 
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">                                                            
                                                            Jabatan <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-8" style="z-index: 0">  
                                                            <input type="hidden" id="id_menu_user" name="id_menu_user"/>
                                                            <input type="hidden" id="mode_form" name="mode_form" value="Tambah"/>
                                                            {id_jabatan}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2">Menu <span class="required">*</span></label>
                                                        <div class="col-md-8">   
                                                            {id_menu}							    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <hr>
                                        <div class="form-actions fluid">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="col-md-offset-4 col-md-9">
                                                        <button type="submit" class="btn blue" id="simpan">Simpan <span class="glyphicon glyphicon-save"/></button>
                                                        <button type="button" class="btn red" id="clear">Clear <span class="glyphicon glyphicon-refresh"/></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-table"></i>Tabel Data {namaMenu}
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table">
                                        <table class="table table-striped table-bordered table-hover" id="tabelku">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%; text-align: center; vertical-align: middle"> # </th>
                                                    <th style="width: 30%; text-align: center; vertical-align: middle"> Nama Menu </th>
                                                    <th style="text-align: center; vertical-align: middle"> Nama Jabatan </th>
                                                    <th style="width: 20%; text-align: center; vertical-align: middle">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
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
        <script type="text/javascript" src="<?= base_url() ?>assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/global/plugins/jquery-multi-select/js/jquery.quicksearch.js"></script>
        <script>
            jQuery(document).ready(function () {
                App.init();
                $('#{parent_id_menu}').addClass('active');
                $('#{id_menu_}').addClass('active');

                var InitController = function () {
                    var handleValidation = function () {
                        $('#id_menu').multiSelect({
                            selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                            selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                            afterInit: function (ms) {
                                var that = this,
                                        $selectableSearch = that.$selectableUl.prev(),
                                        $selectionSearch = that.$selectionUl.prev(),
                                        selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                                        selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                                        .on('keydown', function (e) {
                                            if (e.which === 40) {
                                                that.$selectableUl.focus();
                                                return false;
                                            }
                                        });

                                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                                        .on('keydown', function (e) {
                                            if (e.which == 40) {
                                                that.$selectionUl.focus();
                                                return false;
                                            }
                                        });
                            },
                            afterSelect: function () {
                                this.qs1.cache();
                                this.qs2.cache();
                            },
                            afterDeselect: function () {
                                this.qs1.cache();
                                this.qs2.cache();
                            }
                        });

                        $('#formku').validate({
                            errorElement: 'span', //default input error message container
                            errorClass: 'help-block', // default input error message class
                            focusInvalid: true, // do not focus the last invalid input
                            ignore: "",
                            rules: {
                                id_jabatan: {
                                    required: true
                                },
                                id_menu: {
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
                                id_menux = [];
                                $("#id_menu option:selected").each(function () {
                                    if ($(this).val() != "") {
                                        id_menux.push($(this).val());
                                    }
                                });

                                var dataArray = $('#formku').serializeArray();
                                dataArray.push({name: 'id_menu', value: id_menux});

                                $.ajax({
                                    method: 'POST',
                                    dataType: 'json',
                                    url: '<?= site_url() ?>master/do_Simpan_Akses',
                                    data: dataArray,
                                    success: function (data) {
                                        if (data.success === true) {
                                            toastr.success(data.msgServer);
                                            handleClearForm();
                                            $('#tabelku').dataTable().fnClearTable();
                                        } else {
                                            toastr.warning(data.msgServer);
                                        }
                                    },
                                    fail: function (e) {
                                        toastr.error(e);
                                    }
                                });
                            }
                        });
                    };
                    var handleTable = function () {
                        if (!jQuery().dataTable) {
                            return;
                        }
                        // begin first table
                        $('#tabelku').dataTable({
                            "sDom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", //default layout without horizontal scroll(remove this setting to enable horizontal scroll for the table)
                            "aLengthMenu": [
                                [10, 20, 30, 40, -1],
                                [10, 20, 30, 40, "All"] // change per page values here
                            ],
                            "bProcessing": true,
                            "bServerSide": true,
                            "sServerMethod": "POST",
                            "bRetrieve": true,
                            "sAjaxSource": "<?= site_url() ?>master/do_Tabel_Akses",
                            // set the initial value
                            "iDisplayLength": 10,
                            "sPaginationType": "bootstrap_full_number",
                            "oLanguage": {
                                "sProcessing": '<i class="fa fa-coffee"></i>&nbsp;Please wait...',
                                "sLengthMenu": "_MENU_ records",
                                "oPaginate": {
                                    "sPrevious": "Prev",
                                    "sNext": "Next"
                                }
                            },
                            "aoColumnDefs": [{
                                    'bSortable': false,
                                    'aTargets': [0, 3]
                                }
                            ]
                        });
                        jQuery('#tabelku_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
                        jQuery('#tabelku_wrapper .dataTables_length select').addClass("form-control input-small"); // modify table per page dropdown

                        // handle record edit/remove
                        $('body').on('click', '#tabelku_wrapper .btn-editable', function () {
                            $.ajax({
                                method: 'POST',
                                dataType: 'json',
                                url: '<?= site_url() ?>master/do_Ubah_Akses',
                                data: {'id_rekening': $(this).attr("data-id")},
                                success: function (data) {
                                    if (data.success === true) {
                                        $('#mode_form').val(data.results.mode_form);
                                        $('#id_rekening').val(data.results.id_rekening);
                                        $('#akses_rekening').val(data.results.akses_rekening);
                                        $('#uraian').val(data.results.uraian);
                                        $('#tambah').modal('show');
                                    } else {
                                        toastr.warning(data.msgServer);
                                    }
                                },
                                fail: function (e) {
                                    toastr.error(e);
                                }
                            });
                        });

                        $('body').on('click', '#tabelku_wrapper .btn-removable', function () {
                            var id = $(this).attr("data-id");
                            var name = $(this).attr("data-name");
                            bootbox.dialog({
                                message: "Apakah anda yakin menghapus </br>Akses Menu : <b>" + name + "</b> ?",
                                title: "Konfirmasi Hapus",
                                buttons: {
                                    success: {
                                        label: "Ya",
                                        className: "green",
                                        callback: function () {
                                            $.ajax({
                                                method: 'POST',
                                                dataType: 'json',
                                                url: '<?= site_url() ?>master/do_Hapus_Akses',
                                                data: {'id_menu_user': id},
                                                success: function (data) {
                                                    if (data.success === true) {
                                                        toastr.success(data.msgServer);
                                                        $('#tabelku').dataTable().fnClearTable();
                                                    } else {
                                                        toastr.warning(data.msgServer);
                                                    }
                                                },
                                                fail: function (e) {
                                                    toastr.error(e);
                                                }
                                            });
                                        }
                                    },
                                    danger: {
                                        label: "Tidak",
                                        className: "red"
                                    }
                                }
                            });
                        });
                    };
                    return {
                        //main function to initiate the module
                        init: function () {
                            handleValidation();
                            handleTable();
                        }
                    };
                }();

                InitController.init();
            });
            $('#clear').on('click', function () {
                handleClearForm();
                $('#tambah').modal('hide');
            });

            $('#tambah').on('click', function () {
                handleClearForm();
            });

            function handleClearForm() {
                $('#formku').each(function () {
                    this.reset();
                });
                $('#mode_form').val('Tambah');
                $('#id_jabatan').select2("val", "");
                $('#id_menu').multiSelect('deselect_all');
            }
        </script>
    </body>
</html>
