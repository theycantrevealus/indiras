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
                case 'get_toko':
                    return self::get_toko($parameter);
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
                            $uid,
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