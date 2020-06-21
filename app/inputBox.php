<?php
namespace App;

class InputBox
{
    public static function text($name)
    {
        return "<div class=\"form-group\">
		<label form=\"{$name}\">{$name}</label>
		<input type=\"text\" class=\"form-control\" name=\"{$name}\" id=\"{$name}\">
	</div>";
    }
}
