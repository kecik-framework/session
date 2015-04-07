**Kecik Session**
==========
A library created specifically for Kecik Framework, this library was made to facilitate the use session on project we build. This library also supports data encryption so that we secure the data session.

**Installation**
-----------
Add the following line to the file composer.json located on the project we want to build.
```json
{
    "require": {
        "kecik/kecik": "1.0.2-alpha",
        "kecik/session": "dev-master"
    }
}
```

Next, run the command
```shell
composer update
```

And wait until the update process is completed without error.

> **Note**: This library requires Kecik Framework, so we need to install  Kecik Framework first, then we can install this library.

## **How to use Session Library**

```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
```
Whereas if you want the session in an encrypted then we simply add the config encryption

```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();

//Config untuk enkripsi session
$app->config->set('session.encrypt', TRUE);
$session = new Kecik\Session($app);
```

### **id()**
This Function/Method use for get session id.
**Example**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
echo $session->id();
```

### **newId()**
This Function/Method use to make new session id.
**Example**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
echo 'ID SESSION: '.$session->id().'<br />';
echo 'NEW ID SESSION: '.$session->newId().'<br />';
```

### **set()**
This Function/Method use for create/update a session.
```php
set(string $name, mixed $value)
```
**Example**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
$session->set('integer', 123);
$session->set('string', 'satu dua tiga');
$session->set('array', array('satu', 'dua', 'tiga'));
```

### **get()**
This Function/Method for get a value from a session.
```php
get(string $name)
```
**Example**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
$session->set('integer', 123);
$session->set('string', 'satu dua tiga');
$session->set('array', array('satu', 'dua', 'tiga'));

echo 'session Integer: '.$session->get('integer').'<br />';
echo 'session String: '.$session->get('string').'<br />';
echo 'Session Array: ';
print_r($session->get('array'));
```

### **delete()**
This Function/Method use for delete a session.
```php
delete(string $name)
```
**Example**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
$session->set('kecik_session', 'ini nilai session nya');

echo 'kecik_session: '.$session->get('kecik_session').'<br />';

$session->delete('kecik_session');
echo 'kecik_session: '.$session->get('kecik_session').'<br />';
```

### **clear()**
This Function/Method use for delete all session are exist.
**Example**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);

$session->clear();
```

### **setExpire()**
This Function/Method use for setting expiry from session.
```php
setExpire(int $minute);
```
**Example**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);

$session->setExpire(60);  //session akan kadarluarsa setelah 60 menit/1 jam
```

### **getExpire()**
This Function/Method use for get value expiry session.
**Example**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
echo $session->getExpire();
```
