<html>
<head>
    <style type='text/css'>

        @page {
            size: A4 landscape;
            margin: 0;
        }

        @media print {
            @page {
                size: A4 landscape;
                padding:0.3cm;
            }

            html {
                overflow: hidden;
            }
        }


        body{
            width: 90%;
            overflow: hidden;
            padding: 1cm;
            color: #000;
            font-family: "Arial", sans-serif;
        }

        .header{
            padding-bottom: 30px;
            text-align:left;
        }

        img.logo{
            float:left;
            padding-right: 1rem;
            max-height:100px;
        }

        span{
            display:block;
        }

        span.title{
            font-weight: bold;
            font-size:1.2rem;
        }
        span.alamat, span.telepon{
            font-size:0.8rem;
        }

        .width-50{
            width:50%;
            float:left;
        }

        .both{
            clear:both;
        }

        h4.cetak{
            text-decoration:underline;
        }

        table.status {
            width: 30%;
            margin-top: 20px;
        }

        table.status tr td {
            font-size: 10pt;
            padding: 5px;
            border: solid 1px #808080;
            text-align: left;
        }

        table.data {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        tr td.gray{
            background-color:#F2F2F2;
        }

        table.table tr td, table.table tr th{
            padding:0.3rem;
            font-size: 9pt !important;
        }

        table.table thead tr th {
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }

        .text-left{
            text-align:left;
        }
        .text-center{
            text-align:center;
        }
        .text-right{
            text-align:right;
        }

        .isian{
            font-size: 1.2rem;
        }

        td.noborder-right{
            border-right:0 !important;
        }
        td.noborder-left{
            border-left:0 !important;
        }

        div.footer{
            page-break-after: always;
        }

        .row {
            position: relative;
            width: 100%;
        }

        .row div {
            float: left;
        }

        .number_style {
            text-align: right !important;
        }

        .col-4 {
            width: 33.33%;
        }
    </style>

</head>
<body>
<div class="header">
    <table>
        <tr>
            <td style="text-align:center; width:5%">
                <img class="navbar-brand-icon mb-2" src="<?php echo $_POST['__HOSTNAME__']; ?>/template/assets/images/clients/logo-icon-petala2.png" width="50" alt="<?php echo $_POST['__PC_CUSTOMER__']; ?>">
            </td>
            <td style="width:45%;">
                <span class="title"><b><?php echo $_POST['__PC_CUSTOMER__']; ?></b></span>
                <span class="alamat"><?php echo $_POST['__PC_CUSTOMER_ADDRESS__']; ?></span>
                <span class="telepon">Telp. <?php echo $_POST['__PC_CUSTOMER_CONTACT__']; ?></span>
            </td>
            <td style="width:2%;"></td>
        </tr>
    </table>
    <center>
        <b>
            <br /><br />
            <span><?php echo $_POST['__JUDUL__']; ?></span>
            <small><?php echo date('d F Y', strtotime($_POST['__PERIODE_AWAL__'])); ?> - <?php echo date('d F Y', strtotime($_POST['__PERIODE_AKHIR__'])); ?></small>
        </b>
    </center>
</div>
<div>
    <table class="table border-bottom mb-5 data">
        <thead class="thead-dark">
            <tr>
                <th>Waktu Order</th>
                <th>No. Order</th>
                <th>No. RM</th>
                <th>Pasien</th>
                <th>Poliklinik</th>
                <th>Dokter</th>
                <th>Jenis Pemeriksaan</th>
                <th>Mitra</th>
                <th>Penjamin</th>
            </tr>
        </thead>
        <tbody>
        <?php

        $dataBuild = array();
        // var_dump($_POST['data']);
        foreach ($_POST['data'] as $datKey => $datValue) {
            if(!isset($dataBuild[$datValue['nama_penjamin']])) {
                $dataBuild[$datValue['nama_penjamin']] = array(
                    'nama' => $datValue['nama_penjamin'],
                    'data' => array()
                );
            }
            array_push($dataBuild[$datValue['nama_penjamin']]['data'], $datValue);
        }

        $JumlahInvoice = 0;
        $totalBayar = 0;
        $totalSemua = 0;
        $totalBelumBayar = 0;
        foreach ($dataBuild as $parseKey => $parseValue) {
            foreach ($parseValue['data'] as $itemKey => $itemValue) {
                // $total = $itemValue['total_after_discount'] - (isset($itemValue['payment']) ? $itemValue['payment']['terbayar'] : 0);
                // $totalBayar += $itemValue['payment']['terbayar'];
                // $totalBelumBayar += $total;
                // $JumlahInvoice++;
                // $totalSemua += $itemValue['total_after_discount'];

                ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($itemValue["waktu_order"])); ?></td>
                    <td><?php echo $itemValue["no_order"]; ?></td>
                    <td><?php echo $itemValue["no_rm"]; ?></td>
                    <td><?php echo $itemValue["pasien"]; ?></td>
                    <td><?php echo $itemValue["departemen"]; ?></td>
                    <td><?php echo $itemValue["dokter"]; ?></td>
                    <td><?php echo $itemValue["nama_tindakan"]; ?></td>
                    <td><?php echo $itemValue["nama_mitra"]; ?></td>
                    <td><?php echo $itemValue["nama_penjamin"]; ?></td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
    <hr />
    <!-- <table style="width: 50%">
        <tr>
            <td>Jumlah Invoice</td>
            <td class="number_style">
                <?php echo $JumlahInvoice; ?>
            </td>
        </tr>
        <tr>
            <td>Total Biaya Invoice</td>
            <td class="number_style">
                <?php echo number_format($totalSemua, 2, '.', ','); ?>
            </td>
        </tr>
        <tr>
            <td>Pembayaran Diterima</td>
            <td class="number_style">
                <?php echo number_format($totalBayar, 2, '.', ','); ?>
            </td>
        </tr>
        <tr>
            <td>Pembayaran Belum Diterima</td>
            <td class="number_style">
                <?php echo number_format($totalBelumBayar, 2, '.', ','); ?>
            </td>
        </tr>
    </table> -->
</div>
</body>
</html>