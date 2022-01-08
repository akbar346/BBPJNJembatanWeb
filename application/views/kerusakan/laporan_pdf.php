<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title_pdf;?></title>
        <style>
            #table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #table td, #table th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #table tr:nth-child(even){background-color: #f2f2f2;}

            #table tr:hover {background-color: #ddd;}

            #table th {
                padding-top: 10px;
                padding-bottom: 10px;
                text-align: left;
                background-color: #4CAF50;
                color: white;
                font-size: 10px;
            }

            #table td {
                font-size: 10px;
            }
        </style>
    </head>
    <body>
        <div style="text-align:center">
            <h3><?= $title_pdf;?></h3>
        </div>
        <table id="table">
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center; vertical-align: middle">#</th>
                    <th style="text-align: center; vertical-align: middle">Kategori</th>
                    <th style="text-align: center; vertical-align: middle">Kerusakan</th>
                    <th style="text-align: center; vertical-align: middle">Perbaikan</th>
                    <th style="text-align: center; vertical-align: middle">Keterangan</th>
                    <th style="text-align: center; vertical-align: middle">NIP Input</th>
                    <th style="text-align: center; vertical-align: middle">Tgl Input</th>
                    <th style="text-align: center; vertical-align: middle">NIP Proses</th>
                    <th style="text-align: center; vertical-align: middle">Tgl Proses</th>
                    <th style="text-align: center; vertical-align: middle">NIP Selesai</th>
                    <th style="text-align: center; vertical-align: middle">Tgl Selesai</th>
                    <th style="text-align: center; vertical-align: middle">Status</th>
                    <th style="text-align: center; vertical-align: middle">Tingkat</th>
                    <th style="text-align: center; vertical-align: middle">Satker</th>
                    <th style="text-align: center; vertical-align: middle">PPK</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    foreach($hasil->result() as $r){
                ?>
                <tr>
                    <td style="width: 5%; text-align: center; vertical-align: middle"><?= $no++ ?></td>
                    <td><?= $r->nama_kategori ?></td>
                    <td><?= $r->nama_kerusakan ?></td>
                    <td><?= $r->ket_perbaikan ?></td>
                    <td><?= $r->detail_kerusakan ?></td>
                    <td><?= $r->nip_input ?></td>
                    <td><?= date_format(date_create($r->tgl_pengecekan),"d/m/Y H:i") ?></td>
                    <td><?= $r->nip_proses ?></td>
                    <td><?= date_format(date_create($r->tgl_proses),"d/m/Y H:i") ?></td>
                    <td><?= $r->nip_selesai ?></td>
                    <td><?= date_format(date_create($r->tgl_selesai),"d/m/Y H:i") ?></td>
                    <td><?= $r->nama_status ?></td>
                    <td><?= $r->nama_tingkat ?></td>
                    <td><?= $r->nama_satker ?></td>
                    <td><?= $r->nama_ppk ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>