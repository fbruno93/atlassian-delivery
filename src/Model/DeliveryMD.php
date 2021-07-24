<?php

namespace bfy\Model;

use bfy\Helper\Template;

class DeliveryMD extends Delivery
{
    public function __toString(): string
    {
        // Render B.L. with PHP template
        return Template::render("template/template.md.php", [
            'bl' => $this,
        ], false);
    }
}
