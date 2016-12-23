<?php

/**
 * Copyright (c) 2016 Tobias Trozowski
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace TobiasTest\Expressive\Form;

use Interop\Container\ContainerInterface;
use Tobias\Expressive\Form\FormElementManagerDelegatorFactory;
use Zend\Form\FormElementManager\FormElementManagerV2Polyfill;
use Zend\Form\FormElementManager\FormElementManagerV3Polyfill;
use Zend\Form\FormElementManagerFactory;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class FormElementManagerDelegatorFactoryTest
 * @package TobiasTest\Expressive\Form\Delegator
 */
class FormElementManagerDelegatorFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            [ContainerInterface::class, '__invoke'],
            [ServiceLocatorInterface::class, 'createDelegatorWithName'],
        ];
    }


    /**
     * @dataProvider dataProvider
     */
    public function testInvokeDelegator($interface, $method)
    {
        $config = [
            'form_elements' => [],
        ];

        /** @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject $container */
        $container = $this->getMockBuilder($interface)->getMockForAbstractClass();
        $container->expects($this->once())->method('has')->with('config')->will($this->returnValue(true));
        $container->expects($this->once())->method('get')->with('config')->will($this->returnValue($config));

        $callback = function () use ($container) {
            $factory = new FormElementManagerFactory();

            return $factory($container, 'FormElementManager');
        };
        $subject = new FormElementManagerDelegatorFactory();
        $this->assertInstanceOf(DelegatorFactoryInterface::class, $subject);

        if ($container instanceof ServiceLocatorInterface) {
            $instance = $subject->$method($container, 'FormElementManager', 'FormElementManager', $callback);
        } else {
            $instance = $subject->$method($container, 'FormElementManager', $callback);
        }
        if (method_exists($instance, 'configure')) {
            $this->assertInstanceOf(FormElementManagerV3Polyfill::class, $instance);
        } else {
            $this->assertInstanceOf(FormElementManagerV2Polyfill::class, $instance);
        }
    }
}
