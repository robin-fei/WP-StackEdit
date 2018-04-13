<?php

require_once 'core.php';

// Include fields
foreach ( glob( plugin_dir_path( __FILE__ ). "fields/*.php" ) as $file ) {
    include_once $file;
}