<?php

class Controller_Installer {
    public static function step() {
        if (!isset($_POST['step'])) {
            exit;
        }
        switch ($_POST['step']) {
            case '2': self::step2(); break;
            case '3': self::step3(); break;
            default: exit();
        }
    }
    
    private static function step2() {
?>
<section id="_Here-Setting-Form">
    <h3>Here Setting</h3>
    <form action="/controller/init/init" method="post">
        <input type="text" name="" id="" />
        <input type="text" name="" id="" />
        <input type="text" name="" id="" />
        <input type="text" name="" id="" />
        <input type="text" name="" id="" />
        <input type="text" name="" id="" />
    </form>
</section>
<?php
    }
    
    private static function step3() {
        
    }
}