<?php

namespace App;


class Text
{
  public function countBytes(string $string): int
  {
    $length = mb_strlen($string, 'UTF-8');
    $byteCount = 0;

    for ($i = 0; $i < $length; $i++) {
      $char = mb_substr($string, $i, 1, 'UTF-8');
      $byteCount += mb_strwidth($char, 'UTF-8');
    }
    return $byteCount;
  }

  public function sliceText(string $inputText,  int $maxLength): array
  {
    $result = [];
    $sliceInputText = mb_str_split($inputText);
    $tempText = '';
    foreach ($sliceInputText as $key => $char) {
      $tempText = $tempText . $char;

      $nextChar = isset($sliceInputText[$key + 1]) ? $sliceInputText[$key + 1] :  '';
      $nextCharByte = $this->countBytes($nextChar);

      if (
        $nextCharByte + $this->countBytes($tempText) > $maxLength
        || $this->countBytes($tempText) >= $maxLength
      ) {
        $result[] = $tempText;
        $tempText = '';
      }
    }

    if (strlen($tempText) > 0) {
      $result[] = $tempText;
    }

    return $result;
  }
}
