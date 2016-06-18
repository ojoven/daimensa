<?php

namespace App\Lib;

class DomFunctions {

    // Attribute DOM
    public static function getAttributeDom($element, $attribute) {

        if (isset($element->$attribute)) {
            return $element->$attribute;
        } else {
            return false;
        }

    }

    // Traverse
    public static function getNextFromParent($html, $target, $parent, $identifier) {

        $traverser = $html->find('span[id=' . $identifier . ']', 0);
        if ($traverser) {

            // Traverse vertically
            while ($traverser->parent() && $traverser->parent()->tag!=$parent) {
                $traverser = $traverser->parent();
            }

            // Traverse horizontally
            if ($traverser->parent() && $traverser->parent()->tag==$parent) {

                $traverser = $traverser->parent();

                while ($traverser->next_sibling() && $traverser->next_sibling()->tag!=$target) {
                    $traverser = $traverser->next_sibling();
                }

                if ($traverser->next_sibling() && $traverser->next_sibling()->tag==$target) { // FOUND!

                    $traverser = $traverser->next_sibling();
                    return $traverser;

                }

            }
        }

        return false;

    }

}