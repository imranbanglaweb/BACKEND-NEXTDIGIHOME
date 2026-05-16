<?php

// Set OpenSSL config path for Windows XAMPP before loading - MUST be done first
if (PHP_OS === 'WINNT') {
    $opensslConf = __DIR__.'/../openssl.cnf';
    putenv('OPENSSL_CONF='.$opensslConf);
    $_ENV['OPENSSL_CONF'] = $opensslConf;
    $_SERVER['OPENSSL_CONF'] = $opensslConf;
}

return [

    /**
     * These are the keys for authentication (VAPID).
     * These keys must be safely stored and should not change.
     */
    'vapid' => [
        'subject' => 'mailto:md.imran1200@gmail.com',
        'public_key' => env('VAPID_PUBLIC_KEY', 'BH713nXU9JhRgVkli85ccpcAKlNIkEMfJFz1vPtCTHR7DgaBObtDyYAgsK72nQteTcEA-zKRoBTVvpDC9Z9vsG0'),
        'private_key' => env('VAPID_PRIVATE_KEY', 'hGmq08IRrmHwRH8wP5XmikzmjyeAtIOTq3hzua8Ph1k'),
    ],

    /**
     * This is model that will be used to for push subscriptions.
     */
    'model' => \NotificationChannels\WebPush\PushSubscription::class,

    /**
     * This is the name of the table that will be created by the migration and
     * used by the PushSubscription model shipped with this package.
     */
    'table_name' => env('WEBPUSH_DB_TABLE', 'push_subscriptions'),

    /**
     * This is the database connection that will be used by the migration and
     * the PushSubscription model shipped with this package.
     */
    'database_connection' => env('WEBPUSH_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),

    /**
     * The Guzzle client options used by Minishlink\WebPush.
     */
    'client_options' => [],

    /**
     * Google Cloud Messaging.
     *
     * @deprecated
     */
    'gcm' => [
        'key' => env('GCM_KEY'),
        'sender_id' => env('GCM_SENDER_ID'),
    ],

];
