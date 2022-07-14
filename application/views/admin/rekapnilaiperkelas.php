<!DOCTYPE html>
<html lang="en">
<?php error_reporting(E_ERROR | E_PARSE); ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Nilai Perkelas</title>
    <style type="text/css">
        .table-bordered {
        border: 1px solid #f4f4f4;
        border-collapse: collapse;
        }
        .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h3>Rekap Nilai Siswa Kelas <?= $kelas->kelasnama ?></h3>
    <h4>Mata Pelajaran <?= $mapel->mapelnama ?></h4>
    <table class="table table-bordered table-striped" >
        <thead class="bg-red">
            <tr>
                <th style="width: 40px" rowspan="2">#</th>
                <th rowspan="2">Nama Siswa</th>
                <th colspan="2">Nilai</th>
            </tr>
            <tr>
                <td>Angka</td>
                <td>Huruf</td>
            </tr>
        </thead>
        <tbody id="datanilai">
            <?php 
            $no=0;
            foreach ($nilai as $n ) {
                $no++;
                ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $n->siswanama ?></td>
                    <td><?= $n->nilaiangka ?></td>
                    <td><?= $n->nilaihuruf ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right;" id="tombol">
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>