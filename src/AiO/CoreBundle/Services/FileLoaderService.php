<?php

namespace AiO\CoreBundle\Services;

use Symfony\Component\Yaml\Parser;

class FileLoaderService
{
    public function get($key)
    {
        $yaml = new Parser();
        $file = $yaml->parse(file_get_contents(__DIR__ . '/../Resources/translations/AiOCoreBundle.ru.yml'));

        if (array_key_exists($key, $file))
            return $file[$key];
        else
            return $file['no_message'];
    }

}
