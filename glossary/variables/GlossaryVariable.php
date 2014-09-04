<?php namespace Craft;

class GlossaryVariable
{
    /**
     * Builds a glossary of the given items, grouped by the specified field.
     *
     * @param array|ElementCriteriaModel $items
     * @param string $groupField
     *
     * @return array
     */
    public function build($items, $groupField)
    {
        return craft()->glossary_glossary->buildGlossary($items, $groupField);
    }
}
