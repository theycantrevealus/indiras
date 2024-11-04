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
                    return self::search_toko_2($parameter);
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

            case 'proceed_import':
                return self::proceed_import($parameter);
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

//        $allData = array();
        $allData = array(
            array(
                'id' => ' ',
                'kode' => 'ALL',
                'nama' => 'All Toko '
            )
        );
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
                'master_toko.deleted_at' => 'IS NULL'
            );

            $paramValue = array();
        } else {
            $paramData = array(
                'master_toko.deleted_at' => 'IS NULL',
            );

            $paramValue = array();
        }

        $data = self::$query->select('master_toko', array(
            'id', 'kode', 'nama as text', 'alamat'
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

        foreach ($data['response_data'] as $key => $value) {
            $rute = self::$query->select('master_rute_detail_toko', array('rute'))
                ->join('master_rute', array('nama as nama_rute'))
                ->on(array(
                    array('master_rute_detail_toko.rute', '=', 'master_rute.id')
                ))
                ->where(array(
                    'master_rute_detail_toko.toko' => '= ?'
                ), array(
                    $value['id']
                ))
                ->execute();
            $data['response_data'][$key]['text'] = $value['nama'];
        }
        unset($data['response_query']);

        return $data;
    }

    private function search_toko_2($parameter)
    {
        $params = $parameter[count($parameter) - 2];

        if(isset($params['params'])) {
            $paramData = array(
                'master_toko.nama' => 'ILIKE ' . '\'%' . $params['params'] . '%\'',
                'AND',
                'master_toko.deleted_at' => 'IS NULL'
            );

            $paramValue = array();
        } else {
            $paramData = array(
                'master_toko.deleted_at' => 'IS NULL',
            );

            $paramValue = array();
        }

        $data = self::$query->select('master_rute_detail_toko', array(
            'toko as id'
        ))
            ->where($paramData, $paramValue)
            ->join('master_rute', array(
                'id as id_rute', 'nama as nama_rute'
            ))
            ->join('master_toko', array(
                'nama as nama_toko', 'alamat'
            ))
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
            ->execute();
        foreach ($data['response_data'] as $key => $value) {
            $data['response_data'][$key]['text'] = $value['nama_toko'] . ' [' . $value['nama_rute'] . ']';
        }
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

            $Toko = self::$query->select('master_rute_detail_toko', array(
                'toko',
            ))
                ->join('master_toko', array(
                    'nama', 'kode', 'alamat', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan'
                ))
//                ->join('master_wilayah_provinsi', array(
//                    'nama as alamat_provinsi_parse'
//                ))
//                ->join('master_wilayah_kabupaten', array(
//                    'nama as alamat_kabupaten_parse'
//                ))
//                ->join('master_wilayah_kecamatan', array(
//                    'nama as alamat_kecamatan_parse'
//                ))
//                ->join('master_wilayah_kelurahan', array(
//                    'nama as alamat_kelurahan_parse'
//                ))
                ->on(array(
                    array('master_rute_detail_toko.toko', '=', 'master_toko.id'),
//                    array('master_toko.provinsi', '=', 'master_wilayah_provinsi.id'),
//                    array('master_toko.kabupaten', '=', 'master_wilayah_kabupaten.id'),
//                    array('master_toko.kecamatan', '=', 'master_wilayah_kecamatan.id'),
//                    array('master_toko.kelurahan', '=', 'master_wilayah_kelurahan.id')
                ))
                ->where(array(
                    'master_rute_detail_toko.rute' => '= ?'
                ),
                    array($value['id'])
                )
                ->execute();

            foreach ($Toko['response_data'] as $TKey => $TValue) {
                $KelurahanInfo = self::$query->select('master_wilayah_kelurahan', array(
                    'nama'
                ))
                    ->where(array(
                        'master_wilayah_kelurahan.id' => '= ?'
                    ), array(
                        $TValue['kelurahan']
                    ))
                    ->execute();

                $Toko['response_data'][$TKey]['alamat_kelurahan_parse'] = (count($KelurahanInfo['response_data']) > 0) ? $KelurahanInfo['response_data'][0]['nama'] : '-';

                $KecamatanInfo = self::$query->select('master_wilayah_kecamatan', array(
                    'nama'
                ))
                    ->where(array(
                        'master_wilayah_kecamatan.id' => '= ?'
                    ), array(
                        $TValue['kecamatan']
                    ))
                    ->execute();
                $Toko['response_data'][$TKey]['alamat_kecamatan_parse'] = (count($KecamatanInfo['response_data']) > 0) ? $KecamatanInfo['response_data'][0]['nama'] : '-';

                $KabupatenInfo = self::$query->select('master_wilayah_kabupaten', array(
                    'nama'
                ))
                    ->where(array(
                        'master_wilayah_kabupaten.id' => '= ?'
                    ), array(
                        $TValue['kabupaten']
                    ))
                    ->execute();
                $Toko['response_data'][$TKey]['alamat_kabupaten_parse'] = (count($KabupatenInfo['response_data']) > 0) ? $KabupatenInfo['response_data'][0]['nama'] : '-';

                $ProvinsiInfo = self::$query->select('master_wilayah_provinsi', array(
                    'nama'
                ))
                    ->where(array(
                        'master_wilayah_provinsi.id' => '= ?'
                    ), array(
                        $TValue['provinsi']
                    ))
                    ->execute();
                $Toko['response_data'][$TKey]['alamat_provinsi_parse'] = (count($ProvinsiInfo['response_data']) > 0) ? $ProvinsiInfo['response_data'][0]['nama'] : '-';
            }

            $data['response_data'][$key]['toko'] = $Toko['response_data'];

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

    function proceed_import($parameter) {
        $Authorization = new Authorization();
        $UserData = $Authorization->readBearerToken($parameter['access_token']);

        $duplicate_row = array();
        $non_active = array();
        $failed_data = array();
        $success_proceed = 0;
        $proceed_data = array();
        $day = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
        $ruteMeta = array();
        $ruteReset = array();

        foreach ($parameter['data_import'] as $key => $value) {
            $toko_kode = $value['kode'];
            $toko = $value['toko'];
            $alamat = $value['alamat'];
            $kelurahan = $value['kelurahan'];
            $kecamatan = $value['kecamatan'];
            $kabupaten = $value['kabupaten'];
            $provinsi = $value['provinsi'];
            $koordinat = $value['koordinat'];
            $hari = ucfirst(strtolower($value['hari']));
            $pekan = $value['pekan'];
            $sales_email = str_replace(' ','_', trim(strtolower($value['sales']))) . '@cvw.com';
            $sales = $value['sales'];

            // Prepare Lokasi
            $kelurahan_check = self::$query->select('master_wilayah_kelurahan', array(
                'id',
            ))
                ->where(array(
                    'master_wilayah_kelurahan.nama' => '= ?'
                ), array(
                    strtoupper($kelurahan)
                ))
                ->limit(1)
                ->execute()['response_data'][0]['id'] ?? 0;

            $kecamatan_check = self::$query->select('master_wilayah_kecamatan', array(
                'id',
            ))
                ->where(array(
                    'master_wilayah_kecamatan.nama' => '= ?'
                ), array(
                    strtoupper($kecamatan)
                ))
                ->limit(1)
                ->execute()['response_data'][0]['id'] ?? 0;

            $kabupaten_check = self::$query->select('master_wilayah_kabupaten', array(
                'id',
            ))
                ->where(array(
                    'master_wilayah_kabupaten.nama' => '= ?'
                ), array(
                    strtoupper($kabupaten)
                ))
                ->limit(1)
                ->execute()['response_data'][0]['id'] ?? 0;

            $provinsi_check = self::$query->select('master_wilayah_provinsi', array(
                'id',
            ))
                ->where(array(
                    'master_wilayah_provinsi.nama' => '= ?'
                ), array(
                    strtoupper($provinsi)
                ))
                ->limit(1)
                ->execute()['response_data'][0]['id'] ?? 0;

            // Prepare Toko
            $checkToko = self::$query->select('master_toko', array(
                'id'
            ))
                ->where(array(
                    'master_toko.nama' => '= ?',
                    'AND',
                    'master_toko.kode' => '= ?',
                    'AND',
                    'master_toko.deleted_at' => 'IS NULL'
                ), array(
                    $toko,
                    $toko_kode
                ))
                ->execute();
            if (count($checkToko['response_data']) > 0) {
                $targetToko = $checkToko['response_data'][0]['id'];
                $updateToko = self::$query->update('master_toko', array(
                    'koordinat' => $koordinat,
                    'provinsi' => $provinsi_check,
                    'kabupaten' => $kabupaten_check,
                    'kecamatan' => $kecamatan_check,
                    'kelurahan' => $kelurahan_check,
                    'updated_at' => parent::format_date(),
                    'deleted_at' => null
                ))
                    ->where(array(
                        'master_toko.id' => '= ?'
                    ), array(
                        $targetToko
                    ))
                    ->execute();
            } else {
                $newToko = self::$query->insert('master_toko', array(
                    'kode' => $toko_kode,
                    'nama' => $toko,
                    'alamat' => $alamat,
                    'koordinat' => $koordinat,
                    'provinsi' => $provinsi_check,
                    'kabupaten' => $kabupaten_check,
                    'kecamatan' => $kecamatan_check,
                    'kelurahan' => $kelurahan_check,
                    'created_at' => parent::format_date(),
                    'updated_at' => parent::format_date()
                ))
                    ->returning('id')
                    ->execute();
                $targetToko = $newToko['response_unique'];
            }

            // Prepare Sales
            $checkSales = self::$query->select('pegawai', array(
                'uid'
            ))
                ->where(array(
                    'pegawai.email' => '= ?',
                    'AND',
                    'pegawai.deleted_at' => 'IS NULL'
                ), array(
                    $sales_email
                ))
                ->execute();
            if (count($checkSales['response_data']) > 0) {
                $targetSales = $checkSales['response_data'][0]['uid'];
            } else {
                $targetSales = parent::gen_uuid();
                $newSales = self::$query->insert('pegawai', array(
                    'uid' => $targetSales,
                    'email' => $sales_email,
                    'nama' => $sales,
                    'password' => '',
                    'jabatan' => __UIDSALES__,
                    'editable' => true,
                    'created_at' => parent::format_date(),
                    'updated_at' => parent::format_date()
                ))
                    ->execute();
            }

            // Prepare Rute
            $checkRute = self::$query->select('master_rute', array(
                'id'
            ))
                ->where(array(
                    'master_rute.nama' => '= ?',
                    'AND',
                    'master_rute.hari' => '= ?',
                    'AND',
                    'master_rute.week_no' => '= ?',
                ), array(
                    $hari . ' ' . $pekan,
                    array_search($hari, $day, true) + 1,
                    $pekan
                ))
                ->execute();
            if (count($checkRute['response_data']) > 0) {
                $targetRute = $checkRute['response_data'][0]['id'];
            } else {
                $newRute = self::$query->insert('master_rute', array(
                    'nama' => $hari . ' ' . $pekan,
                    'hari' => array_search($hari, $day, true) + 1,
                    'week_no' => $pekan,
                    'created_by' => $UserData['data']->uid,
                    'created_at' => parent::format_date(),
                    'updated_at' => parent::format_date()
                ))
                    ->returning('id')
                    ->execute();
                $targetRute = $newRute['response_unique'];
            }

            array_push($ruteMeta, array(
                'rute' => $targetRute,
                'sales' => $targetSales,
                'toko' => $targetToko
            ));

            if(array_search($targetRute, $ruteReset) === false) {
                array_push($ruteReset, $targetRute);
            }
        }

        foreach ($ruteReset as $key => $value) {
            $resetSales = self::$query->hard_delete('master_rute_detail_sales')
                ->where(array(
                    'master_rute_detail_sales.rute' => '= ?'
                ), array(
                    $value
                ))
                ->execute();

            $resetToko = self::$query->hard_delete('master_rute_detail_toko')
                ->where(array(
                    'master_rute_detail_toko.rute' => '= ?'
                ), array(
                    $value
                ))
                ->execute();
        }

        foreach ($ruteMeta as $key => $value) {
            // Add toko and sales meta
            $checkSalesRute = self::$query->select('master_rute_detail_sales', array('id'))
                ->where(array(
                    'master_rute_detail_sales.rute' => '= ?',
                    'AND',
                    'master_rute_detail_sales.sales' => '= ?'
                ), array(
                    $value['rute'],
                    $value['sales']
                ))
                ->execute();
            if (count($checkSalesRute['response_data']) < 1) {
                $ruteSales = self::$query->insert('master_rute_detail_sales', array(
                    'sales' => $value['sales'],
                    'rute' => $value['rute'],
                ))
                    ->execute();
            }

            $checkTokoRute = self::$query->select('master_rute_detail_toko', array(
                'id'
            ))
                ->where(array(
                    'master_rute_detail_toko.rute' => '= ?',
                    'AND',
                    'master_rute_detail_toko.toko' => '= ?'
                ), array(
                    $value['rute'],
                    $value['toko']
                ))
                ->execute();
            if (count($checkTokoRute['response_data']) < 1) {
                $ruteToko = self::$query->insert('master_rute_detail_toko', array(
                    'toko' => $value['toko'],
                    'rute' => $value['rute'],
                ))
                    ->execute();
            }
        }

        return array(
            'duplicate_row' => $duplicate_row,
            'non_active' => $non_active,
            'rute_reset' => $ruteReset,
            'rute_meta' => $ruteMeta,
            'success_proceed' => $success_proceed,
            'failed_data' => $failed_data,
            'data' => $parameter['data_import'],
            'proceed' => $proceed_data
        );
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