# Yii 2 Test Application

## Содержание
- [Загрузка](#download)
    - [Используя Composer](#download-composer)
    - [Используя Git](#download-git)
- [Настройка соединения с базой данных](#dbconnection)
- [Развертывание базы данных](#dbdeploy)
    - [Используя миграции](#dbdeploy-migrations)
    - [Используя дамп базы данных](#dbdeploy-dump)
- [Запуск](#launch)
    - [Используя встроенный в PHP веб-сервер](#launch-phpwebserver)
    - [Используя Vagrant](#launch-vagrant)

## <a name="download"></a> Загрузка
Для загрузки сторонних пакетов зависимостей приложения у вас должен быть установлен 
[Composer](https://getcomposer.org/) с плагином 
[composer-asset-plugin](https://packagist.org/packages/fxp/composer-asset-plugin), который используется для
установки пакетов зависимостей из [Bower](http://bower.io/) и [npm](https://www.npmjs.com/):
```
$ composer global require "fxp/composer-asset-plugin"
```

### <a name="download-composer"></a> Используя Composer
Загрузить приложение можно с помощью [Composer](https://getcomposer.org/):

```
$ composer create-project --prefer-dist --stability=dev kmarenov/yii2-app-test
```
### <a name="download-git"></a> Используя Git
Также можно клонировать репозиторий проекта с [GitHub](https://github.com/) используя [Git](https://git-scm.com/):

```
$ git clone https://github.com/kmarenov/yii2-app-test.git
```

И затем установить с помощью [Composer](https://getcomposer.org/) все необходимые пакеты зависимостей:

```
$ сd yii2-app-test
$ composer install --prefer-dist 
```

## <a name="dbconnection"></a> Настройка соединения с базой данных

В файле `config/db.php` необходимо указать параметры подключения к базе данных:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=test',
    'username' => 'root',
    'password' => 'mysqlroot',
    'charset' => 'utf8',
];
```
Саму базу данных необходимо создать вручную.

## <a name="dbdeploy"></a> Развертывание базы данных
### <a name="dbdeploy-migrations"></a> Используя миграции

Создать все таблицы, необходимые для работы приложения, и наполнить их тестовыми данными можно используя миграции.
Для этого необходимо запустить их с помощью консольного приложения `yii`

```
$ сd yii2-app-test
$ ./yii migrate
```

Выполнение миграций может занять достаточно много времени в связи с тем, что происходит наполнение базы данных
большим количеством тестовых записей, поэтому рекомендуется разворачивать базу данных используя готовый дамп
базы данных, созданной при помощи данных миграций.

### <a name="dbdeploy-dump"></a> Используя дамп базы данных

В корневом каталоге проекта находится файл `test.sql` c дампом базы данных, развернув который можно получить готовую 
базу данных, содержащую всё необходимое для работы приложения, включая тестовые записи.

Развернуть дамп можно с помощью утилиты `mysql`:

```
$ сd yii2-app-test
$ mysql -u root -p test < test.sql
```

## <a name="launch"></a> Запуск

Располагать приложение на веб-сервере следует таким образом, чтобы корневым каталогом веб-сервера являлся каталог
приложения `/web`

### <a name="launch-phpwebserver"></a> Используя встроенный в PHP веб-сервер

Запустить приложение можно используя встроенный в PHP веб-сервер. Для этого его нужно запустить из каталога `/web`

```
$ сd yii2-app-test/web
$ php -S localhost:8888 
```
После этого приложение будет доступно по адресу [http://localhost:8888/](http://localhost:8888/)

### <a name="launch-vagrant"></a> Используя Vagrant

Проект содержит готовые файлы конфигурации для [Vagrant](https://www.vagrantup.com/).

Для запуска с использованием Vagrant у вас должны быть установлены [VirtualBox](https://www.virtualbox.org/) и
[Vagrant](https://www.vagrantup.com/). Также для Vagrant рекомендуется установить плагин vagrant-vbguest,
который автоматически разрешает ситуацию в том случае, если версии VirtualBox Guest Additions на вашем компьютере
и внутри виртуальной машины различаются:

```
$ vagrant plugin install vagrant-vbguest 
```

Запуск виртуальной машины со всем необходимым окружением осуществляется с помощью команды `vagrant up` из
каталога проекта:

```
$ сd yii2-app-test
$ vagrant up
```

В том случае, если запуск приложения осуществляется с помощью Vagrant, нет необходимости вручную создавать базу данных.
Она автоматически создастся при развертывании виртуальной машины, и приложение будет корректно функционировать используя
те параметры подключения к базе данных, которые уже прописаны в файле `config/db.php`.

После запуска виртуальной машины приложение будет доступно по адресу [http://localhost:8888/](http://localhost:8888/)

При запуске с помощью Vagrant выполнять запуск миграций или развертывание дампа базы данных следует внутри виртуальной 
машины, поскольку предустановленный внутири неё сервер MySQL по умолчанию доступен только из неё самой.
Для этого необходимо перейти в каталог приложения внутри виртуальной машины, используя команды:
```
$ сd yii2-app-test
$ vagrant ssh
$ cd /vagrant
```
и затем произвести развертывание базы данных, выполнив запуск миграций:
```
$ ./yii migrate
```
или развертывание дампа база данных:
```
$ mysql -u root -p test < test.sql
```

Остановить виртуальную машину можно выполнив из каталога проекта команду `vagrant halt`:

```
$ сd yii2-app-test
$ vagrant halt
```