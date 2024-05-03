<?php

namespace Tests;

use App\Text;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{

  public function testCountBytes()
  {
    $text = new Text();
    $this->assertEquals(3, $text->countBytes('abc'));
    $this->assertEquals(6, $text->countBytes('あいう'));
    $this->assertEquals(3, $text->countBytes('ｱｲｳ'));
    $this->assertEquals(9, $text->countBytes('abcあいう'));
    $this->assertEquals(6, $text->countBytes('abcｱｲｳ'));
    $this->assertEquals(2, $text->countBytes('🎉'));
    $this->assertEquals(2, $text->countBytes(',.'));
    $this->assertEquals(4, $text->countBytes('、。'));
  }

  public function testSliceText()
  {

    $text = new Text();
    $this->assertEquals(['あ', 'い', 'う', 'え', 'お'], $text->sliceText('あいうえお', 2));
    $this->assertEquals(['あ', 'い', 'う', 'え', 'お'], $text->sliceText('あいうえお', 1));
    $this->assertEquals(['ai', 'ue', 'o'], $text->sliceText('aiueo', 2));
    $this->assertEquals(['a', 'i', 'u', 'e', 'o'], $text->sliceText('aiueo', 1));
    $this->assertEquals(['ai', 'u', 'え', 'お'], $text->sliceText('aiuえお', 2));

    $this->assertEquals(['いつもお世', '話になって', 'おります。', '長文テスト', 'になります', '。hello wo', 'rld であり', 'ます。'], $text->sliceText('いつもお世話になっております。長文テストになります。hello world であります。', 10));
  }
}
