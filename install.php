<?php
/**
 * HERE Install Program
 * 
 * @package Here
 * @author  ShadowMan
 */

// $options->router
// ->post('install.php', function($params) {
//     if (isset($_POST['step'])) {
//         switch ((int)$_POST['step']) {
//             case '2': include 'install/step/' . (int)$_POST['step'] . '.php'; break;
//             case '3': echo '3'; break;
//             default: $params['this']->error('404', $params);
//         }
//     }
//     die();
// });

function _u($path) {
    echo 'http://' . $_SERVER['HTTP_HOST'] . '/' . $path;
}

function _fastclick() {
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if (strpos($agent, 'iphone') || strpos($agent, 'ipad') || strpos($agent, 'android') || strpos($agent, 'midp') || strpos($agent, 'ucweb')) {
        echo "<script src=\"/include/Resource/js/library/mobile/fastclick.min.js\"></script>\n";
    }
}

// TODO pjax
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Here Installer</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
    <link rel="stylesheet" href="/include/Resource/css/library/grid-alpha.css" media="all" />
    <link rel="stylesheet" href="/include/Resource/css/module/install.css" media="all" />
    <script src="/include/Resource/js/library/jquery-2.1.4.min.js"></script>
    <?php _fastclick(); ?>
    <script src="/include/Resource/js/installer.js"></script>
</head>
<body>
    <div id="_Here-Installer" class="container-fluid">
        <div class="row">
            <section id="_Here-Installer-Header" class="widget-align-vh">
                <h1>Here Installer</h1>
            </section>
            <section id="_Here-Installer-Container" class="col-xl-6 col-xl-offset-3 col-lg-7 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                <h2 class="widget-hidden">Here Installer Guide</h2>
                <div id="_Here-Replace-Container">
                    <h3>Welcome to Here.</h3>
                    <p>Here is distributed under the <a href="<?php _u('license.php'); ?>" target="_blank">MIT</a> license.</p>
                    <p>This Installer will automatically detect server environment is in line with the minimum configuration requirements. If not meet,  please follow the instructions in your host configuration information to check if the server environment to meet the requirements</p>
                </div>
            </section>
            <section id="_Here-Server-Env">
                <h3 class="widget-hidden">Detect Server Environment</h3>
            </section>
        </div>
        <div id="_Here-Next-Step" class="row">
            <div id="Btn-Container" class="col-lg-offset-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-7">
                <button id="Next-Step-Btn" class="widget-btn widget-btn-default">Next Step</button>
            </div>
        </div>
    </div>
    <footer></footer>
</body>
</html>
