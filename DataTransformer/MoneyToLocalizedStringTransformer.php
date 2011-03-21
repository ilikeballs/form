<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\DataTransformer;

use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * Transforms between a normalized format and a localized money string.
 *
 * @author Bernhard Schussek <bernhard.schussek@symfony.com>
 * @author Florian Eckerstorfer <florian@eckerstorfer.org>
 */
class MoneyToLocalizedStringTransformer extends NumberToLocalizedStringTransformer
{

    private $divisor;

    public function __construct($precision = null, $grouping = null, $roundingMode = null, $divisor = null)
    {
        if(is_null($grouping)) {
            $grouping = true;
        }

        if(is_null($precision)) {
            $precision = 2;
        }

        parent::__construct($precision,$grouping,$roundingMode);

        if(is_null($divisor)) {
            $divisor = 1;
        }

        $this->divisor = $divisor;
    }

    /**
     * Transforms a normalized format into a localized money string.
     *
     * @param  number $value  Normalized number
     * @return string         Localized money string.
     */
    public function transform($value)
    {
        if (null !== $value) {
            if (!is_numeric($value)) {
                throw new UnexpectedTypeException($value, 'numeric');
            }

            $value /= $this->divisor;
        }

        return parent::transform($value);
    }

    /**
     * Transforms a localized money string into a normalized format.
     *
     * @param string $value Localized money string
     * @return number Normalized number
     */
    public function reverseTransform($value)
    {
        $value = parent::reverseTransform($value);

        if (null !== $value) {
            $value *= $this->divisor;
        }

        return $value;
    }

}