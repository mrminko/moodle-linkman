<?php

$capabilities = array(
    'local/linkman:config' => array(
        'riskbitmask'  => RISK_SPAM | RISK_PERSONAL | RISK_XSS | RISK_CONFIG,
        'captype'      => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes'   => array(
//            'unescoadmin' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    )
);