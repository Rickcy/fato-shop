<?php


namespace  app\modules\integration\interfaces;


interface ExportFieldsInterface
{
    /**
     * @param null $context
     * @return array
     */
    public function getExportFields1c($context = null);
}