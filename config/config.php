<?php

// With docker MYSQL_HOST is not localhost, it's db
const MYSQL_HOST = 'db';
const MYSQL_PORT = 3306;
const MYSQL_NAME = 'tom_troc';
const MYSQL_USER = 'root';
const MYSQL_PASSWORD = 'root';

// Image size const (octets)
const IMAGE_MAX_SIZES = [
    'book_cover' => 50000000,
    'avatar' => 500000,
];
