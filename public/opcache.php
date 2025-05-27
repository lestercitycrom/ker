<?php
/**
 * opcache_status.php
 * Drop into public/ and open in browser: http://localhost/opcache_status.php
 */
$status = opcache_get_status();   // returns false if OPcache disabled
if (!$status) {
	echo 'OPcache DISABLED';
	exit;
}
printf(
	"Enabled: %s | Memory: %d / %d MB | Hit-rate: %.2f %% | Cached files: %d\n",
	$status['opcache_enabled'] ? 'yes' : 'no',
	$status['memory_usage']['used_memory'] / 1048576,
	$status['memory_usage']['used_memory'] / 1048576 +
	$status['memory_usage']['free_memory'] / 1048576,
	$status['opcache_statistics']['opcache_hit_rate'],
	$status['opcache_statistics']['num_cached_scripts']
);
