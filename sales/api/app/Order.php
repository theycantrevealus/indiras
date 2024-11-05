<?php

namespace PondokCoder;

use PondokCoder\Query as Query;
use PondokCoder\QueryException as QueryException;
use PondokCoder\Utility as Utility;
use PondokCoder\Authorization as Authorization;
use PondokCoder\Lantai as Lantai;
use PondokCoder\Ruangan as Ruangan;
use \Shuchkin;

class Order extends Utility {
    static $pdo;
    static $query;

    protected static function getConn(){
        return self::$pdo;
    }

    public function __construct($connection){
        self::$pdo = $connection;
        self::$query = new Query(self::$pdo);
    }


    public function __GET__($parameter = array()) {
        try {
            switch($parameter[1]) {
//                case 'get_all_order':
//                    return self::get_toko('master_toko');
//                    break;
                case 'order_detail':
                    return self::order_detail($parameter);
                    break;
                case 'sales_history':
                    return self::sales_history($parameter);
                    break;
                default:
                    # code...
                    break;
            }
        } catch (QueryException $e) {
            return 'Error => '. $e;
        }
    }

    public function __POST__($parameter = array()) {
        switch ($parameter['request']) {
            case 'tambah_order':
                return self::tambah_order($parameter);
                break;

            case 'get_order_backend':
                return self::get_order($parameter);
                break;

            case 'order_done':
                return self::update_status($parameter);
                break;

            case 'order_cancel':
                return self::update_status($parameter);
                break;

            case 'order_pending':
                return self::update_status($parameter);
                break;

            case 'order_export':
                return self::order_export($parameter);
                break;

            default:
                # code...
                break;
        }
    }

    public function __DELETE__($parameter = array()) {
        return self::delete_toko('master_toko', $parameter);
    }


    /*====================== GET FUNCTION =====================*/
    private function sales_history($parameter)
    {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);
        $params = $parameter[count($parameter) - 2];

        if((isset($params['from']) && isset($params['to'])) && (isset($params['toko']))) {
            $paramKey = array(
                'order_sales.deleted_at' => 'IS NULL',
                'AND',
                '(order_sales.tanggal' => 'BETWEEN ? AND ?)',
                'AND',
                'order_sales.toko' => '= ?'
            );
            $paramValue = array($params['from'], $params['to'], intval($params['toko']));
        } else {
            if(isset($params['from']) && isset($params['to'])) {
                $paramKey = array(
                    'order_sales.deleted_at' => 'IS NULL',
                    'AND',
                    'order_sales.created_at' => 'BETWEEN ? AND ?',
                );
                $paramValue = array($params['from'], $params['to']);

            } else if(isset($params['toko'])) {
                $paramKey = array(
                    'order_sales.deleted_at' => 'IS NULL',
                    'AND',
                    'order_sales.toko' => '= ?'
                );
                $paramValue = array(intval($params['toko']));
            } else {
                $paramKey = array(
                    'order_sales.deleted_at' => 'IS NULL'
                );
                $paramValue = array();
            }
        }

        $DataMeta = array();
        $DivisiMeta = array();

        $data = self::$query->select('order_detail', array(
            'qty', 'remark', 'type', 'item'
        ))
            ->join('order_sales', array(
                'kode as kode_order',
            ))
            ->join('master_inv', array(
                'kode_barang',
                'nama as nama_barang',
                'supplier as divisi'
            ))
            ->join('master_inv_supplier', array(
                'kode as kode_divisi',
                'nama as nama_divisi'
            ))
            ->on(array(
                array('order_detail.order_sales', '=', 'order_sales.id'),
                array('order_detail.item', '=', 'master_inv.uid'),
                array('master_inv.supplier', '=', 'master_inv_supplier.uid')
            ))
            ->where($paramKey, $paramValue)
            ->execute();
        foreach ($data['response_data'] as $key => $value) {
            $data['response_data'][$key]['qty'] = intval($value['qty']);
            $satuanMeta = array(
                'nama_satuan_besar' => '',
                'nama_satuan_tengah' => '',
                'nama_satuan_kecil' => '',
                'qty_satuan_besar' => 0,
                'qty_satuan_tengah' => 0,
                'qty_satuan_kecil' => 0
            );
            $satuan = self::$query->select('master_inv_satuan_detail', array(
                'nilai', 'type'
            ))
                ->join('master_inv_satuan', array(
                    'nama'
                ))
                ->on(array(
                    array('master_inv_satuan_detail.satuan', '=', 'master_inv_satuan.uid')
                ))
                ->where(array(
                    'master_inv_satuan_detail.item' => '= ?'
                ), array(
                    $value['item']
                ))
                ->execute();
            foreach ($satuan['response_data'] as $SKey => $SValue) {
                $satuanMeta['nama_satuan_' . $SValue['type']] = $SValue['nama'];
            }
            $data['response_data'][$key]['satuan'] = $satuanMeta;


//            $check = array_search($value['item'], array_column($DataMeta, 'item'));
//            if($check === false) {
//                array_push($DataMeta, array(
//                    'item' =>$value['item'],
//                    'data' => array()
//                ));
//            }


            if(!isset($DataMeta[$value['item']])) {
                $DataMeta[$value['item']] = array();
            }

            $DataMeta[$value['item']]['kode_barang'] = $value['kode_barang'];
            $DataMeta[$value['item']]['nama_barang'] = $value['nama_barang'];
            $DataMeta[$value['item']]['nama_satuan_besar'] = $satuanMeta['nama_satuan_besar'];
            $DataMeta[$value['item']]['nama_satuan_tengah'] = $satuanMeta['nama_satuan_tengah'];
            $DataMeta[$value['item']]['nama_satuan_kecil'] = $satuanMeta['nama_satuan_kecil'];
            $DataMeta[$value['item']]['qty_satuan_' . $value['type']] = floatval($value['qty']);
            $DataMeta[$value['item']]['divisi'] = $value['nama_divisi'];
            $DataMeta[$value['item']]['divisi_id'] = $value['divisi'];


            if(!isset($DivisiMeta[$value['divisi']])) {
                $DivisiMeta[$value['divisi']] = array(
                    'nama' => $value['nama_divisi'],
                    'data' => array()
                );
            }
        }

        foreach ($DataMeta as $DK => $DV) {
            array_push($DivisiMeta[$DV['divisi_id']]['data'], $DV);
        }

        $endResult = array();

        if(intval($params['divisi_group']) > 0) {
            foreach ($DivisiMeta as $item => $ev) {
                $endResult[] = $ev;
            }
        } else {
            foreach ($DataMeta as $item => $ev) {
                $endResult[] = $ev;
            }
        }

//        return (array) $endResult;
        return $data;

    }
    private function order_detail($parameter)
    {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);
        $params = $parameter[2];
        $data = self::$query->select('order_sales', array(
            'id',
            'kode',
            'toko',
            'supplier',
            'sales',
            'tanggal',
            'status',
            'pegawai_done',
            'pegawai_pending',
            'pegawai_cancel',
            'metode_bayar',
            'remark',
            'created_at',
            'updated_at'
        ))
            ->join('master_toko', array(
                'nama as toko_nama', 'alamat'
            ))
            ->join('pegawai', array(
                'nama as sales_nama'
            ))
            ->join('master_inv_supplier', array(
                'nama as divisi_nama'
            ))
            ->join('master_rute', array(
                'nama as rute_nama'
            ))
            ->join('master_wilayah_provinsi',array('nama as alamat_provinsi'))
            ->join('master_wilayah_kabupaten',array('nama as alamat_kabupaten'))
            ->join('master_wilayah_kecamatan',array('nama as alamat_kecamatan'))
            ->join('master_wilayah_kelurahan',array('nama as alamat_kelurahan'))
            ->on(array(
                array('order_sales.toko', '=', 'master_toko.id'),
                array('order_sales.sales', '=', 'pegawai.uid'),
                array('order_sales.supplier', '=', 'master_inv_supplier.uid'),
                array('order_sales.rute', '=', 'master_rute.id'),
                array('master_toko.provinsi', '=', 'master_wilayah_provinsi.id'),
                array('master_toko.kabupaten', '=', 'master_wilayah_kabupaten.id'),
                array('master_toko.kecamatan', '=', 'master_wilayah_kecamatan.id'),
                array('master_toko.kelurahan', '=', 'master_wilayah_kelurahan.id'),
            ))
            ->order(array(
                'order_sales.updated_at' => 'DESC'
            ))
            ->where(array(
                'order_sales.id' => '= ?'
            ), array(
                $params
            ))
            ->execute();
        foreach ($data['response_data'] as $key => $value) {
            if($value['pegawai_cancel'] !== null) {
                $data['response_data'][$key]['pegawai_cancel'] = self::$query->select('pegawai', array(
                    'nama'
                ))
                    ->where(array(
                        'pegawai.uid' => '= ?'
                    ), array(
                        $value['pegawai_cancel']
                    ))
                    ->execute()['response_data'][0];
            }

            if($value['pegawai_pending'] !== null) {
                $data['response_data'][$key]['pegawai_pending'] = self::$query->select('pegawai', array(
                    'nama'
                ))
                    ->where(array(
                        'pegawai.uid' => '= ?'
                    ), array(
                        $value['pegawai_pending']
                    ))
                    ->execute()['response_data'][0];
            }

            if($value['pegawai_done'] !== null) {
                $data['response_data'][$key]['pegawai_done'] = self::$query->select('pegawai', array(
                    'nama'
                ))
                    ->where(array(
                        'pegawai.uid' => '= ?'
                    ), array(
                        $value['pegawai_done']
                    ))
                    ->execute()['response_data'][0];
            }

            $data['response_data'][$key]['tanggal'] = Utility::dateToIndo($value['tanggal']);

            $data['response_data'][$key]['detail'] = self::$query->select('order_detail', array(
                'type', 'qty', 'item'
            ))
                ->join('master_inv', array(
                    'nama as nama_barang'
                ))
                ->join('master_inv_satuan', array(
                    'nama as nama_satuan'
                ))
                ->on(array(
                    array('order_detail.item', '=', 'master_inv.uid'),
                    array('order_detail.satuan', '=', 'master_inv_satuan.uid')
                ))
                ->where(array(
                    'order_detail.order_sales' => '= ?'
                ), array(
                    $value['id']
                ))
                ->execute()['response_data'];
        }
        return $data['response_data'][0];
    }

    private function update_status($parameter) {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);

        if($UserData['data']->jabatan === __UIDHQ__ || $UserData['data']->jabatan === __UIDADMIN__) {
            if(intval($parameter['status']) === 1) {
                $paramData = array(
                    'status' => intval($parameter['status']),
                    'pegawai_pending' => $UserData['data']->uid,
                );
            } else if(intval($parameter['status']) === 2) {
                $paramData = array(
                    'status' => intval($parameter['status']),
                    'pegawai_cancel' => $UserData['data']->uid,
                );
            } else if(intval($parameter['status']) === 3) {
                $paramData = array(
                    'status' => intval($parameter['status']),
                    'pegawai_done' => $UserData['data']->uid,
                );
            }

            $data = self::$query->update('order_sales', $paramData)
                ->where(array(
                    'order_sales.id' => '= ?'
                ), array(
                    intval($parameter['order'])
                ))
                ->execute();
            return $data;
        } else {
            return array('response_data' => array(), 'response_result' => 0, 'response_message' => 'Tidak ada akses');
        }
    }

    private function order_export($parameter)
    {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);

        $parameter['divisi'] = trim($parameter['divisi']);

        if((isset($parameter['toko']) && intval($parameter['toko']) > 0) && isset($parameter['divisi']) && !empty($parameter['divisi'])) {
            $paramData = array(
                'order_sales.deleted_at' => 'IS NULL',
                'AND',
                'order_sales.toko' => '= ?',
                'AND',
                'order_sales.supplier' => '= ?',
                'AND',
                'order_sales.created_at' => 'BETWEEN ? AND ?',
            );

            $paramValue = array(intval($parameter['toko']), $parameter['divisi'], $parameter['from'], $parameter['to']);

            $filteredString = 'WHERE order_sales.deleted_at IS NULL AND order_sales.toko = ' . intval($parameter['toko']) . ' AND order_sales.supplier = \'' . $parameter['divisi'] . '\' AND order_sales.created_at BETWEEN \'' . $parameter['from'] . '\' AND \'' . $parameter['to'] . '\'';
        } else {
            if(isset($parameter['toko']) && intval($parameter['toko']) > 0) {
                $paramData = array(
                    'order_sales.deleted_at' => 'IS NULL',
                    'AND',
                    'order_sales.toko' => '= ?',
                    'AND',
                    'order_sales.created_at' => 'BETWEEN ? AND ?',
                );

                $paramValue = array(intval($parameter['toko']), $parameter['from'], $parameter['to']);

                $filteredString = 'WHERE order_sales.deleted_at IS NULL AND order_sales.toko = ' . intval($parameter['toko'] . ' AND order_sales.created_at BETWEEN \'' . $parameter['from'] . '\' AND \'' . $parameter['to'] . '\'');
            } else if(isset($parameter['divisi']) && !empty($parameter['divisi'])) {
                $paramData = array(
                    'order_sales.deleted_at' => 'IS NULL',
                    'AND',
                    'order_sales.supplier' => '= ?',
                    'AND',
                    'order_sales.created_at' => 'BETWEEN ? AND ?',
                );

                $paramValue = array($parameter['divisi'], $parameter['from'], $parameter['to']);

                $filteredString = 'WHERE order_sales.deleted_at IS NULL AND order_sales.supplier = \'' . $parameter['divisi'] . '\' AND order_sales.created_at BETWEEN \'' . $parameter['from'] . '\' AND \'' . $parameter['to'] . '\'';
            } else {
                $paramData = array(
                    'order_sales.deleted_at' => 'IS NULL',
                    'AND',
                    'order_sales.created_at' => 'BETWEEN ? AND ?',
                );

                $paramValue = array($parameter['from'], $parameter['to']);

                $filteredString = 'WHERE order_sales.deleted_at IS NULL AND order_sales.created_at BETWEEN \'' . $parameter['from'] . '\' AND \'' . $parameter['to'] . '\'';
            }
        }

        $data = [
            ['TANGGAL', 'DIVISI', 'SALESMAN', 'RUTE', 'KODE TOKO', 'NAMA TOKO', 'ALAMAT', 'KODE BARANG', 'NAMA BARANG', 'SATUAN', 'QTY', 'PEMBAYARAN', 'STATUS', 'ADMIN']
        ];

        $getData = self::$query->select('order_detail', array(
            'id', 'qty'
        ))
            ->join('order_sales', array(
                'kode as kode_order',
                'tanggal as tanggal_order',
                'metode_bayar',
                'status'
            ))
            ->join('master_inv', array(
                'kode_barang',
                'nama as nama_barang'
            ))
            ->join('master_inv_satuan', array(
                'nama as nama_satuan'
            ))
            ->join('master_toko', array(
                'kode as kode_toko',
                'nama as nama_toko',
                'alamat'
            ))
            ->join('master_rute', array(
                'nama as nama_rute'
            ))
            ->join('master_inv_supplier', array(
                'kode as kode_divisi',
                'nama as nama_divisi'
            ))
            ->join('pegawai', array(
                'nama as nama_sales'
            ))
            ->on(array(
                array('order_detail.order_sales', '=', 'order_sales.id'),
                array('order_detail.item', '=', 'master_inv.uid'),
                array('order_detail.satuan', '=', 'master_inv_satuan.uid'),
                array('order_sales.toko', '=', 'master_toko.id'),
                array('order_sales.rute', '=', 'master_rute.id'),
                array('order_sales.supplier', '=', 'master_inv_supplier.uid'),
                array('order_sales.sales', '=', 'pegawai.uid')
            ))
            ->where($paramData, $paramValue)
            ->execute();

        $metodeBayar = ['', 'COD', 'Cicil 7 Hari', 'Cicil 14 Hari'];
        $statusOrder = ['Baru', 'Pending', 'Cancel', 'Done'];

        foreach ($getData['response_data'] as $key => $value) {
            array_push($data, [
                $value['tanggal_order'], $value['nama_divisi'], $value['nama_sales'], $value['nama_rute'], $value['kode_toko'], $value['nama_toko'], $value['alamat'], $value['kode_barang'], $value['nama_barang'], $value['nama_satuan'], floatval($value['qty']), $metodeBayar[intval($value['metode_bayar'])], $statusOrder[intval($value['status'])], $UserData['data']->nama
            ]);
        }

        $xlsx = \Shuchkin\SimpleXLSXGen::fromArray( $data );
        $targetReport = __HOST__ . 'documents/report/' . $parameter['from'] . '_to_' . $parameter['to'] . '.xlsx';
        $xlsx->saveAs('../documents/report/' . $parameter['from'] . '_to_' . $parameter['to'] . '.xlsx');

        return $targetReport;
    }

    private function get_order($parameter)
    {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);

        $parameter['divisi'] = trim($parameter['divisi']);

        if((isset($parameter['toko']) && intval($parameter['toko']) > 0) && isset($parameter['divisi']) && !empty($parameter['divisi']) && (isset($parameter['search']['value']) && !empty($parameter['search']['value']))) {
            $paramData = array(
                'order_sales.deleted_at' => 'IS NULL',
                'AND',
                'order_sales.kode' => 'ILIKE ' . '\'%' . $parameter['search']['value'] . '%\'',
                'AND',
                'order_sales.toko' => '= ?',
                'AND',
                'order_sales.supplier' => '= ?',
                'AND',
                'order_sales.created_at' => 'BETWEEN ? AND ?',
            );

            $paramValue = array(intval($parameter['toko']), $parameter['divisi'], $parameter['from'], $parameter['to']);

            $filteredString = 'WHERE order_sales.deleted_at IS NULL AND order_sales.kode ILIKE \'%' . $parameter['search']['value'] . '%\' AND order_sales.toko = ' . intval($parameter['toko']) . ' AND order_sales.supplier = \'' . $parameter['divisi'] . '\' AND order_sales.created_at BETWEEN \'' . $parameter['from'] . '\' AND \'' . $parameter['to'] . '\'';
        } else {
            if(isset($parameter['toko']) && intval($parameter['toko']) > 0) {
                $paramData = array(
                    'order_sales.deleted_at' => 'IS NULL',
                    'AND',
                    'order_sales.toko' => '= ?',
                    'AND',
                    'order_sales.created_at' => 'BETWEEN ? AND ?',
                );

                $paramValue = array(intval($parameter['toko']), $parameter['from'], $parameter['to']);

                $filteredString = 'WHERE order_sales.deleted_at IS NULL AND order_sales.toko = ' . intval($parameter['toko'] . ' AND order_sales.created_at BETWEEN \'' . $parameter['from'] . '\' AND \'' . $parameter['to'] . '\'');
            } else if(isset($parameter['divisi']) && !empty($parameter['divisi'])) {
                $paramData = array(
                    'order_sales.deleted_at' => 'IS NULL',
                    'AND',
                    'order_sales.supplier' => '= ?',
                    'AND',
                    'order_sales.created_at' => 'BETWEEN ? AND ?',
                );

                $paramValue = array($parameter['divisi'], $parameter['from'], $parameter['to']);

                $filteredString = 'WHERE order_sales.deleted_at IS NULL AND order_sales.supplier = \'' . $parameter['divisi'] . '\' AND order_sales.created_at BETWEEN \'' . $parameter['from'] . '\' AND \'' . $parameter['to'] . '\'';
            } else if (isset($parameter['search']['value']) && !empty($parameter['search']['value'])) {
                $paramData = array(
                    'order_sales.deleted_at' => 'IS NULL',
                    'AND',
                    'order_sales.kode' => 'ILIKE ' . '\'%' . $parameter['search']['value'] . '%\' AND order_sales.created_at BETWEEN \'' . $parameter['from'] . '\' AND \'' . $parameter['to'] . '\'',
                    'AND',
                    'order_sales.created_at' => 'BETWEEN ? AND ?',
                );

                $paramValue = array($parameter['from'], $parameter['to']);

                $filteredString = 'WHERE order_sales.deleted_at IS NULL AND order_sales.kode ILIKE \'%' . $parameter['search']['value'] . '%\' AND order_sales.created_at BETWEEN \'' . $parameter['from'] . '\' AND \'' . $parameter['to'] . '\'';
            } else {
                $paramData = array(
                    'order_sales.deleted_at' => 'IS NULL',
                    'AND',
                    'order_sales.created_at' => 'BETWEEN ? AND ?',
                );

                $paramValue = array($parameter['from'], $parameter['to']);

                $filteredString = 'WHERE order_sales.deleted_at IS NULL AND order_sales.created_at BETWEEN \'' . $parameter['from'] . '\' AND \'' . $parameter['to'] . '\'';
            }
        }

        $data = self::$query->select('order_sales', array(
            'id',
            'kode',
            'toko',
            'supplier',
            'sales',
            'tanggal',
            'status',
            'pegawai_done',
            'pegawai_pending',
            'pegawai_cancel',
            'metode_bayar',
            'remark',
            'created_at',
            'updated_at'
        ))
            ->join('master_toko', array(
                'nama as toko_nama'
            ))
            ->join('pegawai', array(
                'nama as sales_nama'
            ))
            ->join('master_inv_supplier', array(
                'nama as divisi_nama'
            ))
            ->join('master_rute', array(
                'nama as rute_nama'
            ))
            ->on(array(
                array('order_sales.toko', '=', 'master_toko.id'),
                array('order_sales.sales', '=', 'pegawai.uid'),
                array('order_sales.supplier', '=', 'master_inv_supplier.uid'),
                array('order_sales.rute', '=', 'master_rute.id')
            ))
            ->order(array(
                'order_sales.updated_at' => 'DESC'
            ))
            ->where($paramData, $paramValue)
            ->offset(intval($parameter['start']) ?? 0)
            ->limit(intval($parameter['length']) ?? 10)
            ->execute();

        $data['response_draw'] = $parameter['draw'];
        $autonum = intval($parameter['start']) + 1;
        foreach ($data['response_data'] as $key => $value) {
            $data['response_data'][$key]['autonum'] = $autonum;
            $data['response_data'][$key]['tanggal'] = Utility::dateToIndo($value['tanggal']);

            $data['response_data'][$key]['detail'] = self::$query->select('order_detail', array(
                'type', 'qty', 'item'
            ))
                ->join('master_inv', array(
                    'nama as nama_barang'
                ))
                ->join('master_inv_satuan', array(
                    'nama as nama_satuan'
                ))
                ->on(array(
                    array('order_detail.item', '=', 'master_inv.uid'),
                    array('order_detail.satuan', '=', 'master_inv_satuan.uid')
                ))
                ->where(array(
                    'order_sales' => '= ?'
                ), array(
                    $value['id']
                ))
                ->execute()['response_data'];

            $autonum++;
        }

        $query = self::$pdo->prepare('SELECT COUNT(*) as count FROM order_sales WHERE deleted_at IS NULL');
        $query->execute(array());
        if($query->rowCount() > 0) {
            $read = $query->fetchAll(\PDO::FETCH_ASSOC);
            $data['recordsTotal'] = $read[0]['count'];
        } else {
            $data['recordsTotal'] = 0;
        }

        $query = self::$pdo->prepare('SELECT COUNT(*) as count FROM order_sales ' . $filteredString);
        $query->execute(array());
        if($query->rowCount() > 0) {
            $read = $query->fetchAll(\PDO::FETCH_ASSOC);
            $data['recordsFiltered'] = $read[0]['count'];
        } else {
            $data['recordsFiltered'] = 0;
        }

        $data['length'] = intval($parameter['length']);
        $data['start'] = intval($parameter['start']);
        unset($data['response_query']);

        return $data;

    }

//    private function get_toko($parameter) {
//        $Authorization = new Authorization();
//        $UserData = $Authorization->readBearerToken($parameter['access_token']);
//
//        if (isset($parameter['search']['value']) && !empty($parameter['search']['value'])) {
//            $paramData = array(
//                'order_sales.deleted_at' => 'IS NULL',
//                'AND',
//                'order_sales.kode' => 'ILIKE ' . '\'%' . $parameter['search']['value'] . '%\''
//            );
//
//            $paramValue = array();
//        } else {
//            $paramData = array(
//                'order_sales.deleted_at' => 'IS NULL'
//            );
//
//            $paramValue = array();
//        }
//
//
//        if ($parameter['length'] < 0) {
//            $data = self::$query->select('order', array(
//                'id',
//                'kode',
//                'toko',
//                'supplier',
//                'sales',
//                'tanggal',
//                'status',
//                'pegawai_done',
//                'pegawai_pending',
//                'pegawai_cancel',
//                'metode_bayar',
//                'remark',
//                'created_at',
//                'updated_at'
//            ))
//                ->join('master_toko', array(
//                    'nama as toko_nama'
//                ))
//                ->join('pegawai', array(
//                    'nama as sales_nama'
//                ))
//                ->on(array(
//                    array('order_sales.toko', '=', 'master_toko.id'),
//                    array('order_sales.sales', '=', 'pegawai.uid')
//                ))
//                ->order(array(
//                    'order_sales.updated_at' => 'DESC'
//                ))
//                ->where($paramData, $paramValue)
//                ->execute();
//        } else {
//            $data = self::$query->select('master_toko', array(
//                'id',
//                'kode',
//                'toko',
//                'supplier',
//                'sales',
//                'tanggal',
//                'status',
//                'pegawai_done',
//                'pegawai_pending',
//                'pegawai_cancel',
//                'metode_bayar',
//                'remark',
//                'created_at',
//                'updated_at'
//            ))
//                ->join('master_toko', array(
//                    'nama as toko_nama'
//                ))
//                ->join('pegawai', array(
//                    'nama as sales_nama'
//                ))
//                ->on(array(
//                    array('order_sales.toko', '=', 'master_toko.id'),
//                    array('order_sales.sales', '=', 'pegawai.uid')
//                ))
//                ->order(array(
//                    'order_sales.updated_at' => 'DESC'
//                ))
//                ->where($paramData, $paramValue)
//                ->offset(intval($parameter['start']))
//                ->limit(intval($parameter['length']))
//                ->execute();
//        }
//
//        $data['response_draw'] = $parameter['draw'];
//        $autonum = intval($parameter['start']) + 1;
//        foreach ($data['response_data'] as $key => $value) {
//            $data['response_data'][$key]['autonum'] = $autonum;
//
//            $data['response_data'][$key]['detail'] = self::$query->select('order_detail', array(
//                'id',
//            ));
//
//            $autonum++;
//        }
//
//        $itemTotal = self::$query->select('master_toko', array(
//            'id'
//        ))
//            ->where($paramData, $paramValue)
//            ->execute();
//
//        $data['recordsTotal'] = count($itemTotal['response_data']);
//        $data['recordsFiltered'] = count($itemTotal['response_data']);
//        $data['length'] = intval($parameter['length']);
//        $data['start'] = intval($parameter['start']);
//
//        return $data;
//    }
    /*=========================================================*/


    /*====================== CRUD ========================*/

    private function tambah_order_detail($parameter) {
        $parent = intval($parameter['parent']);
        $child = array();
        $forSave = [];
        foreach ($parameter['detail'] as $key => $value) {

            if(floatval($value['jlh_satuan_besar']) > 0) {
                array_push($child, self::$query->insert('order_detail', array(
                    'order_sales' => $parent,
                    'item' => $value['item'],
                    'satuan' => $value['id_satuan_besar'],
                    'qty' => floatval($value['jlh_satuan_besar']),
                    'type' => 'besar',
                    'remark' => $value['remark']
                ))
                    ->execute());
            }

            if(floatval($value['jlh_satuan_tengah']) > 0) {
                array_push($child, self::$query->insert('order_detail', array(
                    'order_sales' => $parent,
                    'item' => $value['item'],
                    'satuan' => $value['id_satuan_tengah'],
                    'qty' => floatval($value['jlh_satuan_tengah']),
                    'type' => 'tengah',
                    'remark' => $value['remark']
                ))
                    ->execute());
            }

            if(floatval($value['jlh_satuan_kecil']) > 0) {
                array_push($child, self::$query->insert('order_detail', array(
                    'order_sales' => $parent,
                    'item' => $value['item'],
                    'satuan' => $value['id_satuan_kecil'],
                    'qty' => floatval($value['jlh_satuan_kecil']),
                    'type' => 'kecil',
                    'remark' => $value['remark']
                ))
                    ->execute());
            }
        }

        return $child;
    }

    private function tambah_order($parameter){
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);

        /*
         * 1. Check transaksi hari ini untuk toko dan divisi terkait dengan status baru (0)
         * 2. Jika tidak ada maka buat baru
         * 3. Jika ada maka akumulasi ke transaksi tersebut
         *
         * */

        $checkTodayTransact = self::$query->select('order_sales', array('id'))
            ->where(array(
                'order_sales.toko' => '= ?',
                'AND',
                'order_sales.supplier' => '= ?',
                'AND',
                'order_sales.status' => '= ?'
            ), array(
                $parameter['toko'],
                $parameter['divisi'],
                "0"
            ))
            ->execute();

        if(count($checkTodayTransact['response_data']) > 0) {


            // Accumulate

            $OLD = $checkTodayTransact['response_data'][0];




            // Insert Detail
            $checkTodayTransact['detail'] = self::tambah_order_detail(array(
                'parent' => $OLD['id'],
                'detail' => $parameter['detail']
            ));

            return $checkTodayTransact;


        } else {






            // Generate order code
            $latestPO = self::$query->select('order_sales', array(
                'id'
            ))
                ->where(array(
                    'EXTRACT(MONTH FROM created_at)' => '= ?'
                ), array(
                    intval(date('m'))
                ))
                ->execute();

            $getToko = self::$query->select('master_toko', array('kode'))
                ->where(array(
                    'master_toko.id' => '= ?'
                ), array(
                    $parameter['toko']
                ))
                ->execute();
            $kode_toko = $getToko['response_data'][0]['kode'];

            $getDivisi = self::$query->select('master_inv_supplier', array('kode'))
                ->where(array(
                    'master_inv_supplier.uid' => '= ?'
                ), array(
                    $parameter['divisi']
                ))
                ->execute();
            $kode_divisi = $getDivisi['response_data'][0]['kode'];

            $set_code = 'ORD/' . date('Y') . '/' . str_pad(date('m'), 2, '0', STR_PAD_LEFT) . '/' . $kode_toko . '/' . $kode_divisi . '/'. str_pad(count($latestPO['response_data']) + 1, 4, '0', STR_PAD_LEFT);

            $add = self::$query
                ->insert('order_sales', array(
                        'kode'=>$set_code,
                        'toko'=>$parameter['toko'],
                        'rute' => $parameter['rute'],
                        'supplier'=>$parameter['divisi'],
                        'tanggal' => parent::format_date(),
                        'sales' => $parameter['sales'],
                        'status' => 0,
                        'metode_bayar' => $parameter['metode_bayar'],
                        'remark' => $parameter['remark'],
                        'created_at'=>parent::format_date(),
                        'updated_at'=>parent::format_date()
                    )
                )
                ->returning('id')
                ->execute();

            if ($add['response_result'] > 0){
                $log = parent::log(array(
                        'type'=>'activity',
                        'column'=>array(
                            'unique_target',
                            'user_uid',
                            'table_name',
                            'action',
                            'logged_at',
                            'status',
                            'login_id'
                        ),
                        'value'=>array(
                            $add['response_unique'],
                            $UserData['data']->uid,
                            'order',
                            'I',
                            parent::format_date(),
                            'N',
                            $UserData['data']->log_id
                        ),
                        'class'=>__CLASS__
                    )
                );

                // Insert Detail

                $detail = self::tambah_order_detail(array(
                    'parent' => $add['response_unique'],
                    'detail' => $parameter['detail']
                ));
            }

            return $add;




        }
    }

    private function delete_toko($table, $parameter){
        $Authorization = new Authorization();
        $UserData = $Authorization::readBearerToken($parameter['access_token']);

        $bed = self::$query
            ->delete($table)
            ->where(array(
                $table . '.id' => '= ?'
            ), array(
                    $parameter[6]
                )
            )
            ->execute();

        if ($bed['response_result'] > 0){
            $log = parent::log(array(
                    'type'=>'activity',
                    'column'=>array(
                        'unique_target',
                        'user_uid',
                        'table_name',
                        'action',
                        'logged_at',
                        'status',
                        'login_id'
                    ),
                    'value'=>array(
                        $parameter[6],
                        $UserData['data']->uid,
                        $table,
                        'D',
                        parent::format_date(),
                        'N',
                        $UserData['data']->log_id
                    ),
                    'class'=>__CLASS__
                )
            );
        }

        return $bed;
    }

    private function duplicate_check($parameter) {
        return self::$query
            ->select($parameter['table'], array(
                'uid',
                'nama'
            ))
            ->where(array(
                $parameter['table'] . '.deleted_at' => 'IS NULL',
                'AND',
                $parameter['table'] . '.nama' => '= ?'
            ), array(
                $parameter['check']
            ))
            ->execute();
    }
}