<?php

namespace App;

enum FontSize: int
{

  case Small = 25;
  case Medium = 40;
  case Large = 60;


  public function maxLength(): int
  {
    return match ($this) {
      FontSize::Small => 26,
      FontSize::Medium => 18,
      FontSize::Large => 12,
    };
  }
}
