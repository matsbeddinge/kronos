<?php
/**
 * Helpers for the template file.
 */

$kronos->data['footer'] = <<<EOD
<p>&copy;Kronos by Mats @BTH</p>
<p>Validators: 
<a href="http://validator.w3.org/check/referer">html5</a>
<a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">css3</a>
<a href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">unicorn</a>
<a href="http://validator.w3.org/checklink?uri={$kronos->request->current_url}">links</a>
</p>
EOD;
