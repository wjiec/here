<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Html_Template extends Abstract_Widget {
    private static $_template = array(
            'tplStartIdentifier' => '{',
            'tplEndIdentifier'   => '}',
            'tplVarIdentifier'   => '@',
            'tplFuncIdentifier'  => '$'
    );

    private static $_functionMapping = array(
        "/&time.format/" => "date"
    );

    # { @post_time $ (time.format("d M, Y")) }
    private static $_patterns = array(
        "/{\s*@([^\$\\.]+?)\s*}/", # Simple Variable
        "/{\s*@([a-zA-Z0-9_]*?)\\.([a-zA-Z0-9_]*?)\s*}/",
        "/{\s*@([a-zA-Z0-9_]*?)\\.([a-zA-Z0-9_]*?)\\.([a-zA-Z0-9_]*?)\s*}/",
        "/{\s*@([a-zA-Z0-9_]+)\s*\\$\s*\\(([a-zA-Z_\\.]*)\\((.*)\\)\\)\s*}/", # Simple Callback
        "/{\s*foreach\s*:\s*@([a-zA-Z0-9_]*)\s*-\s*@([a-zA-Z0-9_]*)\s*}/", # Syntax: foreach
        "/{\s*foreach\s*:\s*@([a-zA-Z0-9_]*?)\\.([a-zA-Z0-9_]*?)\s*-\s*@([a-zA-Z0-9_]*)\s*}/",
        "/{\s*foreach\s*:\s*@([a-zA-Z0-9_]*?)\\.([a-zA-Z0-9_]*?)\\.([a-zA-Z0-9_]*?)\s*-\s*@([a-zA-Z0-9_]*)\s*}/",
        "/{\s*foreach\s*:\s*@([a-zA-Z0-9_]*)\s*-\s*@([a-zA-Z0-9_]*)\s*\\+\s*@([a-zA-Z0-9_]*)\s*}/",
        "/{\s*foreach\s*:\s*@([a-zA-Z0-9_]*?)\\.([a-zA-Z0-9_]*?)\s*-\s*@([a-zA-Z0-9_]*)\s*\\+\s*@([a-zA-Z0-9_]*)\s*}/",
        "/{\s*foreach\s*:\s*@([a-zA-Z0-9_]*?)\\.([a-zA-Z0-9_]*?)\\.([a-zA-Z0-9_]*?)\s*-\s*@([a-zA-Z0-9_]*)\s*\\+\s*@([a-zA-Z0-9_]*)\s*}/",
        "/{\s*endforeach\s*}/",
        "/{\s*loop\s*}/", # Syntax: loop
        "/{\s*endloop\s*}/",
    );

    private static $_replacements = array(
        "<?php echo (isset(\$__value)) ? \$__value[\"\\1\"] : \$\\1 ?>",
        "<?php echo (isset(\$__value)) ? \$__value[\"\\1\"][\"\\2\"] : \$\\1[\"\\2\"] ?>",
        "<?php echo (isset(\$__value)) ? \$__value[\"\\1\"][\"\\2\"][\"\\3\"] : \$\\1[\"\\2\"][\"\\3\"] ?>",
        "<?php echo &\\2(\\3, $\\1) ?>",
        "<?php foreach (((isset(\$__value)) ? \$__value[\"\\1\"] : \$\\1) as \$\\2): ?>",
        "<?php foreach (((isset(\$__value)) ? \$__value[\"\\1\"][\"\\2\"] : \$\\1[\"\\2\"]) as \$\\3): ?>",
        "<?php foreach (((isset(\$__value)) ? \$__value[\"\\1\"][\"\\2\"][\"\\3\"] : \$\\1[\"\\2\"][\"\\3\"]) as \$\\4): ?>",
        "<?php foreach (((isset(\$__value)) ? \$__value[\"\\1\"] : \$\\1) as \$\\2 => \$\\3): ?>",
        "<?php foreach (((isset(\$__value)) ? \$__value[\"\\1\"][\"\\2\"] : \$\\1[\"\\2\"]) as \$\\3 => \$\\4): ?>",
        "<?php foreach (((isset(\$__value)) ? \$__value[\"\\1\"][\"\\2\"][\"\\3\"] : \$\\1[\"\\2\"][\"\\3\"]) as \$\\4 => \$\\5): ?>",
        "<?php endforeach ?>",
        "<?php foreach (\$data as \$__index => \$__value) ?>",
        "<?php endforeach ?>",
    );

    public function template($fullFileName) {
        
    }

    public function cache($filename) {
        
    }

    public function compile($string) {
        return preg_replace(array_keys(self::$_functionMapping), array_values(self::$_functionMapping), 
               preg_replace(self::$_patterns, self::$_replacements, $string));
    }
}
