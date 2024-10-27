<?php

namespace PondokCoder;

use PondokCoder\Query as Query;
use PondokCoder\QueryException as QueryException;
use PondokCoder\Utility as Utility;
use PondokCoder\Authorization as Authorization;
use PondokCoder\Lantai as Lantai;
use PondokCoder\Ruangan as Ruangan;

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
                case 'get_all_order':
                    return self::get_toko('master_toko');
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

            default:
                # code...
                break;
        }
    }

    public function __DELETE__($parameter = array()) {
        return self::delete_toko('master_toko', $parameter);
    }


    /*====================== GET FUNCTION =====================*/
    private function get_order($parameter)
    {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);

        if (isset($parameter['search']['value']) && !empty($parameter['search']['value'])) {
            $paramData = array(
                'order_sales.deleted_at' => 'IS NULL',
                'AND',
                'order_sales.kode' => 'ILIKE ' . '\'%' . $parameter['search']['value'] . '%\''
            );

            $paramValue = array();

            $filteredString = 'WHERE order_sales.deleted_at IS NULL AND order_sales.kode ILIKE \'%' . $parameter['search']['value'] . '%\'';
        } else {
            $paramData = array(
                'order_sales.deleted_at' => 'IS NULL'
            );

            $paramValue = array();

            $filteredString = 'WHERE order_sales.deleted_at IS NULL';
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
//            $data['response_data'][$key]['detail'] = self::$query->select('order_detail', array(
//                'id',
//            ));

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

    private function get_toko($parameter) {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);

        if (isset($parameter['search']['value']) && !empty($parameter['search']['value'])) {
            $paramData = array(
                'order_sales.deleted_at' => 'IS NULL',
                'AND',
                'order_sales.kode' => 'ILIKE ' . '\'%' . $parameter['search']['value'] . '%\''
            );

            $paramValue = array();
        } else {
            $paramData = array(
                'order_sales.deleted_at' => 'IS NULL'
            );

            $paramValue = array();
        }


        if ($parameter['length'] < 0) {
            $data = self::$query->select('order', array(
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
                ->on(array(
                    array('order_sales.toko', '=', 'master_toko.id'),
                    array('order_sales.sales', '=', 'pegawai.uid')
                ))
                ->order(array(
                    'order_sales.updated_at' => 'DESC'
                ))
                ->where($paramData, $paramValue)
                ->execute();
        } else {
            $data = self::$query->select('master_toko', array(
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
                ->on(array(
                    array('order_sales.toko', '=', 'master_toko.id'),
                    array('order_sales.sales', '=', 'pegawai.uid')
                ))
                ->order(array(
                    'order_sales.updated_at' => 'DESC'
                ))
                ->where($paramData, $paramValue)
                ->offset(intval($parameter['start']))
                ->limit(intval($parameter['length']))
                ->execute();
        }

        $data['response_draw'] = $parameter['draw'];
        $autonum = intval($parameter['start']) + 1;
        foreach ($data['response_data'] as $key => $value) {
            $data['response_data'][$key]['autonum'] = $autonum;

            $data['response_data'][$key]['detail'] = self::$query->select('order_detail', array(
                'id',
            ));

            $autonum++;
        }

        $itemTotal = self::$query->select('master_toko', array(
            'id'
        ))
            ->where($paramData, $paramValue)
            ->execute();

        $data['recordsTotal'] = count($itemTotal['response_data']);
        $data['recordsFiltered'] = count($itemTotal['response_data']);
        $data['length'] = intval($parameter['length']);
        $data['start'] = intval($parameter['start']);

        return $data;
    }
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
                    'parent' => $add['id'],
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