<?php

return [
    'host' => env('LDAP_HOST', ''),
    'port' => env('LDAP_PORT', 636),
    'org' => env('LDAP_ORG', ''),

    'admin_user' => env('LDAP_ADMIN_USER', ''),
    'admin_pass' => env('LDAP_ADMIN_PASS', ''),
    'admin_org' => env('LDAP_ADMIN_ORG', ''),
];
