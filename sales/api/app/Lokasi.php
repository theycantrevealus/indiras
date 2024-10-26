<?php

namespace PondokCoder;

use PondokCoder\Query as Query;
use PondokCoder\QueryException as QueryException;
use PondokCoder\Utility as Utility;
use PondokCoder\Authorization as Authorization;
use PondokCoder\Lantai as Lantai;
use PondokCoder\Ruangan as Ruangan;

class Lokasi extends Utility {
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
                case 'toko':
                    return self::get_toko('master_toko');
                    break;
                case 'get_all_toko':
                    return self::get_all_toko($parameter);
                    break;
                case 'get_toko':
                    return self::select2_get_rute($parameter);
                    break;
                case 'get_toko_detail':
                    return self::get_toko_detail($parameter);
                    break;
                case 'search_toko':
                    return self::search_toko($parameter);
                    break;
                case 'get_rute':
                    return self::search_rute($parameter);
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
            case 'tambah_toko':
                return self::tambah_toko('master_toko', $parameter);
                break;

            case 'edit_toko':
                return self::edit_toko('master_toko', $parameter);
                break;

            case 'get_toko':
                return self::get_toko($parameter);
                break;

            case 'get_rute':
                return self::get_rute($parameter);
                break;

            case 'tambah_rute':
                return self::tambah_rute($parameter);
                break;

            case 'edit_rute':
                return self::edit_rute($parameter);
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
    private function get_toko($parameter) {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);

        if (isset($parameter['search']['value']) && !empty($parameter['search']['value'])) {
            $paramData = array(
                'master_toko.deleted_at' => 'IS NULL',
                'AND',
                '(master_toko.nama' => 'ILIKE ' . '\'%' . $parameter['search']['value'] . '%\'',
                'OR',
                'master_toko.kode' => 'ILIKE ' . '\'%' . $parameter['search']['value'] . '%\')'
            );

            $paramValue = array();
        } else {
            $paramData = array(
                'master_toko.deleted_at' => 'IS NULL'
            );

            $paramValue = array();
        }


        if ($parameter['length'] < 0) {
            $data = self::$query->select('master_toko', array(
                'id',
                'kode',
                'nama',
                'koordinat',
                'alamat',
                'created_at',
                'updated_at'
            ))
                ->order(array(
                    'updated_at' => 'DESC'
                ))
                ->where($paramData, $paramValue)
                ->execute();
        } else {
            $data = self::$query->select('master_toko', array(
                'id',
                'kode',
                'nama',
                'koordinat',
                'alamat',
                'provinsi',
                'kabupaten',
                'kecamatan',
                'kelurahan',
                'created_at',
                'updated_at'
            ))
                ->order(array(
                    'updated_at' => 'DESC'
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

            $KelurahanInfo = self::$query->select('master_wilayah_kelurahan', array(
                'nama'
            ))
                ->where(array(
                    'master_wilayah_kelurahan.id' => '= ?'
                ), array(
                    $value['kelurahan']
                ))
                ->execute();
            $data['response_data'][$key]['alamat_kelurahan_parse'] = $KelurahanInfo['response_data'][0]['nama'];

            $KecamatanInfo = self::$query->select('master_wilayah_kecamatan', array(
                'nama'
            ))
                ->where(array(
                    'master_wilayah_kecamatan.id' => '= ?'
                ), array(
                    $value['kecamatan']
                ))
                ->execute();
            $data['response_data'][$key]['alamat_kecamatan_parse'] = $KecamatanInfo['response_data'][0]['nama'];

            $KabupatenInfo = self::$query->select('master_wilayah_kabupaten', array(
                'nama'
            ))
                ->where(array(
                    'master_wilayah_kabupaten.id' => '= ?'
                ), array(
                    $value['kabupaten']
                ))
                ->execute();
            $data['response_data'][$key]['alamat_kabupaten_parse'] = $KabupatenInfo['response_data'][0]['nama'];

            $ProvinsiInfo = self::$query->select('master_wilayah_provinsi', array(
                'nama'
            ))
                ->where(array(
                    'master_wilayah_provinsi.id' => '= ?'
                ), array(
                    $value['provinsi']
                ))
                ->execute();
            $data['response_data'][$key]['alamat_provinsi_parse'] = $ProvinsiInfo['response_data'][0]['nama'];

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

    private function get_all_toko() {
        $data = self::$query->select('master_toko', array(
                'id',
                'nama',
                'alamat',
                'kode',
                'provinsi',
                'kabupaten',
                'kecamatan',
                'kelurahan'
            )
        )
            ->where(
                array(
                    'master_toko.deleted_at' => 'IS NULL',
                    'AND',
                    '(master_toko.nama' => 'ILIKE ' . '\'%' . $_GET['search'] . '%\'',
                    'OR',
                    'master_toko.kode' => 'ILIKE ' . '\'%' . $_GET['search'] . '%\')'
                ), array()
            )
            ->execute();

        foreach ($data['response_data'] as $key => $value) {
            $data['response_data'][$key]['autonum'] = $autonum;

            $KelurahanInfo = self::$query->select('master_wilayah_kelurahan', array(
                'nama'
            ))
                ->where(array(
                    'master_wilayah_kelurahan.id' => '= ?'
                ), array(
                    $value['kelurahan']
                ))
                ->execute();
            $data['response_data'][$key]['alamat_kelurahan_parse'] = $KelurahanInfo['response_data'][0]['nama'];

            $KecamatanInfo = self::$query->select('master_wilayah_kecamatan', array(
                'nama'
            ))
                ->where(array(
                    'master_wilayah_kecamatan.id' => '= ?'
                ), array(
                    $value['kecamatan']
                ))
                ->execute();
            $data['response_data'][$key]['alamat_kecamatan_parse'] = $KecamatanInfo['response_data'][0]['nama'];

            $KabupatenInfo = self::$query->select('master_wilayah_kabupaten', array(
                'nama'
            ))
                ->where(array(
                    'master_wilayah_kabupaten.id' => '= ?'
                ), array(
                    $value['kabupaten']
                ))
                ->execute();
            $data['response_data'][$key]['alamat_kabupaten_parse'] = $KabupatenInfo['response_data'][0]['nama'];

            $ProvinsiInfo = self::$query->select('master_wilayah_provinsi', array(
                'nama'
            ))
                ->where(array(
                    'master_wilayah_provinsi.id' => '= ?'
                ), array(
                    $value['provinsi']
                ))
                ->execute();
            $data['response_data'][$key]['alamat_provinsi_parse'] = $ProvinsiInfo['response_data'][0]['nama'];

            $autonum++;
        }

        $allData = array();
        $Toko['response_data'] = array_merge($allData, $data['response_data']);
        return $Toko;
    }

    private function get_toko_detail($parameter)
    {
        $params = $parameter[2];
        $data = self::$query->select('master_toko', array(
            'kode', 'nama', 'alamat'
        ))
            ->where(array(
                'master_toko.id' => '= ?',
                'AND',
                'master_toko.deleted_at' => 'IS NULL'
            ), array(
                intval($params)
            ))
            ->join('master_wilayah_provinsi',array('nama as alamat_provinsi'))
            ->join('master_wilayah_kabupaten',array('nama as alamat_kabupaten'))
            ->join('master_wilayah_kecamatan',array('nama as alamat_kecamatan'))
            ->join('master_wilayah_kelurahan',array('nama as alamat_kelurahan'))
            ->on(array(
                array('master_toko.provinsi', '=', 'master_wilayah_provinsi.id'),
                array('master_toko.kabupaten', '=', 'master_wilayah_kabupaten.id'),
                array('master_toko.kecamatan', '=', 'master_wilayah_kecamatan.id'),
                array('master_toko.kelurahan', '=', 'master_wilayah_kelurahan.id'),
            ))
            ->execute();
        unset($data['response_query']);
        $data['response_data'] = $data['response_data'][0];
        return $data;
    }

    private function search_toko($parameter)
    {
        $params = $parameter[count($parameter) - 2];

        if(isset($params['params'])) {
            $paramData = array(
                'master_toko.nama' => 'ILIKE ' . '\'%' . $params['params'] . '%\'',
                'AND',
                'master_rute.deleted_at' => 'IS NULL'
            );

            $paramValue = array();
        } else {
            $paramData = array(
                'master_rute.deleted_at' => 'IS NULL',
            );

            $paramValue = array();
        }

        $data = self::$query->select('master_toko', array(
            'id', 'kode', 'nama', 'alamat'
        ))
            ->where($paramData, $paramValue)
            ->join('master_wilayah_provinsi',array('nama as alamat_provinsi'))
            ->join('master_wilayah_kabupaten',array('nama as alamat_kabupaten'))
            ->join('master_wilayah_kecamatan',array('nama as alamat_kecamatan'))
            ->join('master_wilayah_kelurahan',array('nama as alamat_kelurahan'))
            ->on(array(
                array('master_toko.provinsi', '=', 'master_wilayah_provinsi.id'),
                array('master_toko.kabupaten', '=', 'master_wilayah_kabupaten.id'),
                array('master_toko.kecamatan', '=', 'master_wilayah_kecamatan.id'),
                array('master_toko.kelurahan', '=', 'master_wilayah_kelurahan.id'),
            ))
            ->execute();
        unset($data['response_query']);

        return $data;
    }

    private function search_rute($parameter)
    {
        $params = $parameter[count($parameter) - 2];

        if(isset($params['params'])) {
            $paramData = array(
                'master_rute.nama' => 'ILIKE ' . '\'%' . $params['params'] . '%\'',
                'AND',
                'master_rute.deleted_at' => 'IS NULL',
            );

            $paramValue = array();
        } else {
            $paramData = array(
                'master_rute.deleted_at' => 'IS NULL',
            );

            $paramValue = array();
        }

        $data = self::$query->select('master_rute', array(
            'id', 'nama as text',
        ))
            ->where($paramData, $paramValue)
            ->execute();
        unset($data['response_query']);

        return $data;
    }

    private function select2_get_rute($parameter)
    {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);

        $params = $parameter[count($parameter) - 2];

        if(isset($params['rute']) && isset($params['params'])) {
            $paramData = array(
                'master_rute_detail_toko.rute' => '= ?',
                'AND',
                'master_toko.nama' => 'ILIKE ' . '\'%' . $params['params'] . '%\'',
                'AND',
                'master_rute.deleted_at' => 'IS NULL',
            );

            $paramValue = array(
                $params['rute']
            );
        } else {
            if(isset($params['rute'])) {
                $paramData = array(
                    'master_rute_detail_toko.rute' => '= ?',
                    'AND',
                    'master_rute.deleted_at' => 'IS NULL',
                );

                $paramValue = array(
                    $params['rute']
                );
            }

            if(isset($params['params'])) {
                $paramData = array(
                    'master_toko.nama' => 'ILIKE ' . '\'%' . $params['params'] . '%\'',
                    'AND',
                    'master_rute.deleted_at' => 'IS NULL',
                );

                $paramValue = array();
            }
        }


        $data = self::$query->select('master_rute_detail_toko', array(
            'toko'
        ))
            ->join('master_rute',array('id as id_rute', 'nama as nama_rute'))
            ->join('master_toko',array('id as id_toko', 'nama as nama_toko', 'alamat', 'nama as text'))
            ->join('master_wilayah_provinsi',array('nama as alamat_provinsi'))
            ->join('master_wilayah_kabupaten',array('nama as alamat_kabupaten'))
            ->join('master_wilayah_kecamatan',array('nama as alamat_kecamatan'))
            ->join('master_wilayah_kelurahan',array('nama as alamat_kelurahan'))
            ->on(array(
                array('master_rute_detail_toko.rute', '=', 'master_rute.id'),
                array('master_rute_detail_toko.toko', '=', 'master_toko.id'),
                array('master_toko.provinsi', '=', 'master_wilayah_provinsi.id'),
                array('master_toko.kabupaten', '=', 'master_wilayah_kabupaten.id'),
                array('master_toko.kecamatan', '=', 'master_wilayah_kecamatan.id'),
                array('master_toko.kelurahan', '=', 'master_wilayah_kelurahan.id'),
            ))
            ->order(array(
                'master_rute.updated_at' => 'DESC'
            ))
            ->where($paramData, $paramValue)
            ->execute();

        unset($data['response_query']);

        return $data;

    }

    private function get_rute($parameter) {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);

        if (isset($parameter['search']['value']) && !empty($parameter['search']['value'])) {
            $paramData = array(
                'master_rute.deleted_at' => 'IS NULL',
                'AND',
                'master_rute.nama' => 'ILIKE ' . '\'%' . $parameter['search']['value'] . '%\''
            );

            $paramValue = array();
        } else {
            $paramData = array(
                'master_rute.deleted_at' => 'IS NULL'
            );

            $paramValue = array();
        }


        if ($parameter['length'] < 0) {
            $data = self::$query->select('master_rute', array(
                'id',
                'nama',
                'hari',
                'created_at',
                'updated_at'
            ))
                ->order(array(
                    'updated_at' => 'DESC'
                ))
                ->where($paramData, $paramValue)
                ->execute();
        } else {
//            $query = self::$pdo->prepare('
//                SELECT id, nama, hari,
//                       (SELECT COUNT(*) FROM public.master_rute_detail_salesWHERE public.master_rute_detail_sales.rute = public.master_rute.id) as count_sales,
//                       (SELECT COUNT(*) FROM public.master_rute_detail_toko WHERE public.master_rute_detail_toko.rute = public.master_rute.id) as count_toko,
//                                                                                created_at, updated_at FROM member WHERE uid = ? AND deleted_at IS NULL');
//            $query->execute(array($parameter[2]));

            $data = self::$query->select('master_rute', array(
                'id',
                'nama',
                'hari',
                'created_at',
                'updated_at'
            ))
                ->order(array(
                    'updated_at' => 'DESC'
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

            $data['response_data'][$key]['sales'] = self::$query->select('master_rute_detail_sales', array(
                'sales'
            ))
                ->join('pegawai', array('nama'))
                ->on(array(
                    array('master_rute_detail_sales.sales', '=', 'pegawai.uid'),
                ))
                ->where(array(
                    'master_rute_detail_sales.rute' => '= ?'
                ),
                    array($value['id'])
                )
                ->execute()['response_data'];

            $data['response_data'][$key]['toko'] = self::$query->select('master_rute_detail_toko', array(
                'toko',
            ))
                ->join('master_toko', array(
                    'nama', 'kode', 'alamat'
                ))
                ->join('master_wilayah_provinsi', array(
                    'nama as alamat_provinsi_parse'
                ))
                ->join('master_wilayah_kabupaten', array(
                    'nama as alamat_kabupaten_parse'
                ))
                ->join('master_wilayah_kecamatan', array(
                    'nama as alamat_kecamatan_parse'
                ))
                ->join('master_wilayah_kelurahan', array(
                    'nama as alamat_kelurahan_parse'
                ))
                ->on(array(
                    array('master_rute_detail_toko.toko', '=', 'master_toko.id'),
                    array('master_toko.provinsi', '=', 'master_wilayah_provinsi.id'),
                    array('master_toko.kabupaten', '=', 'master_wilayah_kabupaten.id'),
                    array('master_toko.kecamatan', '=', 'master_wilayah_kecamatan.id'),
                    array('master_toko.kelurahan', '=', 'master_wilayah_kelurahan.id')
                ))
                ->where(array(
                    'master_rute_detail_toko.rute' => '= ?'
                ),
                    array($value['id'])
                )
                ->execute()['response_data'];

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

    public function get_bed_detail($table, $parameter){
        $data = self::$query
            ->select($table,
                array(
                    'uid',
                    'nama',
                    'tarif',
                    'uid_ruangan',
                    'uid_lantai',
                    'created_at',
                    'updated_at'
                )
            )
            ->where(array(
                $table . '.deleted_at' => 'IS NULL',
                'AND',
                $table . '.uid' => '= ?'
            ),
                array($parameter)
            )
            ->execute();

        $autonum = 1;
        foreach ($data['response_data'] as $key => $value) {
            $data['response_data'][$key]['autonum'] = $autonum;
            $autonum++;
        }

        return $data;
    }
    /*=========================================================*/


    /*====================== CRUD ========================*/
    private function tambah_toko($table, $parameter){
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);

        $check = self::duplicate_check(array(
            'table'=>$table,
            'check'=>$parameter['nama']
        ));

        if (count($check['response_data']) > 0){
            $check['response_message'] = 'Duplicate data detected';
            $check['response_result'] = 0;
            unset($check['response_data']);
            return $check;
        } else {
            $bed = self::$query
                ->insert($table, array(
                        'nama'=>$parameter['nama'],
                        'kode'=>$parameter['kode'],
                        'alamat'=>$parameter['alamat'],
                        'koordinat'=>$parameter['koordinat'],
                        'provinsi' => $parameter['provinsi'],
                        'kabupaten' => $parameter['kabupaten'],
                        'kecamatan' => $parameter['kecamatan'],
                        'kelurahan' => $parameter['kelurahan'],
                        'created_at'=>parent::format_date(),
                        'updated_at'=>parent::format_date()
                    )
                )
                ->returning('uid')
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
                            $bed['response_unique'],
                            $UserData['data']->uid,
                            $table,
                            'I',
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
    }

    function edit_rute($parameter) {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);

        $day = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
        $updateRute = self::$query->update('master_rute', array(
            'nama'=> $day[intval($parameter['hari']) - 1] . ' ' . $parameter['week_no'],
            'hari'=>intval($parameter['hari']),
            'week_no'=>$parameter['week_no'],
            'updated_at'=>parent::format_date(),
        ))
            ->where(array(
                'master_rute.deleted_at' => 'IS NULL',
                'AND',
                'master_rute.id' => '= ?'
            ),
                array(
                    $parameter['id']
                )
            )
            ->execute();

        if($updateRute['response_result'] > 0) {
            $resetSales = self::$query
                ->hard_delete('master_rute_detail_sales')
                ->where(array(
                    'master_rute_detail_sales.rute' => '= ?'
                ), array(
                        intval($parameter['id'])
                    )
                )
                ->execute();

            foreach ($parameter['sales'] as $key => $value) {
                $saveSales = self::$query
                    ->insert('master_rute_detail_sales', array(
                            'sales'=> $value['id'],
                            'rute' => $parameter['id'],
                        )
                    )
                    ->execute();
                array_push($salesData, $saveSales);
            }


            $resetToko = self::$query
                ->hard_delete('master_rute_detail_toko')
                ->where(array(
                    'master_rute_detail_toko.rute' => '= ?'
                ), array(
                        intval($parameter['id'])
                    )
                )
                ->execute();

            foreach ($parameter['toko'] as $key => $value) {
                $saveToko = self::$query
                    ->insert('master_rute_detail_toko', array(
                            'toko'=> intval($value['id']),
                            'rute' => $parameter['id'],
                        )
                    )
                    ->execute();
                array_push($tokoData, $saveToko);
            }

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
                        $parameter['id'],
                        $UserData['data']->uid,
                        'master_rute',
                        'U',
                        parent::format_date(),
                        'N',
                        $UserData['data']->log_id
                    ),
                    'class'=>__CLASS__
                )
            );
        }

        return $updateRute;
    }

    private function tambah_rute($parameter) {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);
        $day = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
//        $uid = parent::gen_uuid();
        $salesData = [];
        $tokoData = [];

        $saveRute = self::$query
            ->insert('master_rute', array(
                    'nama'=> $day[intval($parameter['hari']) - 1] . ' ' . $parameter['week_no'],
                    'hari'=>intval($parameter['hari']),
                    'week_no'=>$parameter['week_no'],
                    'created_at'=>parent::format_date(),
                    'updated_at'=>parent::format_date(),
                    'created_by'=>$UserData['data']->uid,
                )
            )
            ->returning('id')
            ->execute();
        if($saveRute['response_result'] > 0) {
            foreach ($parameter['sales'] as $key => $value) {
                $saveSales = self::$query
                    ->insert('master_rute_detail_sales', array(
                            'sales'=> $value['id'],
                            'rute' => $saveRute['response_unique'],
                        )
                    )
                    ->execute();
                array_push($salesData, $saveSales);
            }

            foreach ($parameter['toko'] as $key => $value) {
                $saveToko = self::$query
                    ->insert('master_rute_detail_toko', array(
                            'toko'=> intval($value['id']),
                            'rute' => $saveRute['response_unique'],
                        )
                    )
                    ->execute();
                array_push($tokoData, $saveToko);
            }

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
                        $saveRute['response_unique'],
                        $UserData['data']->uid,
                        'master_rute',
                        'I',
                        parent::format_date(),
                        'N',
                        $UserData['data']->log_id
                    ),
                    'class'=>__CLASS__
                )
            );
        }

        $saveRute['sales'] = $salesData;
        $saveRute['toko'] = $tokoData;

        return $saveRute;
    }

    private function edit_toko($table, $parameter) {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);

        $old = self::get_bed_detail($table, $parameter['id']);

        $bed = self::$query
            ->update($table, array(
                    'kode'=>$parameter['kode'],
                    'nama'=>$parameter['nama'],
                    'alamat'=>$parameter['alamat'],
                    'koordinat'=>$parameter['koordinat'],
                    'provinsi'=>$parameter['provinsi'],
                    'kabupaten'=>$parameter['kabupaten'],
                    'kecamatan'=>$parameter['kecamatan'],
                    'kelurahan'=>$parameter['kelurahan'],
                    'updated_at'=>parent::format_date()
                )
            )
            ->where(array(
                $table . '.deleted_at' => 'IS NULL',
                'AND',
                $table . '.id' => '= ?'
            ),
                array(
                    $parameter['id']
                )
            )
            ->execute();

        if ($bed['response_result'] > 0){
            unset($parameter['access_token']);

            $log = parent::log(array(
                    'type'=>'activity',
                    'column'=>array(
                        'unique_target',
                        'user_uid',
                        'table_name',
                        'action',
                        'old_value',
                        'new_value',
                        'logged_at',
                        'status',
                        'login_id'
                    ),
                    'value'=>array(
                        $parameter['id'],
                        $UserData['data']->uid,
                        $table,
                        'U',
                        json_encode($old['response_data'][0]),
                        json_encode($parameter),
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