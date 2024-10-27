<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo __HOSTNAME__; ?>/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Order</li>
                </ol>
            </nav>
            <h1 class="m-0">List Order</h1>
        </div>
    </div>
</div>


<div class="container-fluid page__container">
    <div class="row card-group-row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-white">
                    <h5 class="card-header__title flex m-0">Order</h5>
                </div>
                <div class="card-header">
                    <button class="btn btn-info pull-right">
                        <i class="fa fa-print"></i> Cetak Laporan
                    </button>
                    <a style="width: 200px;">
                        <button class="btn btn-info" id="btn-import">
                            <i class="fa fa-download"></i> Import
                        </button>
                    </a>
                </div>
                <div class="card-body">
                    <div class="tab-pane active show fade" id="order-modul">
                        <table class="table table-bordered table-striped" id="table-order">
                            <thead class="thead-dark">
                            <tr>
                                <th class="wrap_content">Aksi</th>
                                <th class="wrap_content">No</th>
                                <th class="wrap_content">Tgl</th>
                                <th>Toko</th>
                                <th class="wrap_content">Rute</th>
                                <th class="wrap_content">Sales</th>
                                <th class="wrap_content">Divisi</th>
                                <th class="wrap_content">Jlh Item</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>