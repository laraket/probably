<?php 

namespace Laraket\Probably\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Laraket\Probably\AliasMethod;

/**
 * AliasMethodTest
 *
 * @category TestCase
 * @package  Laraket\Probably
 * @author   ney <zoobile@gmail.com>
 * @license  MIT https://github.com/swooliy/laraket/probably/LICENSE.md
 * @link     https://github.com/swooliy/laraket/probably
 */
class AliasMethodTest extends TestCase
{
    /**
     * TestOne
     *
     * @return void
     */
    public function testOne()
    {
        $data = [0.25, 0.2, 0.1, 0.05, 0.4];

        $method = new AliasMethod($data);

        $result = $method->compute();

        $this->assertLessThanOrEqual(count($data), $result);

        $this->assertGreaterThanOrEqual(1, $result);

    }

    /**
     * TestTwo
     *
     * @return void
     */
    public function testTwo()
    {
        $data = [0.25, 0.2, 0.1, 0.05, 0.4];

        
        $count = array(0, 0, 0, 0, 0);
        
        for ($i = 0; $i < 10000; $i++) {
            $method = new AliasMethod($data);
            $result = $method->compute();
            $count[$result]++;
        }

        echo '<pre>';
        print_r($count);
        echo '</pre>';
    }
}