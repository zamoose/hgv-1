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
$custom_file = __DIR__ . "/../hgv_data/customdomains.yml";
$custom_array = array();

//
// Check to make sure nothing's gone wrong,
// load defaults from core YAML
//
if( file_exists( $core_file ) ) {
    $core_yaml = yaml_parse_file( $core_file );
    $core_groups = array();
    $core_inventory = array();

    foreach( $core_yaml as $group => $values ) {
        $core_inventory[$group]['hosts'] = $values['hosts'];
        $core_inventory[$group]['vars'] = $values['vars'];
    }

    // print_r( $core_inventory );
    //
	echo "\n";
	echo "Core Inventory";
    print_r(json_encode($core_inventory, JSON_PRETTY_PRINT ));
} else {
    echo "ABORTING RUN. Core config file missing.";
}

if( file_exists( $custom_file ) ) {
	$custom_yaml = yaml_parse_file( $custom_file );
	$custom_groups = array();
	$custom_inventory = array();

	foreach( $custom_yaml as $group => $values ) {
		$custom_inventory[$group]['hosts'] = $values['hosts'];
		$custom_inventory[$group]['vars'] = $values['vars'];
	}
	// if( !empty($options['host'] ) ) {
	// 	echo "Host: " . $options['host'];
	// }
	// foreach ( $inventory as $group => $values ) {
	// 	$hosts = array();
	// 	$ans_vars = array();
	// 	foreach ( $values as $host => $vars ){
	// 		$hosts[] = $host;
	// 		$ans_vars[] = $vars;
	// 	}
	// 	$inventory_array[$group] = array(
	// 		"hosts"	=> $hosts,
	// 		"vars"	=> $ans_vars
	// 	);
	// }
	// print_r(json_encode($inventory_array, JSON_PRETTY_PRINT ));
	echo "\n";
	echo "Custom Inventory";
	print_r(json_encode($custom_inventory, JSON_PRETTY_PRINT ));

	$final_inventory = array_merge_recursive( $core_inventory, $custom_inventory );
	$final_intersect = array_intersect( $core_inventory, $custom_inventory );

	echo "\n";
	echo "Merged Inventory";
	print_r(json_encode($final_inventory, JSON_PRETTY_PRINT ));
	echo "\n";
	echo "Intersected Inventory";
	print_r(json_encode($final_intersect, JSON_PRETTY_PRINT ));
}
