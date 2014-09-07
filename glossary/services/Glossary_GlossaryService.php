<?php namespace Craft;

class Glossary_GlossaryService extends BaseApplicationComponent
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
        $items  = $this->normalizeItems($items);
        $keys   = range('A', 'Z');
        $method = 'azKeyCallback';

        return $this->buildGlossary(
            $this->groupGlossaryItems($items, $keys, $field, $method)
        );
    }

    /**
     * Returns the first letter of the given string, converted to uppercase.
     *
     * @param string $value
     *
     * @return string
     */
    protected function azKeyCallback($value)
    {
        return is_string($value) ? strtoupper(substr($value, 0, 1)) : '';
    }

    /**
     * Builds a custom glossary of the given items using the specified keys,
     * grouped by the specified field.
     *
     * @param array|ElementCriteriaModel $items
     * @param string $field
     * @param array $keys
     *
     * @return array
     */
    public function buildCustom($items, $field, Array $keys)
    {
        $items = $this->normalizeItems($items);

        return $this->buildGlossary(
            $this->groupGlossaryItems($items, $keys, $field)
        );
    }

    /**
     * Ensures that 'items' is an array.
     *
     * @param array|ElementCriteriaModel $items
     *
     * @return array
     */
    protected function normalizeItems($items)
    {
        if ($items instanceof ElementCriteriaModel) {
            $items = $items->find();
        } else {
            $items = is_array($items) ? $items : [];
        }

        return $items;
    }

    /**
     * Groups the given items by the given keys, using the specified field
     * Accepts an optional callback function, which may be used to control how
     * the field key is determined (refer to the A-Z implementation for an
     * example).
     *
     * @param Array $items
     * @param Array $keys
     * @param mixed $field
     * @param string $callback
     *
     * @return array
     */
    protected function groupGlossaryItems(
        Array $items,
        Array $keys,
        $field,
        $callback = ''
    ) {
        $groups = array_fill_keys($keys, []);

        foreach ($items as $item) {
            if ( ! $this->validatePropertyExists($item, $field)) {
                continue;
            }

            $key = $this->getItemKey($item, $field, $callback);

            if ( ! $this->validateKeyExists($key, $keys)) {
                continue;
            }

            $groups[$key][] = $item;
        }

        return $groups;
    }

    /**
     * Validates that the specified property exists on the given object. Logs a
     * warning if it does not.
     *
     * @param object $item
     * @param string $prop
     *
     * @return bool
     */
    protected function validatePropertyExists($item, $prop)
    {
        if ( ! isset($item->$prop)) {
            $message = "The '${prop}' field does not exist on this object.";

            $this->logWarning($message);

            return false;
        }

        return true;
    }

    /**
     * Retrieves the value of the key field for the given item. If a callback
     * method is specified, that is used to determine the value.
     *
     * @param object $item
     * @param string $field
     * @param string $callback
     *
     * @return mixed
     */
    protected function getItemKey($item, $field, $callback)
    {
        return $callback ? $this->$callback($item->$field) : $item->$field;
    }

    /**
     * Validates that the specified key exists in the given array. Logs a
     * warning if it does not.
     *
     * @param string $needle
     * @param array $haystack
     *
     * @return bool
     */
    protected function validateKeyExists($needle, Array $haystack)
    {
        if ( ! in_array($needle, $haystack)) {
            $message = "Ignoring item with unknown key '${needle}'.";

            $this->logWarning($message);

            return false;
        }

        return true;
    }

    /**
     * Returns an array of Glossary_KeyModels, constructed from the grouped
     * items.
     *
     * @param array $items
     *
     * @return array
     */
    protected function buildGlossary(Array $groupedItems)
    {
        $glossary = [];

        foreach ($groupedItems as $key => $items) {
            $glossary[] = new Glossary_KeyModel([
                'label'    => $key,
                'items'    => $items,
            ]);
        }

        return $glossary;
    }

    /**
     * Writes a warning message to the plugin-specific log.
     *
     * @param string $message
     *
     * @return void
     */
    protected function logWarning($message)
    {
        GlossaryPlugin::log($message, LogLevel::Warning);
    }
}
