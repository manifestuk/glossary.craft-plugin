<?php namespace Craft;

class Glossary_KeyModelTest extends GlossaryBaseTest
{
    /** @test */
    public function it_returns_false_if_the_subject_has_no_items()
    {
        $subject = new Glossary_KeyModel;

        $this->assertFalse($subject->hasItems());
    }

    /** @test */
    public function it_copes_with_wilful_idiocy()
    {
        $subject = Glossary_KeyModel::populateModel(['items' => 'Baboon']);

        $this->assertFalse($subject->hasItems());
    }

    /** @test */
    public function it_returns_true_if_the_subject_has_items()
    {
        $subject = Glossary_KeyModel::populateModel([
            'items' => ['A', 'B', 'C'],
        ]);

        $this->assertTrue($subject->hasItems());
    }

    /** @test */
    public function it_uses_the_label_for_tostring()
    {
        $subject = Glossary_KeyModel::populateModel(['label' => 'Testing']);

        $this->assertSame('Testing', (string) $subject);
    }
}
