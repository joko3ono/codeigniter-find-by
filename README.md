feels_like_rails
================

Its my snippet when I write webs apps using CodeIgniter so it will be more like ruby_on_rails :D

### Tested on
CodeIgniter 2.1.2
PHP 5.3+

### Instalation

Merge the application folder to your application folder

### Feature

1. You can use function find_all (for selecting all the data in database),
dinamyc function find_by_your_field_name (will return 1 record) and 
dinamyc function find_all_by_your_field_name (will return array of data).

```php
// In Model we no need to load database library
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Group extends MY_Model {
    // table name that would be used by this model should be declared here
    public $table_name = 'groups';

    public function __construct() {
        parent::__construct();
    }

}


// In Controller we also no need to load database library
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller{

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

    public function parent($parent_id){
        $data['groups'] = $this->Group->find_all_by_parent_id($parent_id);
        $this->load->view('parent_group', $data);
    }
}
```

