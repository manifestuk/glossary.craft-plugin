<?php namespace Craft;

class GlossaryVariable
{
    /**
     * Builds an A-Z glossary of the given items, grouped by the specified
     * field.
     *
     * @param array|ElementCriteriaModel $items
     * @param string $field
     *
     * @return array
     */
    public function buildAZ($items, $field)
    {
        return craft()->glossary_glossary->buildAZ($items, $field);
    }

    /**
     * Builds a custom glossary of the given items, grouped by the specified
     * field.
     *
     * @param array|ElementCriteriaModel $items
     * @param string $field
     * @param array $keys
     *
     * @return array
     */
    public function buildCustom($items, $field, Array $keys)
    {
        return craft()->glossary_glossary->buildCustom($items, $field, $keys);
    }
}
