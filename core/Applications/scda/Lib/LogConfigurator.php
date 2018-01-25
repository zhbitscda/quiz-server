<?php


class InfoLogConfigurator implements LoggerConfigurator {
	
    public function configure(LoggerHierarchy $hierarchy, $input = null) {

        $layout = new LoggerLayoutPattern();
        $layout->setConversionPattern("[%date]%msg%newline");
        $layout->activateOptions();

        // 流水日志
        $infoFile = new LoggerAppenderFile('sinihi_info');
        $fileName = sprintf(BASE_DIR . "/Logs/%s_sinihi_info.log", date("Ymd"));
        $infoFile->setFile($fileName);
        $infoFile->setAppend(true);

        $infoFile->setThreshold('info');
        $infoFile->activateOptions();
        $infoFile->setLayout($layout);

        $root = $hierarchy->getRootLogger();
        $root->addAppender($infoFile);
    }
}


class ErrLogConfigurator implements LoggerConfigurator {

    public function configure(LoggerHierarchy $hierarchy, $input = null) {

        $layout = new LoggerLayoutPattern();
        $layout->setConversionPattern("[%date]%msg%newline");
        $layout->activateOptions();


        // 错误日志
        $errFile = new LoggerAppenderFile('sinihi_err');
        $fileName = sprintf(BASE_DIR . "/Logs/%s_sinihi_err.log", date("Ymd"));
        $errFile->setFile($fileName);
        $errFile->setAppend(true);

        $errFile->setThreshold('info');
        $errFile->activateOptions();
        $errFile->setLayout($layout);

        $root = $hierarchy->getRootLogger();
        $root->addAppender($errFile);

    }
}
?>