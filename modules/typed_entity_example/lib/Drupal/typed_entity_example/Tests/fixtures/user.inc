<?php

$fixture = array(
  'bundle' => 'user',
  'entity keys' => array(
    'id' => 'uid',
    'revision' => '',
    'bundle' => '',
  ),
  'entity' => (object) array(
    'uid' => '1',
    'name' => 'admin',
    'pass' => '$S$DKHuKBpoLMv8gFfAhD8krXvxRQUt3WbFkS7L3S72rXArVs2sEDDp',
    'mail' => 'admin@example.org',
    'theme' => '',
    'signature' => '',
    'signature_format' => 'filtered_html',
    'created' => '1367961694',
    'access' => '1427100351',
    'login' => '1426940306',
    'status' => '1',
    'timezone' => 'Europe/Berlin',
    'language' => '',
    'picture' => NULL,
    'init' => 'admin@example.org',
    'data' => FALSE,
    'roles' => array(
      2 => 'authenticated user',
      3 => 'administrator',
    ),
    'rdf_mapping' => array(
      'rdftype' => array(
        'sioc:UserAccount',
      ),
      'name' => array(
        'predicates' => array(
          'foaf:name',
        ),
      ),
      'homepage' => array(
        'predicates' => array(
          'foaf:page',
        ),
        'type' => 'rel',
      ),
    ),
  ),
);
