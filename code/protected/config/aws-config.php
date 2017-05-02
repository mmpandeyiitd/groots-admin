<?php
$config =  array(
    'includes' => array('_aws'),
    'services' => array(
        'default_settings' => array(
            'params' => array(
                'key'    => AWS_KEY,
                'secret' => AWS_SECRET_KEY,
                'region' => REGION
            )
        )
    )
);

?>