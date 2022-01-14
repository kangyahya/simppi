<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'authentication';
$route['404_override'] = 'Errorpage';
$route['translate_uri_dashes'] = TRUE;

//CUSTOM ROUTE LIST
$route['auth'] = 'Authentication';
$route['login'] = 'Authentication/index';
$route['logout'] = 'Authentication/logout';

//Restrict page route
$route['restrict-page'] = 'Errorpage/restrict_page';

$route['pelanggan/get-detail/([a-z]+)/(:num)'] = 'Pelanggan/get_detail/$1/$2';

$route['profil-perusahaan'] = 'ProfilPerusahaan';
$route['profil-perusahaan/edit'] = 'ProfilPerusahaan/edit';
$route['profil-perusahaan/upload'] = 'ProfilPerusahaan/upload';

$route['pengaturan-aplikasi'] = 'Pengaturan';
$route['pengaturan-aplikasi/change-sidebar-appearance'] = 'Pengaturan/change_sidebar_appearance';
$route['pengaturan-aplikasi/edit'] = 'Pengaturan/edit';

//Export excel routes
$route['export-excel/(:any)'] = 'ExportExcel/$1';

$route['perhitungan/(:any)'] = 'Perhitungan/index/$1';
$route['cetak/komisi'] = 'Cetak/perhitungan/komisi';
$route['cetak/cashback'] = 'Cetak/perhitungan/cashback';