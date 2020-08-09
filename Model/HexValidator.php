<?php

namespace Nimbus\CTAColorChange\Model;

class HexValidator {

    public function validate($hexColor)
    {
        $hexColor = trim(ltrim($hexColor, "#"));

        if (preg_match('/[^A-Za-z0-9]/', $hexColor)) {
            return false;
        }

        if (strlen($hexColor) < 3) {
            return false;
        }

        return true;
    }
}
