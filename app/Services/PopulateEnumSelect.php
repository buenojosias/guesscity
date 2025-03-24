<?php

namespace App\Services;

class PopulateEnumSelect
{
    public static function getCases($enum, $withEmpty = false): array
    {
        $cases = $enum::cases();

        $select = [];
        if ($withEmpty) {
            $select[] = [
                'value' => '',
                'label' => 'Selecione uma opção'
            ];
        }
        foreach ($cases as $case) {
            $select[] = [
                'value' => $case->value,
                'label' => $case->label()
            ];
        }
        return $select;
    }
}
