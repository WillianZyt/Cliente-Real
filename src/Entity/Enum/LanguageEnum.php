<?php

namespace App\Entity\Enum;

enum LanguageEnum: int
{
    case PORTUGUESE = 1;
    case SPANISH = 2;
    case ENGLISH = 3;

    public static function getOptions(): array
    {
        return [
            'Português' => self::PORTUGUESE->value,
            'Espanhol' => self::SPANISH->value,
            'Inglês' => self::ENGLISH->value,
        ];
    }

    public static function getDescription($id): string
    {
        $n = [
            self::PORTUGUESE->value => 'Português',
            self::SPANISH->value => 'Espanhol',
            self::ENGLISH->value => 'Inglês',
            "" => '',
        ];

        return $n[$id];
    }
    
    public static function getFlag($id): string
    {
        $n = [
            self::PORTUGUESE->value =>  
            '<div class="d-none">pt</div> 
            <img src="/assets/images/flags/Flag_of_Brazil.svg" width="20" height="20"> Português',
            self::SPANISH->value =>     
            '<div class="d-none">sp</div> 
            <img src="/assets/images/flags/Flag_of_Spain.svg" width="20" height="20"> Espanhol',
            self::ENGLISH->value =>     
            '<div class="d-none">en</div> 
            <img src="/assets/images/flags/Flag_of_the_United_Kingdom.svg" width="20" height="20"> Inglês',
            "" => '',
        ];

        return $n[$id];
    }
}
