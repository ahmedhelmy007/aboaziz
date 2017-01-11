<?php
// Classmap autoloading is faster, but requires adding each new class you create to the array within the 
// autoload_classmap.php file, which slows down development. The standard autoloader, however, doesn’t have this 
// requirement and will always load a class if its file is named correctly. This allows us to develop quickly by 
// creating new classes when we need them and then gain a performance boost by using the classmap autoloader in 
// production. Zend Framework 2 provides bin/classmap_generator.php to create and update the file.

return array();
