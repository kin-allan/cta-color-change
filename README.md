<p align="center">
    <h1 align="center">Nimbus CTA Color Change</h1>
    <br>
</p>

<h3>Instructions</h3>

<ul>
    <li>1. Go to the Magento root directory</li>
    <li>1. Run the command: <code>composer config repositories.kin-allan-cta-color-change git https://github.com/kin-allan/cta-color-change</code></li>
    <li>2. Then: <code>composer require kin-allan/cta-color-change:1.0.0</code></li>
    <li>3. After the composer process is finished, run those commands:</li>
    <li><code>php bin/magento module Nimbus_CTAColorChange</code></li>
    <li><code>php bin/magento setup:upgrade</code></li>
    <li><code>php bin/magento setup:di:compile</code></li>
    <li><code>php bin/magento cache:flush</code></li>
</ul>

<h3>Use</h3>
The settings for the color and background-color of the CTA button can be edited either on the admin dashboard under <code>Store->Configuration->CTA Color Change</code>
or running the CLI command.
Example:
<code>php bin/magento nimbus:cta:change 000000 1</code> Where "000000" is the hexadecimal color and "1" is the store id
