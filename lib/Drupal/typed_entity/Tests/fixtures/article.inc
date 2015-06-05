<?php

$fixture = array(
  'bundle' => 'article',
  'entity keys' =>
    array(
      'id' => 'nid',
      'revision' => 'vid',
      'bundle' => 'type',
      'label' => 'title',
      'language' => 'language',
    ),
  'entity' => (object) array(
    'vid' => '1',
    'uid' => '1',
    'title' => 'Lorem ipsum dolor sit amet, consetetur sadipscing',
    'log' => '',
    'status' => '1',
    'comment' => '2',
    'promote' => '1',
    'sticky' => '0',
    'nid' => '1',
    'type' => 'article',
    'language' => 'en',
    'created' => '1368005430',
    'changed' => '1369320916',
    'tnid' => '0',
    'translate' => '0',
    'revision_timestamp' => '1369320916',
    'revision_uid' => '1',
    'body' =>
      array(
        'und' =>
          array(
            0 =>
              array(
                'value' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
                'summary' => '',
                'format' => 'filtered_html',
                'safe_value' => '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
',
                'safe_summary' => '',
              ),
          ),
      ),
    'field_tags' =>
      array(
        'und' =>
          array(
            0 =>
              array(
                'tid' => '1',
              ),
          ),
      ),
    'field_image' =>
      array(
        'und' =>
          array(
            0 =>
              array(
                'fid' => '1',
                'uid' => '1',
                'filename' => 'DSCF2211.jpg',
                'uri' => 'public://field/image/DSCF2211.jpg',
                'filemime' => 'image/jpeg',
                'filesize' => '46156',
                'status' => '1',
                'timestamp' => '1424800819',
                'type' => 'image',
                'field_file_image_alt_text' =>
                  array(),
                'field_file_image_title_text' =>
                  array(),
                'rdf_mapping' =>
                  array(),
                'metadata' =>
                  array(
                    'height' => 320,
                    'width' => 180,
                  ),
                'alt' => '',
                'title' => '',
                'width' => '180',
                'height' => '320',
              ),
          ),
      ),
    'field_facebook_pub' =>
      array(
        'und' =>
          array(
            0 =>
              array(
                'target_id' => '3',
              ),
          ),
      ),
    'field_it2' =>
      array(),
    'rdf_mapping' =>
      array(
        'field_image' =>
          array(
            'predicates' =>
              array(
                0 => 'og:image',
                1 => 'rdfs:seeAlso',
              ),
            'type' => 'rel',
          ),
        'field_tags' =>
          array(
            'predicates' =>
              array(
                0 => 'dc:subject',
              ),
            'type' => 'rel',
          ),
        'rdftype' =>
          array(
            0 => 'sioc:Item',
            1 => 'foaf:Document',
          ),
        'title' =>
          array(
            'predicates' =>
              array(
                0 => 'dc:title',
              ),
          ),
        'created' =>
          array(
            'predicates' =>
              array(
                0 => 'dc:date',
                1 => 'dc:created',
              ),
            'datatype' => 'xsd:dateTime',
            'callback' => 'date_iso8601',
          ),
        'changed' =>
          array(
            'predicates' =>
              array(
                0 => 'dc:modified',
              ),
            'datatype' => 'xsd:dateTime',
            'callback' => 'date_iso8601',
          ),
        'body' =>
          array(
            'predicates' =>
              array(
                0 => 'content:encoded',
              ),
          ),
        'uid' =>
          array(
            'predicates' =>
              array(
                0 => 'sioc:has_creator',
              ),
            'type' => 'rel',
          ),
        'name' =>
          array(
            'predicates' =>
              array(
                0 => 'foaf:name',
              ),
          ),
        'comment_count' =>
          array(
            'predicates' =>
              array(
                0 => 'sioc:num_replies',
              ),
            'datatype' => 'xsd:integer',
          ),
        'last_activity' =>
          array(
            'predicates' =>
              array(
                0 => 'sioc:last_activity_date',
              ),
            'datatype' => 'xsd:dateTime',
            'callback' => 'date_iso8601',
          ),
      ),
    'cid' => '9',
    'last_comment_timestamp' => '1405499171',
    'last_comment_name' => '',
    'last_comment_uid' => '1',
    'comment_count' => '9',
    'name' => 'admin',
    'picture' => '0',
    'data' => 'b:0;',
  ),
);
