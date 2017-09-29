<?php declare(strict_types=1);

namespace Shopware\Framework\Write\Resource;

use Shopware\Context\Struct\TranslationContext;
use Shopware\Framework\Event\FilterTranslationWrittenEvent;
use Shopware\Framework\Write\Field\FkField;
use Shopware\Framework\Write\Field\ReferenceField;
use Shopware\Framework\Write\Field\StringField;
use Shopware\Framework\Write\Flag\Required;
use Shopware\Framework\Write\WriteResource;
use Shopware\Shop\Writer\Resource\ShopWriteResource;

class FilterTranslationWriteResource extends WriteResource
{
    protected const NAME_FIELD = 'name';

    public function __construct()
    {
        parent::__construct('filter_translation');

        $this->fields[self::NAME_FIELD] = (new StringField('name'))->setFlags(new Required());
        $this->fields['filter'] = new ReferenceField('filterUuid', 'uuid', FilterWriteResource::class);
        $this->primaryKeyFields['filterUuid'] = (new FkField('filter_uuid', FilterWriteResource::class, 'uuid'))->setFlags(new Required());
        $this->fields['language'] = new ReferenceField('languageUuid', 'uuid', ShopWriteResource::class);
        $this->primaryKeyFields['languageUuid'] = (new FkField('language_uuid', ShopWriteResource::class, 'uuid'))->setFlags(new Required());
    }

    public function getWriteOrder(): array
    {
        return [
            FilterWriteResource::class,
            ShopWriteResource::class,
            self::class,
        ];
    }

    public static function createWrittenEvent(array $updates, TranslationContext $context, array $errors = []): FilterTranslationWrittenEvent
    {
        $event = new FilterTranslationWrittenEvent($updates[self::class] ?? [], $context, $errors);

        unset($updates[self::class]);

        if (!empty($updates[FilterWriteResource::class])) {
            $event->addEvent(FilterWriteResource::createWrittenEvent($updates, $context));
        }
        if (!empty($updates[ShopWriteResource::class])) {
            $event->addEvent(ShopWriteResource::createWrittenEvent($updates, $context));
        }
        if (!empty($updates[self::class])) {
            $event->addEvent(self::createWrittenEvent($updates, $context));
        }

        return $event;
    }
}
