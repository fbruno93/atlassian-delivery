<?php

namespace bfy\Helper;

use DOMDocument;
use DOMElement;
use Exception;

class DOMHelper
{
    public static function addRowToSummary(DOMDocument $content, string $title, string $note, string $link)
    {
        $tbody = $content->getElementsByTagName('tbody')->item(0);
        $templateNode = $tbody->getElementsByTagName('tr')->item(1);

        $tr = DOMHelper::createRow($content, $title, $note, $link);
        DOMHelper::insertAfter($tr, $templateNode);
    }

    private static function createRow(DOMDocument $dom, string $title, string $note, string $link): DOMElement
    {
        $tr = $dom->createElement('tr');
        $td = $dom->createElement('td');
        $p = $dom->createElement('p', $title);
        $td->appendChild($p);
        $tr->appendChild($td);

        $td = $dom->createElement('td');
        $p = $dom->createElement('p', $note);
        $td->appendChild($p);
        $tr->appendChild($td);

        $td = $dom->createElement('td');
        $a = $dom->createElement('a', $title);
        $a->setAttribute('href', $link);
        $td->appendChild($a);
        $tr->appendChild($td);

        return $tr;
    }

    private static function insertAfter($node, $ref)
    {
        try {
            $ref->parentNode->insertBefore($node, $ref->nextSibling);
        } catch (Exception $e) {
            $ref->parentNode->appendChild($node);
        }
    }
}
