
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
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                    <ul class="page-breadcrumb breadcrumb"></ul>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat blue">
                                <div class="visual">
                                    <i class="fa fa-comments"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span><?= number_format($jmlUser) ?></span>
                                    </div>
                                    <div class="desc"> Jumlah Petugas </div>
                                </div>
                                <a class="more" href="javascript:;"></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat red">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span><?= number_format($jmlSatker) ?></span>
                                    </div>
                                    <div class="desc"> Jumlah Satker </div>
                                </div>
                                <a class="more" href="javascript:;"></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat green">
                                <div class="visual">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span><?= number_format($jmlPpk) ?></span>
                                    </div>
                                    <div class="desc"> Jumlah PPK </div>
                                </div>
                                <a class="more" href="javascript:;"></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat purple">
                                <div class="visual">
                                    <i class="fa fa-globe"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                    <span><?= number_format($jmlData) ?></span>
                                    </div>
                                    <div class="desc"> Jumlah Laporan Tahun <?= date('Y') ?> </div>
                                </div>
                                <a class="more" href="javascript:;"></a>
                            </div>
                        </div>
                    </div>
                    <div class="row widget-row">
                        <div class="col-md-3">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                                <h4 class="widget-thumb-heading">Kategori Kerusakan</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-green icon-bulb"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-body-stat"><?= number_format($kategori) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                                <h4 class="widget-thumb-heading">Metode Perbaikan</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-red icon-layers"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-body-stat"><?= number_format($perbaikan) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                                <h4 class="widget-thumb-heading">Tingkat Kerusakan</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-body-stat"><?= number_format($tingkat) ?></span>
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
                $('#{parent_id_menu}').addClass('active');
                $('#{id_menu_}').addClass('active');
            });
        </script>
    </body>
</html>