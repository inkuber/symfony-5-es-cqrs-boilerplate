<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Persistence\Doctrine\Types;

use App\Shared\Domain\Exception\DateTimeException;
use App\Shared\Domain\ValueObject\DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeImmutableType;

class DateTimeType extends DateTimeImmutableType
{
    /**
     * {@inheritdoc}
     *
     * @throws DBALException
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        if ($platform instanceof MySqlPlatform) {
            return 'DATETIME(6)';
        }
        return $platform->getDateTimeTypeDeclarationSQL($column);
    }

    /**
     * {@inheritdoc}
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof DateTime || $value instanceof DateTimeImmutable) {
            $format = $platform->getDateTimeFormatString();
            if ($platform instanceof MySqlPlatform) {
                $format .= ".u";
            }
            return $value->format($format);
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', DateTime::class]);
    }

    /**
     * {@inheritdoc}
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof DateTime) {
            return $value;
        }

        try {
            $dateTime = DateTime::fromString($value);
        } catch (DateTimeException $e) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return $dateTime;
    }
}
