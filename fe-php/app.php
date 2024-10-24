<?php 

$API_URL = [
  'development' => '',
  'production' => '',
];

$API_ENDPOINT = [
  'development' => [
    'toko_list' => './sample_data/order-data.json',
    'toko_detail' => './sample_data/customer-search-by-id.json',
    'toko_search' => './sample_data/customer-search.json',
    'rute_select' => './sample_data/order-rute-search.json', 
    'supplier_list' => './sample_data/order-data-divisi.json',
    'supplier_item_list' => './sample_data/order-item-list.json', 
  ],
  'production' => [
    'toko_list' => 'sales/api/Lokasi/get_toko',
    'toko_detail' => 'sales/api/Lokasi/get_toko_detail',
    'toko_search' => 'sales/api/Lokasi/search_toko',
    'rute_select' => 'sales/api/Lokasi/get_rute', 
    'supplier_list' => 'sales/api/Inventori/supplier',
    'supplier_item_list' => 'sales/api/Inventori/item',
  ]
];

