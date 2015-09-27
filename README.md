# Simpla CMS для PHP картриджа OpenShift

Данный репозиторий содержит инсталяцию [Simpla CMS](http://simplacms.ru/) пригодную для использования в облаке OpenShift. Были удалены неиспользуемые файлы, лицензии и др. За оригинальной структурой директорий и содержимого файлов обращайтесь к оригинальному скрипту Simpla CMS.

## Как этим пользоватья

Добавлена директория **`.openshift`** в которой присутствует скрипт-хук ([post_deploy](https://developers.openshift.com/en/managing-action-hooks.html#_build_action_hooks)) для развертывания инсталяции, а так-же набор конфигурационных файлов:

* **`deny.htaccess`** - применяется для установки запрета доступа в директории `files`
* **`type.htaccess`** - применяется для отключения обработчиков некоторых типов файлов в директории `files`
* **`simpla.htaccess`** - адаптированная версия файла `simpla/.htaccess`

Для использования Вам потребуется отредактировать следующие файлы в этой директории:

* **`simpla.passwd`** - аналог `simpla/.passwd`
* **`config.php`** - аналог `config/config.php`, допускает использование [переменных окружения OpenShift](https://developers.openshift.com/en/managing-environment-variables.html)
* **`root.thaccess`** - адаптированная версия файла `.htaccess`, допускает использование переменных окружения OpenShift, для правильной работы этого файла может быть необходима правка `post_deploy`
* **`robots.txt`** - адаптированная версия одноименного файла, допускает использование переменных окружения OpenShift, для правильной работы этого файла может быть необходима правка `post_deploy`

Корневой **`.gitignore`** содержит пути ко всем файлам и каталогам, что будут перезаписаны скриптом `post_deploy`:

* **`/simpla/.htaccess`** - будет создан из `simpla.htaccess` (не сохраняется)
* **`/simpla/.passwd`** - будет создан из `simpla.passwd` (не сохраняется)
* **`/simpla/cml/temp`** - будет ссылаться на `${OPENSHIFT_TMP_DIR}temp` (ссылка на временный файл)
* **`/simpla/design/compiled`** - будет ссылаться на `${OPENSHIFT_TMP_DIR}compiled/admin` (ссылка на временный файл)
* **`/config/config.php`** - будет создан из `config.php` (не сохраняется)
* **`/cache`** - будет ссылаться на `${OPENSHIFT_TMP_DIR}cache` (ссылка на временный файл)
* **`/compiled`** - будет ссылаться на `${OPENSHIFT_TMP_DIR}compiled/theme` (ссылка на временный файл)
* **`/files`** - будет ссылаться на `${OPENSHIFT_DATA_DIR}files` (ссылка на постоянный файл)

Таким образом, медиафайлы будут в постоянном хранилище.

## Работа в кластере

Был модифицирован файл `api/Database.php` для работы с MySQL на выделенном сервере. Добавлена настрока порта в файл `config.php`.

## Работа с письмами

Почтовый сервис на OpenShift отсутствует, в связи с этим был внесён патч в API Simpla CMS. Был изменен файл `api/Notify.php`. Изменения довляют зависимость от класса [Mail](https://pear.php.net/package/Mail) предоставляемого PHAR (зависимость учтена в `.openshift/pear.txt`).

В файл настройки `config.php` был добавлен раздел содержащий настройки SMTP:

* **`smtp_host`** - сервер SMTP шлюза
* **`smtp_port`** - порт доступа к SMTP
* **`smtp_auth`** - метод аутентификации (например, без аутентификации `false` или простая аутентификация `"PLAIN"`)
* **`smtp_username`** - имя пользователя SMTP
* **`smtp_password`** - пароль пользователя SMTP
* **`smtp_from`** - обратный адрес (некоторые SMTP требуют что бы это значение было идентично `smtp_username`)

## Исправление определения HTTPS

Оригинальный скрипт при определении использования HTTPS пологается на переменную окружения сервера `SERVER_PROTOCOL` или `SERVER_PORT`. На сервере OpenShift данные переменные всегда будет иметь значение `HTTP/1.1` и `80` соответственно, по этому был внесен патч в файл `api/Config.php`. Теперь HTTPS определяется наличием и значением переменной окружения сервера `HTTP_X_FORWARDED_PROTO`.

## Пример `config.php`

```
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
```
## Вопросы лицензи

Данная установка предоставляется как есть и полностью зависит от лицензии на Simpla CMS и не несет иных ограничений или прав. За подробностями обращайтесь к оригинальному скрипту.
