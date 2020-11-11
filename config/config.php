<?php

define('DEBUG', true);

// Absolute link
define('PATH_API', '/home/juliengigw/api');

// Relative links (1st degree)
define('PATH_SETTING', PATH_API . '/config/setting.ini');
define('PATH_CONTROLLER', PATH_API . '/controller');
define('PATH_DOMAIN', PATH_API . '/domain');

// Relative links (2nd degree)
define('PATH_DAO', PATH_DOMAIN . '/dao');
define('PATH_MODEL', PATH_DOMAIN . '/model');
define('PATH_SERVICE', PATH_DOMAIN . '/service');

// Relative links (3rd degree)
define('PATH_DTO', PATH_MODEL . '/dto');
