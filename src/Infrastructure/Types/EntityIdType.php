<?php

declare(strict_types=1);

namespace App\Infrastructure\Types;

use App\Shared\Domain\ValueObject\EntityId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Throwable;

abstract class EntityIdType extends StringType
{
    protected const TYPE = 'entity_id';
    protected const CLS = EntityId::class;

    abstract public function fromBytes($value);

    /**
     * {@inheritdoc}
     *
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getBinaryTypeDeclarationSQL(
            [
                'length' => '16',
                'fixed' => true,
            ]
        );
    }

    /**
     * @param mixed $value
     *
     * @return mixed|string|null
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!is_subclass_of($value, static::CLS)) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', static::CLS]);
        }

        return $value->getBytes();
    }

    /**
     * @param EntityId|string|null $value
     *
     * @return EntityId|null
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || is_subclass_of($value, static::CLS)) {
            return $value;
        }

        try {
            $id = static::fromBytes($value);
        } catch (Throwable $e) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        return $id;
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return static::TYPE;
    }
}
