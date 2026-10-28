<?php

namespace Drupal\Tests\jquery_colorpicker\Unit\Element;

use Drupal\colorapi\Service\ColorapiService;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Tests\UnitTestCase;
use Drupal\jquery_colorpicker\Element\JQueryColorpickerElement;

/**
 * @coversDefaultClass \Drupal\jquery_colorpicker\Element\JQueryColorpickerElement
 * @group jquery_colorpicker
 */
class JQueryColorpickerTest extends UnitTestCase {

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $container = new ContainerBuilder();
    $container->set('colorapi.service', new ColorapiService());
    \Drupal::setContainer($container);
  }

  /**
   * @covers ::valueCallback
   *
   * @dataProvider providerTestValueCallback
   */
  public function testValueCallback($expected, $input) {
    $element = [];
    $form_state = $this->prophesize(FormStateInterface::class)->reveal();
    $this->assertSame($expected, JQueryColorpickerElement::valueCallback($element, $input, $form_state));
  }

  /**
   * Data provider for testValueCallback()
   */
  public static function providerTestValueCallback() {
    $data = [];

    $data[] = [NULL, FALSE];
    $data[] = [NULL, ['test']];
    $test = new \stdClass();
    $test->color = 'test';
    $data[] = [NULL, $test];
    $test->color = '123456';
    $data[] = [NULL, $test];
    $data[] = ['#123456', '#123456'];
    $data[] = [NULL, '1'];

    return $data;
  }

  /**
   * @covers ::valueCallback
   */
  public function testValidateElementEmpty() {
    $element = ['#value' => ''];
    $form_state = $this->prophesize(FormStateInterface::class)->reveal();
    $this->assertSame(NULL, JQueryColorpickerElement::validateElement($element, $form_state));
  }

}
