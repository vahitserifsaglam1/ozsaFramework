<?php

namespace Filesystem\Finder;

class Glob 
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function renderPattern()
    {
        return $this->pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return Expression::TYPE_GLOB;
    }

    /**
     * {@inheritdoc}
     */
    public function isCaseSensitive()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function prepend($expr)
    {
        $this->pattern = $expr.$this->pattern;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function append($expr)
    {
        $this->pattern .= $expr;

        return $this;
    }

    /**
     * Tests if glob is expandable ("*.{a,b}" syntax).
     *
     * @return bool
     */
    public function isExpandable()
    {
        return false !== strpos($this->pattern, '{')
            && false !== strpos($this->pattern, '}');
    }

    /**
     * @param bool $strictLeadingDot
     * @param bool $strictWildcardSlash
     *
     * @return Regex
     */
    public function toRegex($strictLeadingDot = true, $strictWildcardSlash = true)
    {
        $firstByte = true;
        $escaping = false;
        $inCurlies = 0;
        $regex = '';
        $sizeGlob = strlen($this->pattern);
        for ($i = 0; $i < $sizeGlob; $i++) {
            $car = $this->pattern[$i];
            if ($firstByte) {
                if ($strictLeadingDot && '.' !== $car) {
                    $regex .= '(?=[^\.])';
                }

                $firstByte = false;
            }

            if ('/' === $car) {
                $firstByte = true;
            }

            if ('.' === $car || '(' === $car || ')' === $car || '|' === $car || '+' === $car || '^' === $car || '$' === $car) {
                $regex .= "\\$car";
            } elseif ('*' === $car) {
                $regex .= $escaping ? '\\*' : ($strictWildcardSlash ? '[^/]*' : '.*');
            } elseif ('?' === $car) {
                $regex .= $escaping ? '\\?' : ($strictWildcardSlash ? '[^/]' : '.');
            } elseif ('{' === $car) {
                $regex .= $escaping ? '\\{' : '(';
                if (!$escaping) {
                    ++$inCurlies;
                }
            } elseif ('}' === $car && $inCurlies) {
                $regex .= $escaping ? '}' : ')';
                if (!$escaping) {
                    --$inCurlies;
                }
            } elseif (',' === $car && $inCurlies) {
                $regex .= $escaping ? ',' : '|';
            } elseif ('\\' === $car) {
                if ($escaping) {
                    $regex .= '\\\\';
                    $escaping = false;
                } else {
                    $escaping = true;
                }

                continue;
            } else {
                $regex .= $car;
            }
            $escaping = false;
        }

        return new Regex('^'.$regex.'$');
    }
}
