<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo __HOSTNAME__; ?>/">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo __HOSTNAME__; ?>/master/lokasi">Master Lokasi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rute</li>
                </ol>
            </nav>
            <h4><span id="nama-departemen"></span>Master Rute</h4>
        </div>
        <!-- <a href="<?php echo __HOSTNAME__; ?>/master/inventori/gudang/tambah" class="btn btn-info btn-sm ml-3">
			<i class="fa fa-plus"></i> Tambah Gudang
		</a> -->

    </div>
</div>


<div class="container-fluid page__container">
    <div class="row card-group-row">
        <div class="col-lg-12 col-md-12 card-group-row__col">
            <div class="card card-group-row__card card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-large bg-white d-flex align-items-center">
                                <h5 class="card-header__title flex m-0">Master Rute</h5>
                                <button class="btn btn-success" id="btn-import" style="margin: 0 5px">
                                    <i class="fa fa-download"></i> Import
                                </button>
                                <button class="btn btn-sm btn-info" id="tambah-rute">
                                    <i class="fa fa-plus"></i> Tambah
                                </button>
                            </div>
                            <div class="card-body tab-content">
                                <div class="tab-pane active show fade">
                                    <table class="table table-padding largeDataType" id="table-rute">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th class="wrap_content">No</th>
                                            <th class="wrap_content">Aksi</th>
                                            <th style="width: 30%;">Nama</th>
                                            <th>Toko</th>
                                            <th>Sales</th>
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
        </div>
    </div>
</div>