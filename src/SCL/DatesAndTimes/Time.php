<?php

namespace SCL\DatesAndTimes;

use SCL\DatesAndTimes\Exception\InvalidStringFormatException;

class Time
{
    const STRING_REGEX = '/^([0-9]{2}):([0-9]{2}):([0-9]{2})$/';

    /** @var Hour */
    private $hour;

    /** @var Minute */
    private $minute;

    /** @var Second */
    private $second;

    public function __construct(Hour $hour, Minute $minute, Second $second)
    {
        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }

    public function getHour()
    {
        return $this->hour->getValue();
    }

    public function getMinute()
    {
        return $this->minute->getValue();
    }

    public function getSecond()
    {
        return $this->second->getValue();
    }

    public static function fromString($string)
    {
        if (!preg_match(self::STRING_REGEX, $string, $matches)) {
            throw InvalidStringFormatException::invalidFormat('Time', 'HH:MM:SS', $string);
        }

        return new self(new Hour($matches[1]), new Minute($matches[2]), new Second($matches[3]));
    }

    public function __toString()
    {
        return sprintf(
            '%02d:%02d:%02d',
            $this->hour->getValue(),
            $this->minute->getValue(),
            $this->second->getValue()
        );
    }

    public function formatted($format)
    {
        $time = \DateTimeImmutable::createFromFormat('H:i:s', $this->__toString());
        return $time->format($format);
    }
}