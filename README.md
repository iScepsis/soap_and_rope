I hate SOAP and not recommend use that #@*!! protocol, but people still use it! WTF?!?! So, therefore I created this 
template of SOAP server, that not remember all this rubbish any time when the curse overtake me again.

Project configuration:
----------------------

For default config params placed in directory *config/ini/* . You can change this path in *commands/ConfigureController.php*, 
here is kept the configurator for project. He is creating config files from *config/\*.php.install* files and replace params 
(whose marked as *{some_param}*) from *.ini* files. In *.ini* files listed only main params, but you can change/add/remove them
in *config/\*.php.install* file.

So, for default configure project, run in a console:
        
        php yii configure/create staging.ini

Also you can add another one *.ini* file:

        php yii configure/create staging1.ini staging2.ini
        
Params from second *.ini* file have more priority and if in files will be a same param, the configurator get that param from
second file. It can be useful for deploy settings.

SOAP settings:
-------------
This template use library from subdee/yii2-soap-server, you can read more about it in his github repository:
<a href="https://github.com/subdee/yii2-soap-server" target="_blank">https://github.com/subdee/yii2-soap-server</a>

This library generate wsdl from your Controllers and make life more easy.

In this template I had added basic http authentication (you can disable it in config/params.php - param "needAuth").