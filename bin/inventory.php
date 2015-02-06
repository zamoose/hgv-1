#!/usr/bin/php
<?php
$cli_opts = "h";
$cli_long_opts = array(
	"list",
	"host:"
);
$options = getopt( $cli_opts, $cli_long_opts );

print_r($options);

$inventory_file = __DIR__ . "/../hgv_data/domains.yaml";

$inventory_array = array();

if( file_exists( $inventory_file ) ) {
	$inventory = yaml_parse_file( $inventory_file );

	if( !empty($options['host'] ) ) {
		echo "Host: " . $options['host'];
	}

	foreach ( $inventory as $group => $values ) {
		$hosts = array();
		$ans_vars = array();
		foreach ( $values as $host => $vars ){
			$hosts[] = $host;
			$ans_vars[] = $vars;
		}
		$inventory_array[$group] = array(
			"hosts"	=> $hosts,
			"vars"	=> $ans_vars
		);
	}
	print_r(json_encode($inventory_array, JSON_PRETTY_PRINT ));
} else {
	echo "It doesn't exist!\n";
}
