<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
?>
<div class="margin-bottom-10 margin-top-10">
    <a href="<?php echo el_site_url("administrator/component/elSitePages?settings=terms"); ?>"
       class="btn btn-primary">
        <?php echo el_print('site:terms'); ?></a>
    <a href="<?php echo el_site_url("administrator/component/elSitePages?settings=about"); ?>"
       class="btn btn-primary">
        <?php echo el_print('site:about'); ?></a>
    <a href="<?php echo el_site_url("administrator/component/elSitePages?settings=privacy"); ?>"
       class="btn btn-primary">
        <?php echo el_print('site:privacy'); ?></a>
</div>
<?php
$settings = input('settings');
if (empty($settings)) {
    $settings = 'terms';
}
switch ($settings) {
    case 'terms':
        $params = array(
            'action' => el_site_url() . 'action/sitepage/edit/terms',
            'component' => 'elSitePages',
        );
        echo el_view_form('terms', $params, false);
        break;
    case 'about':
        $params = array(
            'action' => el_site_url() . 'action/sitepage/edit/about',
            'component' => 'elSitePages',
        );
        echo el_view_form('about', $params, false);
        break;
    case 'privacy':
        $params = array(
            'action' => el_site_url() . 'action/sitepage/edit/privacy',
            'component' => 'elSitePages',
        );
        echo el_view_form('privacy', $params, false);
        break;
}
