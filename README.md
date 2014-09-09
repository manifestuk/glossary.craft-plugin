# Craft Glossary Plugin
Many sites require some sort of "directory"[^directory-name] of items, grouped appropriately.

[^directory-name]: Sadly, the name "Directory" has [already been taken][directory-plugin].

[directory-plugin]: https://dukt.net/craft/directory "Damned squatters"

The most obvious example is a list of staff members, grouped by the first letter of their surname, but it could also be a list of offices organised by country, recipes organised by cooking method, and so forth.

It's possible to do all of this using Twig, but the result is messy and difficult to test. Glossary keeps your templates neat, and has a suite of unit tests to ensure everything runs smoothly.[^unit-tests]

[^unit-tests]: Unit testing of Craft plugins is still in its infancy, so you'll need to be comfortable digging through the code if you want to run them locally. Hopefully this will improve over time.

## Requirements
Glossary has been tested with Craft 2.1.

## Installation
1. [Download][github-download] and unzip the Glossary plugin.
2. Move the `glossary` directory to your `/craft/plugins` directory.
3. Go to the "Settings &rarr; Plugins" page in your admin area, and click on the "Install" button next to the Glossary plugin.

[github-download]: https://github.com/experience/glossary.craft/archive/master.zip "Download the latest ZIP"

## Usage
Usage instructions are provided in [the announcement blog post][announcement].

[announcement]: https://experiencehq.net/blog/glossary-craft-plugin

## Support
If you've found a bug, please [create an issue][github-issue]. If you want to shower us with praise and fiscal appreciation, you can start by [finding us on Twitter][experience-twitter].

[github-issue]: https://github.com/experience/glossary.craft/issues/new "File a bug report"
[experience-twitter]: https://twitter.com/exphq/ "The appropriate channel for mad props"
