#!/usr/bin/php
<?php

// Parse CLI arguments
$cli_opts = "h";
$cli_long_opts = array(
	"list",
	"host:"
);
$options = getopt( $cli_opts, $cli_long_opts );

// HGV-supplied core YAML
$core_file = __DIR__ . "/../provisioning/domains.yml";
$core_array = array();

// Optional user-supplied YAML
$inventory_file = __DIR__ . "/../hgv_data/customdomains.yml";
$inventory_array = array();

//
// Check to make sure nothing's gone wrong,
// load defaults from core YAML
//
if( file_exists( $core_file ) ) {
    $core_yaml = yaml_parse_file( $core_file );
    $core_groups = array();
    $core_inventory = array();

    foreach( $core_yaml as $group => $values ) {
        $core_inventory[$group]["hosts"] = $values['hosts'];
        $core_inventory[$group]["vars"] = $values['vars'];
    }

    // print_r( $core_inventory );
    //
    print_r(json_encode($core_inventory, JSON_PRETTY_PRINT ));
} else {
    echo "ABORTING RUN. Core config file missing.";
}

// if( file_exists( $inventory_file ) ) {
// 	$inventory = yaml_parse_file( $inventory_file );
// 	if( !empty($options['host'] ) ) {
// 		echo "Host: " . $options['host'];
// 	}
// 	foreach ( $inventory as $group => $values ) {
// 		$hosts = array();
// 		$ans_vars = array();
// 		foreach ( $values as $host => $vars ){
// 			$hosts[] = $host;
// 			$ans_vars[] = $vars;
// 		}
// 		$inventory_array[$group] = array(
// 			"hosts"	=> $hosts,
// 			"vars"	=> $ans_vars
// 		);
// 	}
// 	print_r(json_encode($inventory_array, JSON_PRETTY_PRINT ));
// } else {
// 	echo "It doesn't exist!\n";
// }
