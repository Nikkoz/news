<?php

namespace news\validators;

use yii\validators\RegularExpressionValidator;

class SlugValidator extends RegularExpressionValidator
{
    public $pattern = '#^[a-zA-Z0-9_-]*$#s';
}