<?php namespace Craft;

class GlossaryPlugin extends BasePlugin
{
    public function getName()
    {
        return Craft::t('Glossary');
    }

    public function getVersion()
    {
        return '0.1.0';
    }

    public function getDeveloper()
    {
        return 'Experience';
    }

    public function getDeveloperUrl()
    {
        return 'http://experiencehq.net';
    }
}
