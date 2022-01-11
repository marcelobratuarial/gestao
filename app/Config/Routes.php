<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */


$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// $routes->group('lider/protecaoveicular/api', ['namespace' => 'App\Controllers\Lider\Protecaoveicular\Api'], function ($routes) {
// 	$routes->resource('lead');
// });

$routes->group('api/publico', ['namespace' => 'App\Controllers\Api\Publico'], function ($routes) {
	$routes->get('vistoria/info/(:any)', 'Vistoria::info/$1');
	$routes->get('vistoria/info', 'Vistoria::info');
	$routes->resource('vistoria');
	$routes->resource('estados');
	$routes->resource('cidades');
	$routes->resource('leads');
	$routes->resource('leadPageLink');
});

$routes->group('api/v1', ['namespace' => 'App\Controllers\Api\V1', 'filter' => 'auth'], function ($routes) {

	$routes->post('tabela-motorhome-v2/(:alphanum)/(:num)/(:num)/(:any)/(:alpha)', 'Tabela_Motorhome::nova/$2/$3/$4/$5');
	$routes->post('tabela-motorhome/(:alphanum)/(:num)/(:num)/(:any)/(:alpha)/gerar', 'Tabela_Motorhome::completa/$2/$3/$4/$5');
	$routes->get('tabela-motorhome/(:alphanum)/(:num)/(:num)/(:any)/(:alpha)', 'Tabela_Motorhome::nova/$2/$3/$4/$5');
	$routes->get('tabela-motorhome/(:alphanum)/(:num)/(:any)/(:alpha)', 'Tabela_Motorhome::modeloPorAno/$2/$3/$4');
	$routes->get('tabela-motorhome/(:alphanum)/(:num)/(:num)', 'Tabela_Motorhome::anosModelo/$2/$3');
	$routes->get('tabela-motorhome/(:alphanum)/(:num)', 'Tabela_Motorhome::modelos/$2/$3');
	$routes->get('tabela-motorhome/implementos', 'Tabela_Motorhome::implementos');	
	$routes->get('tabela-motorhome/carretas', 'Tabela_Motorhome::carretas');	
	$routes->get('tabela-motorhome/(:alphanum)', 'Tabela_Motorhome::marcas');			
	$routes->get('tabela-motorhome', 'Tabela_Motorhome::categorias');
	$routes->post('proposta-motorhome/save', 'Proposta_Motorhome::save');

	$routes->get('dashboard/resumo', 'Dashboard::resumo');
	$routes->get('dashboard/alertas', 'Dashboard::alertas');
	$routes->resource('dashboard');

	$routes->get('documentos/info/(:any)', 'Documentos::info/$1');
	$routes->get('documentos/info', 'Documentos::info');
	$routes->get('documentos/listar-por-proposta/(:any)', 'Documentos::listar_por_proposta/$1');
	$routes->resource('documentos');

	$routes->get('financeiro/resumo', 'Financeiro::resumo');
	$routes->resource('financeiro');

	$routes->get('leads/listar-status', 'Leads::list_status');
	$routes->get('leads/minhas-leads', 'Leads::minhas_leads');


	$routes->get('propostas/listar-status', 'Propostas::list_status');
	$routes->get('propostas/minhas-propostas', 'Propostas::minhas_propostas');
	$routes->get('propostas/listar-propostas-com-documentos/(:any)', 'Propostas::listar_propostas_com_documentos/$1');
	$routes->get('propostas/listar-propostas-com-vistoria/(:any)', 'Propostas::listar_propostas_com_vistoria/$1');
	$routes->resource('propostas');

	$routes->get('vendas/listar-status', 'Vendas::list_status');
	$routes->get('vendas/minhas-vendas', 'Vendas::minhas_vendas');
	$routes->resource('vendas');

	$routes->get('vistoria/info/(:any)', 'Vistoria::info/$1');
	$routes->get('vistoria/info', 'Vistoria::info');
	$routes->get('vistoria/listar-por-proposta/(:any)', 'Vistoria::listar_por_proposta/$1');
	$routes->resource('vistoria');

	$routes->get('profile/info', 'Profile::info');
	$routes->resource('profile');
	
	$routes->resource('usuarios');
});



$routes->get('/', 'Dashboard::dash');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
