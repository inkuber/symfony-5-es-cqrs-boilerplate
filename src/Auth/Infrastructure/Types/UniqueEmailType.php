<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Types;

use App\Auth\Domain\User\ValueObject\UniqueEmail;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Throwable;

final class UniqueEmailType extends StringType
{
    private const TYPE = 'email';

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

        if (!$value instanceof UniqueEmail) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', UniqueEmail::class]);
        }

        return $value->__toString();
    }

    /**
     * @param UniqueEmail|string|null $value
     *
     * @return UniqueEmail|null
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof UniqueEmail) {
            return $value;
        }

        try {
            $email = UniqueEmail::fromString($value);
        } catch (Throwable $e) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return $email;
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
        return self::TYPE;
    }
}
