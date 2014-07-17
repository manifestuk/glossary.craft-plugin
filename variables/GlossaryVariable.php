<?php namespace Craft;

class GlossaryVariable
{
    public function navigation($items, $groupField)
    {
        $glossary = array_fill_keys(range('A', 'Z'), []);

        foreach ($items as $item) {
            $fieldData = $item->$groupField;

            $fieldIndex = strtoupper(substr($fieldData, 0, 1));

            $glossary[$fieldIndex][] = $item;
        }

        $return = [];

        foreach ($glossary as $letter => $letterItems) {
            $return[] = (object) ['label' => $letter, 'hasItems' => (bool) $letterItems];
        }

        return $return;
    }
}
