<?php


namespace app\modules\integration\interfaces;


interface RawInterface
{
    /**
     * @param \Zenwalker\CommerceML\CommerceML $cml
     * @param \Zenwalker\CommerceML\Model\Simple $object
     * @return mixed
     */
    public function setRaw1cData($cml, $object);
}