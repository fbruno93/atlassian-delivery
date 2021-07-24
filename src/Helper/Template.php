<?php

namespace bfy\Helper;

/**
 * Class Template
 * manage rendering template with variables
 */
class Template
{
    public static function render($template, $variables, $print = true)
    {
        $output = NULL;
        if(file_exists($template)){
            extract($variables);

            ob_start();

            include $template;

            $output = ob_get_clean();
        }

        if ($print) {
            print $output;
        }
        
        return $output;
    } 
}
