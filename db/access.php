<?php

$capabilities = array(
    'local/linkman:config' => array(
        'riskbitmask'  => RISK_SPAM | RISK_PERSONAL | RISK_XSS | RISK_CONFIG,
        'captype'      => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes'   => array(
        )
    ),
    'local/linkman:view' => array(
        'riskbitmask'  => RISK_SPAM | RISK_PERSONAL | RISK_XSS | RISK_CONFIG,
        'captype'      => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes'   => array(
            'manager' => CAP_ALLOW
        )
    )
);