feels_like_rails
================

### Tested on
CodeIgniter 2.1.2
PHP 5.3+

### Instalation

Merge the application folder to your application folder

### Feature

1. You can use find_by_(your_field_name) and find_all

```php
// In Model
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Group extends MY_Model {

    public $table_name = 'groups';

    public function __construct() {
        parent::__construct();
    }

}


// In Controller
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller{
    public $table_name = 'groups';

    public function __construct() {
        parent::__construct();
        $this->load->model('Group');
    }

    public function index(){
        $data['groups'] = $this->Group->find_all();
        $this->load->view('index_group', $data);
    }

    public function overview($id = null){
        $data['group'] = $this->Group->find_by_id($id);
        $this->load->view('overview_group', $data);
    }
}
```
