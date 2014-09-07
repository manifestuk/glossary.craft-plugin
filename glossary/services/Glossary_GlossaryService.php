<?php namespace Craft;

class Glossary_GlossaryService extends BaseApplicationComponent
{
    /**
     * Builds an A-Z glossary of the given items, grouped by the specified
     * field.
     *
     * @param array|ElementCriteriaModel $items
     * @param string $keyField
     *
     * @return array
     */
    public function buildAZ($items, $keyField)
    {
        $items  = $this->normalizeItems($items);
        $keys   = range('A', 'Z');
        $method = 'azKeyCallback';

        return $this->buildGlossary(
            $this->groupGlossaryItems($items, $keys, $keyField, $method)
        );
    }

    /**
     * Returns the first letter of the given string, converted to uppercase.
     *
     * @param string $fieldData
     *
     * @return string
     */
    protected function azKeyCallback($fieldData)
    {
        return is_string($fieldData)
            ? strtoupper(substr($fieldData, 0, 1))
            : '';
    }

    /**
     * Builds a custom glossary of the given items using the specified keys,
     * grouped by the specified field.
     *
     * @param array|ElementCriteriaModel $items
     * @param string $keyField
     * @param array $keys
     *
     * @return array
     */
    public function buildCustom($items, $keyField, Array $keys)
    {
        $items = $this->normalizeItems($items);

        return $this->buildGlossary(
            $this->groupGlossaryItems($items, $keys, $keyField)
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
     * @param mixed $keyField
     * @param string $keyCallback
     *
     * @return array
     */
    protected function groupGlossaryItems(
        Array $items,
        Array $keys,
        $keyField,
        $keyCallback = ''
    ) {
        $groups = array_fill_keys($keys, []);

        foreach ($items as $item) {
            if ( ! $this->validatePropertyExists($item, $keyField)) {
                continue;
            }

            $key = $this->getItemKey($item, $keyField, $keyCallback);

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
     * @param string $key
     * @param array $allKeys
     *
     * @return bool
     */
    protected function validateKeyExists($key, Array $allKeys)
    {
        if ( ! in_array($key, $allKeys)) {
            $message = "Ignoring item with unknown key '${key}'.";

            $this->logWarning($message);

            return false;
        }

        return true;
    }

    /**
     * Returns an array of Glossary_KeyModels, constructed from the grouped
     * items.
     *
     * @param array $groupedItems
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

    protected function logWarning($message)
    {
        GlossaryPlugin::log($message, LogLevel::Warning);
    }
}
