;<? exit(); ?>

license = ""

[database]
db_server = "${OPENSHIFT_MYSQL_DB_HOST}"
db_port = "${OPENSHIFT_MYSQL_DB_PORT}"
db_user = "${OPENSHIFT_MYSQL_DB_USER}"
db_password = "${OPENSHIFT_MYSQL_DB_PASSWORD}"
db_name = "${OPENSHIFT_APP_NAME}"
db_prefix = "s_"
db_charset = "UTF8"
db_sql_mode = ""
db_timezone = "+04:00"

[php]
error_reporting = 0
php_charset = "UTF8"
php_locale_collate = "ru_RU"
php_locale_ctype = "ru_RU"
php_locale_monetary = "ru_RU"
php_locale_numeric = "ru_RU"
php_locale_time = "ru_RU"
php_timezone = "Europe/Moscow"
logfile = "${OPENSHIFT_LOG_DIR}simpla.log"

[smarty]
smarty_compile_check = true
smarty_caching = false
smarty_cache_lifetime = 0
smarty_debugging = false
smarty_html_minify = false

[images]
use_imagick = true
original_images_dir = "files/originals/"
resized_images_dir = "files/products/"
categories_images_dir = "files/categories/"
brands_images_dir = "files/brands/"
watermark_file = "simpla/files/watermark/watermark.png"

[files]
downloads_dir = "files/downloads/"

[smtp]
smtp_host = ""
smtp_port = 25
smtp_auth = "PLAIN"
smtp_username = ""
smtp_password = ""
smtp_from = ""

