<?php 

$API_URL = [
  'development' => '',
  'production' => 'http://35.240.138.90/',
];

$API_ENDPOINT = [
  'development' => [
    'login' => './sample_data/login_success.json',
    'toko_list' => './sample_data/order-data.json',
    'toko_detail' => './sample_data/customer-search-by-id.json',
    'toko_search' => './sample_data/customer-search.json',
    'rute_select' => './sample_data/order-rute-search.json', 
    'supplier_list' => './sample_data/order-data-divisi-all.json',
    'supplier_search' => './sample_data/supplier-search.json',
    'supplier_item_list' => './sample_data/order-item-list.json',
    'history_list' => './sample_data/history-order-list.json',
    'order' => './sample_data/login_success.json',
  ],
  'production' => [
    'login' => 'sales/api/Pegawai',
    'toko_list' => 'sales/api/Lokasi/get_toko',
    'toko_detail' => 'sales/api/Lokasi/get_toko_detail',
    'toko_search' => 'sales/api/Lokasi/search_toko',
    'rute_select' => 'sales/api/Lokasi/get_rute', 
    'supplier_list' => 'sales/api/Inventori/supplier',
    'supplier_search' => 'sales/api/Inventori/search_supplier',
    'supplier_item_list' => 'sales/api/Inventori/item',
    'history_list' => 'sales/api/Order',
    'order' => 'sales/api/Order',
    'order_detail_history' => 'sales/api/Order/sales_history',
  ]
];

