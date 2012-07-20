find_by_magic for codeigniter
================

Its my snippet of 'MY_Model' I ussualy used in my project when build web aps with CodeIgniter
No need to load library database anymore.

### Tested on
CodeIgniter 2.1.2
PHP 5.3+

### Instalation

Merge the application folder to your application folder and set your model extends to MY_Model
so our model will looks like 

```php
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Group extends MY_Model {
    // table name that would be used by this model should be declared here
    public $table_name = 'groups';

    public function __construct() {
        parent::__construct();
    }

}
```

### Usage

1. find_by_field_name(parameter)

```php
$this->load->model('Group', 'group');
$this->group->find_by_id(1);
//this code will generate
// SELECT * FROM groups WHERE groups.id = 1 LIMIT 0, 1
```

2. find_all_by_field_name(parameter)

```php
$this->load->model('Group', 'group');
$this->group->find_all_by_id(1);
//this code will generate
// SELECT * FROM groups WHERE groups.id = 1
```

3. find_by_field_name_and_field_name(param1, param2) & find_all_by_field_name_and_field_name(param1, param2)

We can find_by function with unlimited parameter as long as the field is on the same table.

example
```php
$this->load->model('Group', 'group');
$this->group->find_all_by_name_and_parent('lorem', 'ipsum');
//this will generate Query SELECT * FROM groups WHERE groups.name = 'lorem' AND groups.parent = 'ipsum'
```
