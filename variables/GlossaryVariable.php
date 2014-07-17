<?php namespace Craft;

class GlossaryVariable
{
    public function make($items, $groupField)
    {
        return $this->buildGlossary($items, $groupField);
    }

    protected function buildGlossary($items, $groupField)
    {
        $glossary = [];
        $groupedItems = array_fill_keys(range('A', 'Z'), []);

        foreach ($items as $item) {
            $fieldData = $item->$groupField;

            $fieldIndex = strtoupper(substr($fieldData, 0, 1));

            $groupedItems[$fieldIndex][] = $item;
        }

        foreach ($groupedItems as $index => $items) {
            $glossary[] = new Glossary_LetterModel([
                'label' => $index,
                'items' => $items,
            ]);
        }

        return $glossary;
    }
}
