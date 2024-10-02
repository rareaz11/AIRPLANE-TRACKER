<?php
//for fatal error
//like requierd file
set_exception_handler(array('AppCore', 'handleException'));
//for warning
//like get empty
set_error_handler(array("AppCore",'handleErrorexception'));

?>