<?php namespace Craft;

class Glossary_GlossaryService extends BaseApplicationComponent
{
    /**
     * Builds a glossary of the given items, grouped by the specified field.
     *
     * @param array|ElementCriteriaModel $items
     * @param string $groupField
     *
     * @return array
     */
    public function buildGlossary($items, $groupField)
    {
        $glossary = [];
        $groupedItems = array_fill_keys(range('A', 'Z'), []);

        foreach ($items as $item) {
            $fieldData = $item->$groupField;

            $fieldIndex = strtoupper(substr($fieldData, 0, 1));

            $groupedItems[$fieldIndex][] = $item;
        }

        foreach ($groupedItems as $index => $items) {
            $glossary[] = new Glossary_KeyModel([
                'label'    => $index,
                'items'    => $items,
            ]);
        }

        return $glossary;
    }
}
