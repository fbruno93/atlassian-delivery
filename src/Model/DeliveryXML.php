<?php

namespace bfy\Model;

use bfy\Helper\Template;

class DeliveryXML extends Delivery
{
    public function __toString(): string
    {
        // Render B.L. with PHP template
        $xml = Template::render("template/template.xml.php", [
            'bl' => $this,
        ], false);

        // Remove extra spaces
        return preg_replace('/\s+/', ' ', $xml);
    }
}
