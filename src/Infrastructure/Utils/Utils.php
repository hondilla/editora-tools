<?php declare(strict_types=1);

namespace Omatech\EditoraTools\Infrastructure\Utils;

use Cocur\Slugify\Slugify;
use function Lambdish\Phunctional\filter;

class Utils
{
    private static $instance = null;
    private $slugify;

    private function __construct()
    {
        $this->slugify = new Slugify();
    }

    public static function getInstance(): Utils
    {
        if (! self::$instance) {
            self::$instance = new Utils();
        }
        return self::$instance;
    }

    public function slug($string)
    {
        if ($this->isEmpty($string)) {
            return $string;
        }

        $string = str_replace('_', '-', $string);
        $string = str_replace(' ', '', $string);

        return str_replace(array(' ', '--'), array('', '-'), $this->slugify->slugify($string, [
            'regexp' => '/(?<=[[:^upper:]])(?=[[:upper:]])/',
            'lowercase_after_regexp' => true,
        ]));
    }

    public function isEmpty($value): bool
    {
        return (bool) filter(static function ($operator) use ($value) {
            return $value === $operator;
        }, ['', [], null]);
    }
}
