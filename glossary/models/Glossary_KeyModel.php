<?php namespace Craft;

class Glossary_KeyModel extends BaseModel
{
    /**
     * Returns an array containing the model attribute definitions.
     *
     * @return array
     */
    protected function defineAttributes()
    {
        return [
            'label' => AttributeType::String,
            'items' => AttributeType::Mixed,
        ];
    }

    /**
     * Returns a boolean indicating whether the model contains any items.
     *
     * @return bool
     */
    public function hasItems()
    {
        return is_array($this->items) && count($this->items) > 0;
    }

    /**
     * Returns a string representation of the model (the label).
     *
     * @return string
     */
    public function __toString()
    {
        return $this->label;
    }
}
