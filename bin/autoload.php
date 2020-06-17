<?php declare(strict_types = 1);

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
	require_once __DIR__ . '/../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../../../autoload.php')) {
	require_once __DIR__ . '/../../../autoload.php';
}
