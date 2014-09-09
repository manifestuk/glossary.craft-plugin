<?php namespace Craft;

use Mockery as m;

class Glossary_GlossaryServiceTest extends GlossaryBaseTest
{
    protected $subject;

    /**
     * Performs common pre-test tasks.
     *
     * @return void
     */
    public function setUp()
    {
        $this->subject = new Glossary_GlossaryService;
    }

    /**
     * Builds an 'empty' glossary associative array.
     *
     * @param Array $keys
     *
     * @return Array
     */
    protected function buildEmptyGlossary(Array $keys)
    {
        $glossary = [];

        foreach ($keys as $key) {
            $glossary[] = new Glossary_KeyModel([
                'label' => $key,
                'items' => []
            ]);
        }

        return $glossary;
    }

    /** @test */
    public function it_should_group_items_by_az()
    {
        $field = 'name';
        $keys = range('A', 'Z');

        $items = [
            (object) ['name' => 'Zane'],
            (object) ['name' => 'Mary'],
            (object) ['name' => 'Adam'],
            (object) ['name' => 'Maude'],
            (object) ['name' => 'Alan'],
        ];

        $glossary = $this->buildEmptyGlossary($keys);

        $glossary[0]->items = [$items[2], $items[4]];
        $glossary[12]->items = [$items[1], $items[3]];
        $glossary[25]->items = [$items[0]];

        $subject = new Glossary_GlossaryService;

        $this->assertEquals($glossary, $subject->buildAZ($items, $field));
    }

    /** @test */
    public function it_should_group_items_by_custom_keys()
    {
        $field = 'continent';
        $keys = ['Europe', 'Oceania', 'Africa'];

        $items = [
            (object) ['continent' => 'Europe',  'country' => 'France'],
            (object) ['continent' => 'Africa',  'country' => 'Algeria'],
            (object) ['continent' => 'Africa',  'country' => 'Zambia'],
            (object) ['continent' => 'Europe',  'country' => 'Germany'],
            (object) ['continent' => 'Oceania', 'country' => 'New Zealand'],
        ];

        $glossary = $this->buildEmptyGlossary($keys);

        $glossary[0]->items = [$items[0], $items[3]];
        $glossary[1]->items = [$items[4]];
        $glossary[2]->items = [$items[1], $items[2]];

        $subject = new Glossary_GlossaryService;

        $this->assertEquals(
            $glossary, $subject->buildCustom($items, $field, $keys));
    }

    /** @test */
    public function it_should_ignore_unknown_keys()
    {
        $field = 'title';
        $keys = ['Alpha', 'Bravo'];

        $items = [
            (object) ['title' => 'Alpha'],
            (object) ['title' => 'Bravo'],
            (object) ['title' => 'Charlie'],
        ];

        $glossary = $this->buildEmptyGlossary($keys);

        $glossary[0]->items = [$items[0]];
        $glossary[1]->items = [$items[1]];

        $subject = m::mock('Craft\Glossary_GlossaryService')->makePartial();
        $subject->shouldAllowMockingProtectedMethods();
        $subject->shouldReceive('logWarning')->once()->with(m::any());

        $this->assertEquals(
            $glossary, $subject->buildCustom($items, $field, $keys));
    }

    /** @test */
    public function it_should_ignore_items_without_the_property()
    {
        $field = 'title';
        $keys = ['Alpha', 'Bravo'];

        $items = [
            (object) ['title' => 'Alpha'],
            (object) ['title' => 'Bravo'],
            (object) ['slug'  => 'Bravo'],
        ];

        $glossary = $this->buildEmptyGlossary($keys);

        $glossary[0]->items = [$items[0]];
        $glossary[1]->items = [$items[1]];

        $subject = m::mock('Craft\Glossary_GlossaryService')->makePartial();
        $subject->shouldAllowMockingProtectedMethods();
        $subject->shouldReceive('logWarning')->once()->with(m::any());

        $this->assertEquals(
            $glossary, $subject->buildCustom($items, $field, $keys));
    }
}
