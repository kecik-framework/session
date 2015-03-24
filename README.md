**Kecik Session**
==========
Merupakan pustaka/library yang dibuat khusus Framework Kecik, pustaka/library ini dibuat untuk mempermudah dalam menggunakan session pada project yang kita bangun. Pustaka/Library ini juga mendukung enkripsi data sehingga data session kita aman.

**Installasi**
-----------
Tambahkan baris berikut ini pada file composer.json yang berlokasi pada project yang ingin kita bangun.
```json
{
    "require": {
        "kecik/kecik": "1.0.2-alpha",
        "kecik/session": "dev-master"
    }
}
```

Selanjutnya jalan kan perintah 
```shell
composer update
```

Dan tunggu sampai proses update selesai tanpa error.
> **Catatan**: Pustaka/Library ini membutuhkan Kecik Framework, jadi kita harus menginstall Kecik Framework terlebih dahulu, baru kita bisa menginstall Pustaka/Library ini.

## **Cara Pakai Pustaka/Library Session**

```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
```
Sedangkan jika inginkan session dalam keadaan terenkripsi maka kita cukup menambahkan config enkripsi

```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();

//Config untuk enkripsi session
$app->config->set('session.encrypt', TRUE);
$session = new Kecik\Session($app);
```

### **id()**
Fungsi/Method ini digunakan untuk mendapatkan id dari session.
**contoh**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
echo $session->id();
```

### **newId()**
Fungsi/Method ini digunakan untuk membuat id session yang baru.
**contoh**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
echo 'ID SESSION: '.$session->id().'<br />';
echo 'NEW ID SESSION: '.$session->newId().'<br />';
```

### **set()**
Fungsi /Method ini digunakan untuk membuat/mengupdate sebuah session.
```php
set(string $name, mixed $value)
```
**contoh**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
session->set('integer', 123);
session->set('string', 'satu dua tiga');
session->set('array', array('satu', 'dua', 'tiga'));
```

### **get()**
Fungsi/Method ini digunakan untuk mendapatkan nilai dari suatu session.
```php
get(string $name)
```
**Contoh**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
session->set('integer', 123);
session->set('string', 'satu dua tiga');
session->set('array', array('satu', 'dua', 'tiga'));

echo 'session Integer: '.$session->get('integer').'<br />';
echo 'session String: '.$session->get('string').'<br />';
echo 'Session Array: ';
print_r($session->get('array'));
```

### **delete()**
Fungsi/Method ini digunakan untuk menghapus sebuah session.
```php
delete(string $name)
```
**Contoh**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
session->set('kecik_session', 'ini nilai session nya');

echo 'kecik_session: '.$session->get('kecik_session').'<br />';

$session->delete('kecik_session');
echo 'kecik_session: '.$session->get('kecik_session').'<br />';
```

### **clear()**
Fungsi/Method ini digunakan untuk menghapus semua session yang ada.
**Contoh**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);

$session->clear();
```

### **setExpire()**
Fungsi/Method ini digunakan untuk melakukan setting kadarluarsa dari session.
```php
setExpire(int $minute);
```
**Contoh**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);

$session->setExpire(60);  //session akan kadarluarsa setelah 60 menit/1 jam
```

### **getExpire()**
Fungsi/Method ini untuk mendapatkan nilai mengenai berapa lama session tersebut akan bertahan atau akan kadarluarsa.
**Contoh**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$session = new Kecik\Session($app);
echo $session->getExpire();
```
