<?php 

namespace Laraket\Probably;

use Laraket\Probably\Contracts\Probal;

/**
 * AliasMethod
 *
 * @category Class
 * @package  Laraket\Probably
 * @author   ney <zoobile@gmail.com>
 * @license  MIT https://github.com/swooliy/laraket/probably/LICENSE.md
 * @link     https://github.com/swooliy/laraket/probably
 * @source   http://www.keithschwarz.com/darts-dice-coins/
 */
class AliasMethod implements Probal
{

    protected $prob = [];

    protected $alias = [];

    protected $data;

    /**
     * Construct
     * 
     * @param array $data data
     * 
     */
    public function __construct(array $data) 
    {
        $this->data = $data;
    }
 
    /**
     * Compute

     * @return int
     */
    public function compute() 
    {   
        $nums = count($this->data);
        $small = $large = array();

        for ($i = 0; $i < $nums; ++$i) {
            $this->data[$i] = $this->data[$i] * $nums; // 扩大倍数，使每列高度可为1
            
            /** 分到两个数组，便于组合 */
            if ($this->data[$i] < 1) {
                $small[] = $i;
            } else {
                $large[] = $i;
            }
        }
    
        /** 将超过1的色块与原色拼凑成1 */
        while (!empty($small) && !empty($large)) {
            $n_index = array_shift($small);
            $a_index = array_shift($large);
            
            $this->prob[$n_index] = $this->data[$n_index];
            $this->alias[$n_index] = $a_index;
            // 重新调整大色块
            $this->data[$a_index] = ($this->data[$a_index] + $this->data[$n_index]) - 1;
            
            if ($this->data[$a_index] < 1) {
                $small[] = $a_index;
            } else {
                $large[] = $a_index;
            }
        }
        
        /** 剩下大色块都设为1 */
        while (!empty($large)) {
            $n_index = array_shift($large);
            $this->prob[$n_index] = 1;
        }
        
        /** 一般是精度问题才会执行这一步 */
        while (!empty($small)) {
            $n_index = array_shift($small);
            $this->prob[$n_index] = 1;
        }

        $nums = count($this->prob) - 1;
    
        $MAX_P = 100000; // 假设最小的几率是万分之一
        $coin_toss = rand(1, $MAX_P) / $MAX_P; // 抛出硬币
        
        $col = rand(0, $nums); // 随机落在一列
        $b_head = ($coin_toss < $this->prob[$col]) ? true : false; // 判断是否落在原色
        
        return $b_head ? $col : $this->alias[$col];
    }
}