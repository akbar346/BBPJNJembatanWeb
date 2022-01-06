
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
                            <h1>{namaMenu}</h1>
                        </div>
                    </div>
                    <ul class="page-breadcrumb breadcrumb"></ul>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-table"></i>Tabel {namaMenu}
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="tabelku">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%; text-align: center; vertical-align: middle">#</th>
                                                    <th style="text-align: center; vertical-align: middle">NIP Input</th>
                                                    <th style="text-align: center; vertical-align: middle">Nama Input</th>
                                                    <th style="text-align: center; vertical-align: middle">Jabatan Input</th>
                                                    <th style="text-align: center; vertical-align: middle">Kategori</th>
                                                    <th style="text-align: center; vertical-align: middle">Kerusakan</th>
                                                    <th style="text-align: center; vertical-align: middle">Perbaikan</th>
                                                    <th style="text-align: center; vertical-align: middle">Gambar 1 Input</th>
                                                    <th style="text-align: center; vertical-align: middle">Gambar 2 Input</th>
                                                    <th style="text-align: center; vertical-align: middle">Keterangan</th>
                                                    <th style="text-align: center; vertical-align: middle">Tgl Input</th>
                                                    <th style="text-align: center; vertical-align: middle">NIP Proses</th>
                                                    <th style="text-align: center; vertical-align: middle">Nama Proses</th>
                                                    <th style="text-align: center; vertical-align: middle">Jabatan Proses</th>
                                                    <th style="text-align: center; vertical-align: middle">Gambar 1 Proses</th>
                                                    <th style="text-align: center; vertical-align: middle">Gambar 2 Proses</th>
                                                    <th style="text-align: center; vertical-align: middle">Tgl Proses</th>
                                                    <th style="text-align: center; vertical-align: middle">NIP Selesai</th>
                                                    <th style="text-align: center; vertical-align: middle">Nama Selesai</th>
                                                    <th style="text-align: center; vertical-align: middle">Jabatan Selesai</th>
                                                    <th style="text-align: center; vertical-align: middle">Gambar 1 Selesai</th>
                                                    <th style="text-align: center; vertical-align: middle">Gambar 2 Selesai</th>
                                                    <th style="text-align: center; vertical-align: middle">Tgl Selesai</th>
                                                    <th style="text-align: center; vertical-align: middle">Status</th>
                                                    <th style="text-align: center; vertical-align: middle">Tingkat</th>
                                                    <th style="text-align: center; vertical-align: middle">Satker</th>
                                                    <th style="text-align: center; vertical-align: middle">PPK</th>
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
        <script>
            var span = document.getElementById("tt_form");
            
            jQuery(document).ready(function () {
                App.init();
                $('#{parent_id_menu}').addClass('active');
                $('#{id_menu_}').addClass('active');

                var InitController = function () {
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
                            "sAjaxSource": "<?= site_url() ?>kerusakan/do_Tabel_Histori",
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
                                    'aTargets': [0]
                                }
                            ]
                        });
                        jQuery('#tabelku_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
                        jQuery('#tabelku_wrapper .dataTables_length select').addClass("form-control input-small"); // modify table per page dropdown

                    };
                    return {
                        //main function to initiate the module
                        init: function () {
                            handleTable();
                        }
                    };
                }();

                InitController.init();
            });
        </script>
    </body>
</html>