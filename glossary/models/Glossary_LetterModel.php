<?php namespace Craft;

class Glossary_LetterModel extends BaseModel
{
    protected function defineAttributes()
    {
        return [
            'label' => AttributeType::String,
            'items' => AttributeType::Mixed,
        ];
    }

    public function __toString()
    {
        return $this->label;
    }
}
