<?php return array (
  'app' => 
  array (
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost',
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'key' => 'base64:b47v+AO8ABSmGPx718/F2sVNj/pht5VH0fqVVgTkbic=',
    'cipher' => 'AES-256-CBC',
    'log' => 'single',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      13 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      14 => 'Illuminate\\Queue\\QueueServiceProvider',
      15 => 'Illuminate\\Redis\\RedisServiceProvider',
      16 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      17 => 'Illuminate\\Session\\SessionServiceProvider',
      18 => 'Illuminate\\Translation\\TranslationServiceProvider',
      19 => 'Illuminate\\Validation\\ValidationServiceProvider',
      20 => 'Illuminate\\View\\ViewServiceProvider',
      21 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      22 => 'App\\Providers\\AppServiceProvider',
      23 => 'App\\Providers\\EventServiceProvider',
      24 => 'App\\Providers\\RouteServiceProvider',
      25 => 'App\\Providers\\BroadcastServiceProvider',
      26 => 'Collective\\Html\\HtmlServiceProvider',
      27 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
      28 => 'Phaza\\LaravelPostgis\\DatabaseServiceProvider',
      29 => 'Yajra\\Datatables\\DatatablesServiceProvider',
      30 => 'Laracasts\\Flash\\FlashServiceProvider',
      31 => 'Zizaco\\Entrust\\EntrustServiceProvider',
      32 => 'Barryvdh\\Snappy\\ServiceProvider',
      33 => 'Intervention\\Image\\ImageServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Input' => 'Illuminate\\Support\\Facades\\Input',
      'Inspiring' => 'Illuminate\\Foundation\\Inspiring',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Form' => 'Collective\\Html\\FormFacade',
      'Html' => 'Collective\\Html\\HtmlFacade',
      'Flash' => 'Laracasts\\Flash\\Flash',
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
      'Datatables' => 'yajra\\Datatables\\Datatables',
      'Entrust' => 'Zizaco\\Entrust\\EntrustFacade',
      'DataTables' => 'Yajra\\DataTables\\Facades\\DataTables',
      'Pusher' => 'Pusher\\Pusher',
      'PDF' => 'Barryvdh\\Snappy\\Facades\\SnappyPdf',
      'SnappyImage' => 'Barryvdh\\Snappy\\Facades\\SnappyImage',
      'Image' => 'Intervention\\Image\\Facades\\Image',
      'ChannelLog' => 'App\\Contracts\\Facades\\ChannelLog',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'token',
        'provider' => 'users',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'email' => 'auth.emails.password',
        'table' => 'password_resets',
        'expire' => 60,
      ),
    ),
    'old' => 
    array (
      'driver' => 'eloquent',
      'model' => 'App\\User',
      'table' => 'users',
      'password' => 
      array (
        'email' => 'emails.password',
        'table' => 'password_resets',
        'expire' => 60,
      ),
      'providers' => 
      array (
        'users' => 
        array (
          'driver' => 'eloquent',
          'model' => 'App\\User',
          'table' => 'users',
        ),
      ),
    ),
  ),
  'backup' => 
  array (
    'backup' => 
    array (
      'name' => 'Dharan-GMIS',
      'source' => 
      array (
        'files' => 
        array (
          'include' => 
          array (
            0 => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0',
          ),
          'exclude' => 
          array (
            0 => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\vendor',
            1 => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\node_modules',
            2 => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\nbproject',
            3 => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\storage/app/public/buildings',
          ),
          'followLinks' => false,
        ),
        'databases' => 
        array (
          0 => 'pgsql',
        ),
      ),
      'database_dump_compressor' => NULL,
      'destination' => 
      array (
        'filename_prefix' => '',
        'disks' => 
        array (
          0 => 'local',
        ),
      ),
      'temporary_directory' => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\storage\\app/backup-temp',
      'database_dump_file_extension' => 'backup',
    ),
    'notifications' => 
    array (
      'notifications' => 
      array (
        'Spatie\\Backup\\Notifications\\Notifications\\BackupHasFailed' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\UnhealthyBackupWasFound' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\CleanupHasFailed' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\BackupWasSuccessful' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\HealthyBackupWasFound' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\CleanupWasSuccessful' => 
        array (
          0 => 'mail',
        ),
      ),
      'notifiable' => 'Spatie\\Backup\\Notifications\\Notifiable',
      'mail' => 
      array (
        'to' => 'your@example.com',
      ),
      'slack' => 
      array (
        'webhook_url' => '',
        'channel' => NULL,
        'username' => NULL,
        'icon' => NULL,
      ),
    ),
    'monitorBackups' => 
    array (
      0 => 
      array (
        'name' => 'Dharan-GMIS',
        'disks' => 
        array (
          0 => 'local',
        ),
        'newestBackupsShouldNotBeOlderThanDays' => 1,
        'storageUsedMayNotBeHigherThanMegabytes' => 5000,
      ),
    ),
    'cleanup' => 
    array (
      'strategy' => 'Spatie\\Backup\\Tasks\\Cleanup\\Strategies\\DefaultStrategy',
      'defaultStrategy' => 
      array (
        'keepAllBackupsForDays' => 7,
        'keepDailyBackupsForDays' => 16,
        'keepWeeklyBackupsForWeeks' => 8,
        'keepMonthlyBackupsForMonths' => 4,
        'keepYearlyBackupsForYears' => 2,
        'deleteOldestBackupsWhenUsingMoreMegabytesThan' => 5000,
      ),
    ),
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
    ),
  ),
  'business-taxpayment-info' => 
  array (
    'fnc_create_businesstaxpaymentstatus' => '
        DROP FUNCTION IF EXISTS fnc_businesstaxpaymentstatus();
        CREATE OR REPLACE FUNCTION fnc_businesstaxpaymentstatus()
        Returns Boolean
        LANGUAGE plpgsql AS $$
        BEGIN
            DROP TABLE IF EXISTS business_tax_payment_status CASCADE;
                
            CREATE TABLE business_tax_payment_status AS
            SELECT btp.id as business_tax_payment_id, btp.registration as registration, b.ward,  
                CASE 
                    WHEN btp.tax_paid_end_at is NULL THEN 99    
                    WHEN btp.tax_paid_end_at is not NULL THEN 
                    CASE
                        WHEN date_part(\'year\', AGE(ndt.fiscal_year_end::date, btp.tax_paid_end_at::date))::int > 5 THEN 5
                        ELSE date_part(\'year\', AGE(ndt.fiscal_year_end::date, btp.tax_paid_end_at::date))::int
                    END
                END as due_year,  
                Case 
                    WHEN btp.registration is not NULL AND b.registration is not NULL THEN TRUE
                    WHEN btp.registration is NULL or b.registration is NULL THEN False
                End as match,
                b.geom, Now() as created_at, Now() as updated_at
            FROM business_tax_payments btp LEFT join bldg_business_tax b on btp.registration=b.registration
            CROSS JOIN nepali_date_today ndt WHERE ndt.id = 2;
            Return True
        ;
        END
        $$;
    ',
  ),
  'cache' => 
  array (
    'default' => 'array',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\storage\\framework/cache',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
    ),
    'prefix' => 'laravel',
  ),
  'compile' => 
  array (
    'files' => 
    array (
    ),
    'providers' => 
    array (
    ),
  ),
  'constants' => 
  array (
    'GEOSERVER_WORKSPACE' => 'dharan_gmis',
    'GURL_URL' => 'http://10.10.10.15:8080/geoserver/dharan_gmis/',
    'PGSQL_BIN_PATH' => NULL,
    'AUTH_KEY' => NULL,
  ),
  'database' => 
  array (
    'fetch' => 8,
    'default' => 'pgsql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'database' => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\storage\\database.sqlite',
        'prefix' => '',
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'database' => 'dharangmis',
        'username' => 'postgres',
        'password' => 'postgres',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
        'strict' => false,
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'host' => '127.0.0.1',
        'port' => '5433',
        'database' => 'dharangmis',
        'username' => 'postgres',
        'password' => 'postgres',
        'charset' => 'utf8',
        'prefix' => '',
        'schema' => 'public',
        'dump' => 
        array (
          'dump_binary_path' => '/var/lib/postgresql/10',
          0 => 'use_single_transaction',
          'timeout' => 300,
          'add_extra_option' => '--format=c',
        ),
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'host' => '127.0.0.1',
        'database' => 'dharangmis',
        'username' => 'postgres',
        'password' => 'postgres',
        'charset' => 'utf8',
        'prefix' => '',
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'cluster' => false,
      'default' => 
      array (
        'host' => '127.0.0.1',
        'port' => 6379,
        'database' => 0,
      ),
    ),
  ),
  'datatables' => 
  array (
    'search' => 
    array (
      'case_insensitive' => true,
      'use_wildcards' => false,
    ),
    'index_column' => 'DT_RowIndex',
    'engines' => 
    array (
      'eloquent' => 'Yajra\\DataTables\\EloquentDataTable',
      'query' => 'Yajra\\DataTables\\QueryDataTable',
      'collection' => 'Yajra\\DataTables\\CollectionDataTable',
      'resource' => 'Yajra\\DataTables\\ApiResourceDataTable',
    ),
    'builders' => 
    array (
    ),
    'nulls_last_sql' => ':column :direction NULLS LAST',
    'error' => NULL,
    'columns' => 
    array (
      'excess' => 
      array (
        0 => 'rn',
        1 => 'row_num',
      ),
      'escape' => '*',
      'raw' => 
      array (
        0 => 'action',
      ),
      'blacklist' => 
      array (
        0 => 'password',
        1 => 'remember_token',
      ),
      'whitelist' => '*',
    ),
    'json' => 
    array (
      'header' => 
      array (
      ),
      'options' => 0,
    ),
  ),
  'entrust' => 
  array (
    'role' => 'App\\Role',
    'roles_table' => 'roles',
    'permission' => 'App\\Permission',
    'permissions_table' => 'permissions',
    'permission_role_table' => 'permission_role',
    'role_user_table' => 'role_user',
    'user_foreign_key' => 'user_id',
    'role_foreign_key' => 'role_id',
  ),
  'excel' => 
  array (
    'exports' => 
    array (
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => true,
        'include_separator_line' => false,
        'excel_compatibility' => false,
      ),
    ),
    'imports' => 
    array (
      'read_only' => true,
      'heading_row' => 
      array (
        'formatter' => 'slug',
      ),
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'escape_character' => '\\',
        'contiguous' => false,
        'input_encoding' => 'UTF-8',
      ),
    ),
    'extension_detector' => 
    array (
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ),
    'value_binder' => 
    array (
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ),
    'transactions' => 
    array (
      'handler' => 'db',
    ),
    'temporary_files' => 
    array (
      'local_path' => 'C:\\Users\\Admin\\AppData\\Local\\Temp',
      'remote_disk' => NULL,
      'remote_prefix' => NULL,
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\storage\\app',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\storage\\app/public',
        'url' => 'http://localhost/storage',
        'visibility' => 'public',
      ),
      'ftp' => 
      array (
        'driver' => 'ftp',
        'host' => 'ftp.example.com',
        'username' => 'your-username',
        'password' => 'your-password',
      ),
      'importtax' => 
      array (
        'driver' => 'local',
        'root' => 'D:\\taxpayment',
      ),
      'importbusinesstax' => 
      array (
        'driver' => 'local',
        'root' => 'D:\\businesstaxpayment',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => 'your-key',
        'secret' => 'your-secret',
        'region' => 'your-region',
        'bucket' => 'your-bucket',
      ),
      'rackspace' => 
      array (
        'driver' => 'rackspace',
        'username' => 'your-username',
        'key' => 'your-key',
        'container' => 'your-container',
        'endpoint' => 'https://identity.api.rackspacecloud.com/v2.0/',
        'region' => 'IAD',
        'url_type' => 'publicURL',
      ),
    ),
  ),
  'image' => 
  array (
    'driver' => 'gd',
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'deprecations' => NULL,
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\storage\\logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\storage\\logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\storage\\logs/laravel.log',
      ),
    ),
  ),
  'mail' => 
  array (
    'driver' => 'smtp',
    'host' => 'smtp.zoho.com',
    'port' => '587',
    'from' => 
    array (
      'address' => 'test@innovativesolution.com.np',
      'name' => 'Dharan-GMIS',
    ),
    'encryption' => 'TLS',
    'username' => 'test@innovativesolution.com.np',
    'password' => 'Test@321',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,
  ),
  'nepali-calendar' => 
  array (
    'invalid_date_bs' => 'The selected :attribute is not valid bs date.',
    'date_format' => 'YYYY-MM-DD',
    'return_type' => 'string',
    'lang' => 'np',
    'date_formats' => 
    array (
      0 => 'YYYY-MM-DD',
      1 => 'MM-DD-YYYY',
      2 => 'DD-MM-YYYY',
      3 => 'YYYY/MM/DD',
      4 => 'MM/DD/YYYY',
      5 => 'DD/MM/YYYY',
    ),
    'date_separators' => 
    array (
      'YYYY-MM-DD' => '-',
      'MM-DD-YYYY' => '-',
      'DD-MM-YYYY' => '-',
      'YYYY/MM/DD' => '/',
      'MM/DD/YYYY' => '/',
      'DD/MM/YYYY' => '/',
    ),
    'langs' => 
    array (
      0 => 'np',
      1 => 'en',
    ),
    'return_types' => 
    array (
      0 => 'array',
      1 => 'string',
    ),
    'calendar_types' => 
    array (
      0 => 'BS',
      1 => 'AD',
    ),
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'expire' => 60,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'ttr' => 60,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => 'your-public-key',
        'secret' => 'your-secret-key',
        'queue' => 'your-queue-url',
        'region' => 'us-east-1',
      ),
      'iron' => 
      array (
        'driver' => 'iron',
        'host' => 'mq-aws-us-east-1.iron.io',
        'token' => 'your-token',
        'project' => 'your-project-id',
        'queue' => 'your-queue-name',
        'encrypt' => true,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'expire' => 60,
      ),
    ),
    'failed' => 
    array (
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => '',
      'secret' => '',
    ),
    'mandrill' => 
    array (
      'secret' => '',
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'stripe' => 
    array (
      'model' => 'App\\User',
      'key' => '',
      'secret' => '',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => false,
  ),
  'snappy' => 
  array (
    'pdf' => 
    array (
      'enabled' => true,
      'binary' => '"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe"',
      'timeout' => false,
      'options' => 
      array (
      ),
      'env' => 
      array (
      ),
    ),
    'image' => 
    array (
      'enabled' => true,
      'binary' => '/usr/local/bin/wkhtmltoimage',
      'timeout' => false,
      'options' => 
      array (
      ),
      'env' => 
      array (
      ),
    ),
  ),
  'taxpayment-info' => 
  array (
    'fnc_create_bldgtaxpaymentstatus' => '
        DROP FUNCTION IF EXISTS fnc_bldgtaxpaymentstatus();
        CREATE OR REPLACE FUNCTION fnc_bldgtaxpaymentstatus()
        Returns Boolean
        LANGUAGE plpgsql AS $$
        BEGIN
            DROP TABLE IF EXISTS bldg_tax_payment_status CASCADE;
            CREATE TABLE bldg_tax_payment_status AS
            SELECT btp.id as bldg_tax_payments_id, b.bin as bin, b.ward,  
                Case 
                    WHEN btp.owner_name is not NULL THEN btp.owner_name
                    ELSE b.hownr
                End as owner_name,
                CASE 
                    WHEN btp.tax_paid_end_at is NULL THEN 99    
                    WHEN btp.tax_paid_end_at is not NULL THEN 
                    CASE
                        WHEN date_part(\'year\', AGE(ndt.fiscal_year_end::date, btp.tax_paid_end_at::date))::int > 5 THEN 5
                        ELSE date_part(\'year\', AGE(ndt.fiscal_year_end::date, btp.tax_paid_end_at::date))::int
                    END
                END as due_year,  
                Case 
                    WHEN btp.bin is not NULL AND b.bin is not NULL THEN TRUE
                    WHEN btp.bin is NULL or b.bin is NULL THEN False
                End as match,
                b.geom, Now() as created_at, Now() as updated_at
            FROM bldg b LEFT JOIN (SELECT DISTINCT ON (bin) id, bin, owner_name, fiscal_year, tax_paid_end_at  FROM bldg_tax_payments
) btp on btp.bin=b.bin
            CROSS JOIN nepali_date_today ndt WHERE ndt.id = 1;
            
            Return True
        ;
        END
        $$;
    ',
    'fnc_insrtupd_taxbuildowner' => '
        -- DROP FUNCTION IF EXISTS fnc_insrtupd_taxbuildowner();    
        CREATE OR REPLACE FUNCTION fnc_insrtupd_taxbuildowner()
        Returns Boolean
        LANGUAGE plpgsql AS $$
        BEGIN
            ALTER TABLE bldg_owners DROP CONSTRAINT IF EXISTS bldg_owners_bin_unique;
            ALTER TABLE bldg_owners ADD CONSTRAINT bldg_owners_bin_unique UNIQUE (bin);

            with tax_data as (
                SELECT t.bin, t.owner_name
                FROM bldg_tax_payment_status t 
                Left Join bldg_owners o ON o.bin = t.bin 
                
            )
            INSERT INTO bldg_owners (bin, owner_name, created_at)
                SELECT bin, owner_name, NOW() FROM tax_data
                ON CONFLICT ON CONSTRAINT bldg_owners_bin_unique
                DO 
                UPDATE SET bin=excluded.bin, owner_name = excluded.owner_name, updated_at=NOW();
                
            Return True
        ;
        END
        $$;
    ',
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\resources\\views',
    ),
    'compiled' => 'D:\\programs-files\\wamp64\\www\\dharangmis2.0\\storage\\framework\\views',
  ),
  'postgis' => 
  array (
    'schema' => 'public',
  ),
);
