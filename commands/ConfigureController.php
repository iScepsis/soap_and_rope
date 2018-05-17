<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class ConfigureController extends Controller
{
    protected static $strEnd = "\n";

    protected $mainConfig = [];
    protected $iniPath = 'config/ini';
    protected $files = [
        'file_web_index'=> 'web/index.php',
        'file_db'=>'config/db.php',
        'file_params'=>'config/params.php',
        'file_web'=>'config/web.php',
    ];
    protected $filePostfix = '.install';
    protected $lt = '{';
    protected $rt = '}';

    /**
     * Создаем конфигурационные файлы для проекта
     * @param $mainConfig
     * @param null $changeList
     * @return int
     */
    public function actionCreate($mainConfig, $changeList = null)
    {
        $this->mainConfig = $this->readConfigFile($mainConfig);
        if (!empty($changeList)) $this->mainConfig = $this->readConfigFile($changeList, true);

        foreach ($this->files as $mainConfigSection => $filename) {
            if (!empty($this->mainConfig[$mainConfigSection])) {
                self::println("Section " . $mainConfigSection . ". File " . $filename);
                $this->changeFile(
                    $filename . $this->filePostfix,
                    $filename,
                    $this->mainConfig[$mainConfigSection]
                );
            }
        }

        return ExitCode::OK;
    }

    /**
     * Выводим сообщение с переводом строки
     * @param string $message
     */
    public static function println($message = ''){
        echo $message . self::$strEnd;
    }

    /**
     * Читаем параметры из ini файлов
     * @param $file
     * @param bool $fromRootDir
     * @return array|int
     */
    protected function readConfigFile($file, $fromRootDir = false){
        self::println("Read file " . $file);
        $path = $fromRootDir ? dirname(__DIR__) . '/' . $file
                             : dirname(__DIR__) . '/' . $this->iniPath . '/' . $file;
        $confFile = parse_ini_file($path, true);
        if (!$confFile) {
            return ExitCode::DATAERR;
        };
        return array_replace_recursive($this->mainConfig, $confFile);
    }

    /**
     * Функция изменяет параметры файлов конфигурации
     * @param $filenameInput - имя файла с контентом для изменения
     * @param $filenameOutput - имя файла, куда будет записан измененный контент
     * @param $mainConfigSection - массив, что (ключ) а что (значение) заменить
     * @param bool $preg - использовать preg_replace вместо str_replace
     */
    protected function changeFile($filenameInput,$filenameOutput,$mainConfigSection,$preg=false)
    {
        $fiName = dirname(__DIR__) . '/' . $filenameInput;
        $foName = dirname(__DIR__) . '/' . $filenameOutput;
        
        if (file_exists($fiName)) {
            $fileInput = fopen($fiName, "r");
            $fileContent = fread($fileInput, filesize($fiName));
            fclose($fileInput);
            foreach ($mainConfigSection as $mainConfigKey => $mainConfigValue) {
                if($preg) {
                    $fileContent = preg_replace($this->lt . $mainConfigKey . $this->rt, $mainConfigValue, $fileContent);
                } else {
                    $fileContent = str_replace($this->lt . $mainConfigKey . $this->rt, $mainConfigValue, $fileContent);
                }
            }
            $fileOutput = fopen($foName, "w");
            fwrite($fileOutput, $fileContent);
            fclose($fileOutput);
        }
    }


}
