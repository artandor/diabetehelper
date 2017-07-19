<?php
/**
 * Copyright (c) 2016 - 2017.  Nicolas MYLLE
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 */

/**
 * Created by PhpStorm.
 * User: millt
 * Date: 10/07/2017
 * Time: 21:44
 */

namespace DiabeteHelperBundle\Twig\Extension;

/**
 * Class JsonDecode
 * @package DiabeteHelper\Twig\Extension
 *
 */

class JsonDecode extends \Twig_Extension
{
    public function getName()
    {
        return 'twig.json_decode';
    }
    public function getFilters()
    {
        return array(
            'json_decode'   => new \Twig_Filter_Method($this, 'jsonDecode')
        );
    }
    public function jsonDecode($string)
    {
        return json_decode($string);
    }
}