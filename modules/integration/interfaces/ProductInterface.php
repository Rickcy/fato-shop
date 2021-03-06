<?php

namespace app\modules\integration\interfaces;

use yii\db\ActiveRecordInterface;
use Zenwalker\CommerceML\Model\PropertyCollection;

/**
 * Interface ProductInterface
 *
 */
interface ProductInterface extends ActiveRecordInterface, IdentifierInterface
{
    /**
     * Если по каким то причинам файлы import.xml или offers.xml были модифицированы и какие то данные
     * не попадают в парсер, в самом конце вызывается данный метод, в $product и $cml можно получить все
     * возможные данные для ручного парсинга
     *
     * @param \Zenwalker\CommerceML\CommerceML $cml
     * @param \Zenwalker\CommerceML\Model\Product $product
     * @return void
     */
    public function setRaw1cData($cml, $product);

    /**
     * Установка реквизитов, (import.xml > Каталог > Товары > Товар > ЗначенияРеквизитов > ЗначениеРеквизита)
     * $name - Наименование
     * $value - Значение
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public function setRequisite1c($name, $value);


    public function createProp();

    public function generationSlug();
    /**
     * Предпологается, что дерево групп у Вас уже создано (\carono\exchange1c\interfaces\GroupInterface::createTree1c)
     *
     * @param \Zenwalker\CommerceML\Model\Group $group
     * @return mixed
     */

    public function setGroup1c($group);

    /**
     * import.xml > Классификатор > Свойства > Свойство
     * $property - Свойство товара
     *
     * import.xml > Классификатор > Свойства > Свойство > Значение
     * $property->value - Разыменованное значение (string)
     *
     * import.xml > Классификатор > Свойства > Свойство > ВариантыЗначений > Справочник
     * $property->getValueModel() - Данные по значению, Ид значения, и т.д
     *
     * @param \Zenwalker\CommerceML\Model\Property $property
     * @return void
     */
    public function setProperty1c($property);

    /**
     * @param string $path
     * @param string $caption
     * @return mixed
     */
    public function addImage1c($path, $caption);

    /**
     * @return GroupInterface
     */
    public function getGroup1c();

    /**
     * Создание все свойств продутка
     * import.xml > Классификатор > Свойства
     *
     * $properties[]->availableValues - список доступных значений, для этого свойства
     * import.xml > Классификатор > Свойства > Свойство > ВариантыЗначений > Справочник
     *
     * @param PropertyCollection $properties
     * @return mixed
     */
    public static function createProperties1c($properties);

    /**
     * @param \Zenwalker\CommerceML\Model\Offer $offer
     * @return OfferInterface
     */
    public function getOffer1c($offer);

    /**
     * @param \Zenwalker\CommerceML\Model\Product $product
     * @return mixed
     */
    public static function createModel1c($product);
}